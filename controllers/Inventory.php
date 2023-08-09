<?php
// somewhere early in your project's loading, require the Composer autoloader
// see: http://getcomposer.org/doc/00-intro.md
require 'vendor/autoload.php';

// reference the Dompdf namespace
use Dompdf\Dompdf;

class Inventory extends Controller
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
        $data['title'] = 'Inventario';
        $data['script'] = 'inventory.js';
        $this->views->getView('inventory', 'index', $data);
    }

    public function listTransactions($dataSet)
    {

        if (empty($dataSet)) {
            $data = $this->model->getTransactions($this->id_user);
        } else {
            $array = explode('-', $dataSet);
            $year = $array[0];
            $month = $array[1];
            $data = $this->model->getTransactionsMonth($year, $month, $this->id_user);
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function report($dataSet)
    {

        $data['company'] = $this->model->getCompany();

        if (empty($dataSet)) {
            $data['inventory'] = $this->model->getTransactions($this->id_user);
        } else {
            $array = explode('-', $dataSet);
            $year = $array[0];
            $month = $array[1];
            $data['inventory'] = $this->model->getTransactionsMonth($year, $month, $this->id_user);
        }

        ob_start();
        $this->views->getView('inventory', 'report', $data);
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
        $dompdf->setPaper('A4', 'vertical');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser
        $dompdf->stream('Reporte.pdf', array('Attachment' => false));
    }

    public function processAdjustment()
    {

        $json = file_get_contents('php://input');
        $dataSet = json_decode($json, true);

        if (empty($dataSet['idProduct'])) {
            $response = array('msg' => 'No has seleccionado ningún producto', 'type' => 'warning');
        } else if (empty($dataSet['quantity'])) {
            $response = array('msg' => 'La cantidad es necesaria', 'type' => 'warning');
        } else {
            if (is_numeric($dataSet['idProduct']) && is_numeric($dataSet['quantity'])) {
                $idProduct = $dataSet['idProduct'];
                $quantity = $dataSet['quantity'];
                $product = $this->model->getProduct($idProduct);
                $newQuantity = $product['quantity'] + $quantity;
                $data = $this->model->processAdjustment($newQuantity, $idProduct);
                if ($data == 1) {
                    //Transactions of products for inventory
                    $quantityInventory = abs($quantity);
                    $action = ($quantity > 0) ? 'input' : 'output' ;
                    $transaction = 'Ajuste Inventario: ' . $action;
                    
                    $this->model->recordTransaction($transaction, $action, $quantityInventory, $newQuantity, $idProduct, $this->id_user);
                    $response = array('msg' => 'Ajuste en el stock realizado!', 'type' => 'success');
                } else {
                    $response = array('msg' => 'Error al realizar el ajuste', 'type' => 'error');
                }
            }
        }

        echo json_encode($response);
        die();
    }

    //Kardex
    public function kardex($idProduct) {

        $data['company'] = $this->model->getCompany();
        $data['kardex'] =$this->model->getKardex($idProduct, $this->id_user);
        for ($i=0; $i < count($data['kardex']); $i++) { 
            $data['kardex'][$i]['input'] = 0;
            $data['kardex'][$i]['output'] = 0;
            if ($data['kardex'][$i]['action'] == 'output') {
                $data['kardex'][$i]['output'] = $data['kardex'][$i]['quantity'];
            }else{
                $data['kardex'][$i]['input'] = $data['kardex'][$i]['quantity'];
            }
        }
        ob_start();
        $this->views->getView('inventory', 'kardex', $data);
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
        $dompdf->setPaper('A4', 'vertical');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser
        $dompdf->stream('Reporte.pdf', array('Attachment' => false));

        
    }
}
