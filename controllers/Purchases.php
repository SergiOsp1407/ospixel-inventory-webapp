<?php
// somewhere early in your project's loading, require the Composer autoloader
// see: http://getcomposer.org/doc/00-intro.md
require 'vendor/autoload.php';

// reference the Dompdf namespace
use Dompdf\Dompdf;

class Purchases extends Controller
{
    private $id_user;


    public function __construct()
    {
        parent::__construct();
        session_start();
        $this->id_user = $_SESSION['id_user'];
    }

    public function index()
    {
        $data['title'] = 'Purchases';
        $data['script'] = 'purchases.js';
        $data['search'] = 'search.js';
        $data['cart'] = 'posPurchase';
        $this->views->getView('purchases', 'index', $data);
    }

    public function registerPurchase()
    {

        $json = file_get_contents('php://input');
        $dataSet = json_decode($json, true);
        $array['products'] = array();
        $total = 0;
        if (!empty($dataSet['products'])) {

            $index = $dataSet['serie'];
            // $numberSerie used to create the count for the serie of everyone purchase
            $numberSerie = $this->generate_numbers($index, 1, 8);
            $date = date('Y-m-d');
            $time = date('H:i:s');
            $serie = $numberSerie[0];
            $idSupplier = $dataSet['idSupplier'];

            if (empty($idSupplier)) {
                $response = array('msg' => 'El proveedor es necesario', 'type' => 'warning');
            } else if (empty($serie)) {
                $response = array('msg' => 'La serie es necesaria', 'type' => 'warning');
            } else {
                foreach ($dataSet['products'] as $product) {
                    $result = $this->model->getProduct($product['id']);
                    $data['id'] = $result['id'];
                    $data['description'] = $result['description'];
                    $data['price'] = $result['purchase_price'];
                    $data['quantity'] = $product['quantity'];
                    $subTotal = $result['purchase_price'] * $product['quantity'];
                    array_push($array['products'], $data);
                    $total += $subTotal;

                    //Update stock
                    $newQuantity = $result['quantity'] + $product['quantity'];
                    $this->model->updateStock($newQuantity, $result['id']);
                }
                $productsData = json_encode($array['products']);
                $purchase = $this->model->registerPurchase($productsData, $total, $date, $time, $serie, $idSupplier, $this->id_user);
                if ($purchase > 0) {
                    $response = array('msg' => 'Compra realizada', 'type' => 'success', 'idPurchase' => $purchase);
                } else {
                    $response = array('msg' => 'Error al generar la compra', 'type' => 'error');
                }
            }
        } else {
            $response = array('msg' => 'Carrito vacío', 'type' => 'warning');
        }

        echo json_encode($response);
        die();
    }

    //Using Dompdf for invoices and tickets
    public function report($dataSet)
    {
        ob_start();
        $array = explode(',', $dataSet);
        $type = $array[0];
        $idPurchase = $array[1];

        $data['title'] = 'Reporte';
        $data['company'] = $this->model->getCompany();
        $data['purchase'] = $this->model->getPurchase($idPurchase);

        //Condition for 'Page not found' error
        if (empty($data['purchase'])) {
            echo 'Pagina no encontrada';
            exit;
        }
        $this->views->getView('purchases', $type, $data);
        $html = ob_get_clean();

        // instantiate and use the dompdf class
        $dompdf = new Dompdf();
        $options = $dompdf->getOptions();
        $options->set('isJavascriptEnabled', true);
        $options->set('isRemoteEnabled', true);
        $dompdf->setOptions($options);
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation
        // $dompdf->setPaper(array(0, 0, 222, 841), 'portrait');
        // $dompdf->setPaper('letter', 'portrait');
        if ($type == 'receipt') {
            $dompdf->setPaper(array(0, 0, 500, 700), 'portrait');
        } else {
            $dompdf->setPaper('A4', 'vertical');
        }

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser
        if ($type == 'receipt') {
            $dompdf->stream('Tirilla.pdf', array('Attachment' => false));            
        } else {            
            $dompdf->stream('Factura.pdf', array('Attachment' => false));
        }
    }

    //Historic purchases
    public function list()
    {
        $data = $this->model->getPurchases();
        for ($i = 0; $i < count($data); $i++) {
            if ($data[$i]['status'] == 1) {
                $data[$i]['actions'] = '<div>
                <a class="btn btn-warning" href="#" onclick="cancelPurchase(' . $data[$i]['id'] . ')"><i class="fas fa-trash"></i></a>            
                <a class="btn btn-danger" href="#" onclick="viewReport(' . $data[$i]['id'] . ')"><i class="fas fa-file-pdf"></i></a>            
                </div>';
            }else {                
                $data[$i]['actions'] = '<div>
                <span class="badge bg-dark">Anulado</span>
                <a class="btn btn-danger" href="#" onclick="viewReport(' . $data[$i]['id'] . ')"><i class="fas fa-file-pdf"></i></a>            
                </div>';
            }
        }
        echo json_encode($data);
        die();
    }

    //Function to update stock after cancel the purchase
    public function cancel($idPurchase)
    {

        if (isset($_GET) && is_numeric($idPurchase)) {
            $data = $this->model->cancel($idPurchase);
            if ($data == 1) {
                $resultPurchase = $this->model->getPurchase($idPurchase);
                $purchaseProduct = json_decode($resultPurchase['products'], true);
                foreach ($purchaseProduct as $product) {
                    $result = $this->model->getProduct($product['id']);
                    //Update stock
                    $newQuantity = $result['quantity'] - $product['quantity'];
                    $this->model->updateStock($newQuantity, $product['id']);
                }
                $response = array('msg' => 'Compra anulada', 'type' => 'success');
            } else {
                $response = array('msg' => 'Error al anular la compra', 'type' => 'error');
            }
        } else {
            $response = array('msg' => 'Error desconocido', 'type' => 'error');
        }
        echo json_encode($response);
        die();
    }

    //Function to create the serialization of receipts and invoices
    function generate_numbers($start, $count, $digits)
    {

        $result = array();
        for ($n = $start; $n < $start + $count; $n++) {
            $result[] = str_pad($n, $digits, "0", STR_PAD_LEFT);
        }
        return $result;
    }
}
