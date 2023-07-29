<?php

// somewhere early in your project's loading, require the Composer autoloader
// see: http://getcomposer.org/doc/00-intro.md
require 'vendor/autoload.php';

// reference the Dompdf namespace
use Dompdf\Dompdf;

class Quotes extends Controller{
    public function __construct() {
        parent::__construct();
        session_start();
    }

    public function index() {

        $data['title'] = 'Cotizaciones';
        $data['script'] = 'quotes.js';
        $data['search'] = 'search.js';
        $data['cart'] = 'posQuotes';
        $this->views->getView('quotes', 'index', $data);
        
    }

    public function registerQuote() {

        $json = file_get_contents('php://input');
        $dataSet = json_decode($json, true);
        $array['products'] = array();
        $total = 0;
        if (!empty($dataSet['products'])) {
            
            $date = date('Y-m-d');
            $time = date('H:i:s');
            $method = $dataSet['method'];
            $validity = $dataSet['validity'];
                        
            $discount = (!empty($dataSet['discount'])) ? $dataSet['discount'] : 0;
            $idClient = $dataSet['idClient'];
            
            if (empty($idClient)) {
                $response = array('msg' => 'El cliente es necesario', 'type' => 'warning');
            } else if (empty($method)) {
                $response = array('msg' => 'El método de pago es necesaria', 'type' => 'warning');
            } else if (empty($validity)) {
                $response = array('msg' => 'El tiempo de validez de la cotización es necesaria', 'type' => 'warning');
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
                }

                $productsData = json_encode($array['products']);
                $quote = $this->model->registerQuote($productsData, $total, $date, $time, $method, $validity, $discount, $idClient);
                if ($quote > 0) {
                    $response = array('msg' => 'Cotización realizada', 'type' => 'success', 'idQuote' => $quote);
                } else {
                    $response = array('msg' => 'Error al generar la cotización', 'type' => 'error');
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
        $idQuote = $array[1];
    
        $data['title'] = 'Reporte';
        $data['company'] = $this->model->getCompany();
        $data['quote'] = $this->model->getQuote($idQuote);
    
        //Condition for 'Page not found' error
        if (empty($data['quote'])) {
            echo 'Pagina no encontrada';
            exit;
        }
        $this->views->getView('quotes', $type, $data);
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
}
