<?php

// somewhere early in your project's loading, require the Composer autoloader
// see: http://getcomposer.org/doc/00-intro.md
require 'vendor/autoload.php';

// reference the Dompdf namespace
use Dompdf\Dompdf;


class Sales extends Controller
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
        $data['title'] = 'Ventas';
        $data['script'] = 'sales.js';
        $data['search'] = 'search.js';
        $data['cart'] = 'posSale';
        $resultSerie = $this->model->getSerie();
        $serie = ($resultSerie['total'] == null) ? 1 : $resultSerie['total'] + 1;
        $data['serie'] = $this->generate_numbers($serie, 1, 8);
        $this->views->getView('sales', 'index', $data);
    }

    public function registerSale()
    {

        $json = file_get_contents('php://input');
        $dataSet = json_decode($json, true);
        $array['products'] = array();
        $total = 0;
        if (!empty($dataSet['products'])) {

            $date = date('Y-m-d');
            $time = date('H:i:s');
            $paymentMethod = $dataSet['paymentMethod'];

            $resultSerie = $this->model->getSerie();
            $numSerie = ($resultSerie['total'] == null) ? 1 : $resultSerie['total'] + 1;
            $serie = $this->generate_numbers($numSerie, 1, 8);

            $discount = (!empty($dataSet['discount'])) ? $dataSet['discount'] : 0;
            $idClient = $dataSet['idClient'];

            if (empty($idClient)) {
                $response = array('msg' => 'El cliente es necesario', 'type' => 'warning');
            } else if (empty($paymentMethod)) {
                $response = array('msg' => 'El método de pago es necesaria', 'type' => 'warning');
            } else {
                foreach ($dataSet['products'] as $product) {
                    $result = $this->model->getProduct($product['id']);
                    $data['id'] = $result['id'];
                    $data['description'] = $result['description'];
                    $data['price'] = $result['sale_price'];
                    $data['quantity'] = $product['quantity'];
                    $subTotal = $result['sale_price'] * $product['quantity'];
                    array_push($array['products'], $data);
                    $total += $subTotal;

                    //Update stock
                    $newQuantity = $result['quantity'] - $product['quantity'];
                    $this->model->updateStock($newQuantity, $result['id']);
                }

                $productsData = json_encode($array['products']);
                $sale = $this->model->registerSale($productsData, $total, $date, $time, $paymentMethod, $discount, $serie[0], $idClient, $this->id_user);
                if ($sale > 0) {
                    if ($paymentMethod == 'credit') {
                        $valueCredit = $total - $discount;
                        $this->model->registerCredits($valueCredit, $sale);
                    }
                    $response = array('msg' => 'Venta realizada', 'type' => 'success', 'idSale' => $sale);
                } else {
                    $response = array('msg' => 'Error al generar la venta', 'type' => 'error');
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
        $array = explode(',', $dataSet);
        $type = $array[0];
        $idSale = $array[1];

        $data['title'] = 'Reporte';
        $data['company'] = $this->model->getCompany();
        $data['sale'] = $this->model->getSale($idSale);

        //Condition for 'Page not found' error
        if (empty($data['sale'])) {
            echo 'Pagina no encontrada';
            exit;
        }
        $this->views->getView('sales', $type, $data);
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
