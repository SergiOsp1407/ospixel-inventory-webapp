<?php

// somewhere early in your project's loading, require the Composer autoloader
// see: http://getcomposer.org/doc/00-intro.md
require 'vendor/autoload.php';

//Using the printer funcionality with composer
use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

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
                $checkCashdesk =  $this->model->getCashdesk($this->id_user);
                if (empty($checkCashdesk['initial_value'])) {
                    $response = array('msg' => 'La caja está cerrada', 'type' => 'warning');
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
                    $sale = $this->model->registerSale($productsData, $total, $date, $time, $paymentMethod, $discount, $serie[0], $idClient, $this->id_user);
                    if ($sale > 0) {
                        foreach ($dataSet['products'] as $product) {
                            $result = $this->model->getProduct($product['id']);
                            //Update stock
                            $newQuantity = $result['quantity'] - $product['quantity'];
                            $this->model->updateStock($newQuantity, $result['id']);

                            $transaction = 'Venta N°: ' . $sale;
                            $quantity = $product['quantity'];
                            $this->model->recordTransaction($transaction, 'output', $quantity, $newQuantity, $product['id'], $this->id_user);
                        }

                        if ($paymentMethod == 'credito') {
                            $valueCredit = $total - $discount;
                            $this->model->registerCredits($valueCredit, $date, $time, $sale);
                        }
                        // if ($dataSet['print']) {
                        //     $this->directPrinting($sale);
                        // }

                        $response = array('msg' => 'Venta realizada', 'type' => 'success', 'idSale' => $sale);
                    } else {
                        $response = array('msg' => 'Error al generar la venta', 'type' => 'error');
                    }
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

    //Historic sales
    public function list()
    {
        $data = $this->model->getSales();
        for ($i = 0; $i < count($data); $i++) {
            if ($data[$i]['status'] == 1) {
                $data[$i]['actions'] = '<div>
                <a class="btn btn-warning" href="#" onclick="cancelSale(' . $data[$i]['id'] . ')"><i class="fas fa-trash"></i></a>            
                <a class="btn btn-danger" href="#" onclick="viewReport(' . $data[$i]['id'] . ')"><i class="fas fa-file-pdf"></i></a>            
                </div>';
            } else {
                $data[$i]['actions'] = '<div>
                <span class="badge bg-dark">Anulado</span>
                <a class="btn btn-danger" href="#" onclick="viewReport(' . $data[$i]['id'] . ')"><i class="fas fa-file-pdf"></i></a>            
                </div>';
            }
        }
        echo json_encode($data);
        die();
    }

    //Function to update stock after cancel the sale
    public function cancel($idSale)
    {

        if (isset($_GET) && is_numeric($idSale)) {
            $data = $this->model->cancel($idSale);
            if ($data == 1) {
                $resultSale = $this->model->getSale($idSale);
                $saleProduct = json_decode($resultSale['products'], true);
                foreach ($saleProduct as $product) {
                    $result = $this->model->getProduct($product['id']);
                    //Update stock
                    $newQuantity = $result['quantity'] + $product['quantity'];
                    $this->model->updateStock($newQuantity, $product['id']);

                    //Transactions of products for inventory
                    $transaction = 'Devolución Venta N°: ' . $idSale;
                    $this->model->recordTransaction($transaction, 'input', $product['quantity'], $newQuantity, $product['id'], $this->id_user);
                }
                if ($resultSale['payment_method'] == 'credito') {
                    $this->model->cancelCredit($idSale);
                }
                $response = array('msg' => 'Venta anulada', 'type' => 'success');
            } else {
                $response = array('msg' => 'Error al anular la venta', 'type' => 'error');
            }
        } else {
            $response = array('msg' => 'Error desconocido', 'type' => 'error');
        }
        echo json_encode($response);
        die();
    }

    // //Function to print in special paper
    // public function directPrinting($idSale)
    // {

    //     $company = $this->model->getCompany();
    //     $sale = $this->model->getSale($idSale);

    //     $printer_name = "POS-58";
    //     $connector = new WindowsPrintConnector($printer_name);
    //     $printer = new Printer($connector);

    //     // Align the items at the center
    //     $printer->setJustification(Printer::JUSTIFY_CENTER);

    //     // Try printing and catch any error
    //     try {
    //         $logo = EscposImage::load("assets/images/icon_logo_os.png", false);
    //         $printer->bitImage($logo);
    //     } catch (Exception $e) {
    //     }

    //     //Header
    //     $printer->text($company['name'] . "\n");
    //     $printer->text('NIT: ' . $company['nit'] . "\n");
    //     $printer->text('Teléfono: ' . $company['phone'] . "\n");
    //     $printer->text('Dirección: ' . $company['address'] . "\n");
    //     // Date
    //     $printer->text(date("Y-m-d H:i:s") . "\n");

    //     //Clients data
    //     $printer->text($sale['identity_type'] . ': ' . $company['client_identity'] . "\n");
    //     $printer->text('Nombre: ' . $company['name'] . "\n");
    //     $printer->text('Teléfono: ' . $company['phone'] . "\n");
    //     $printer->text('Dirección: ' . $company['address'] . "\n");


    //     //Show total
    //     $total = 0;
    //     $products = json_decode($sale['products'], true);
    //     foreach ($products as $product) {
    //         $total += $product['quantity'] * $product['sale_price'];

    //         //Left justification
    //         $printer->setJustification(Printer::JUSTIFY_LEFT);
    //         $printer->text($product['quantity'] . "x" . $product['description'] . "\n");

    //         //Right justification
    //         $printer->setJustification(Printer::JUSTIFY_RIGHT);
    //         $printer->text(' $' . $product['sale_price'] . "\n");
    //     }

    //     //Printing the total
    //     $printer->text("--------\n");
    //     $printer->text("TOTAL: $" . $total . "\n");


    //     //Footer in printing
    //     $printer->text($company['message']);


    //     //Feeding the printer
    //     $printer->feed(3);

    //     //Shocutting the format
    //     $printer->cut();

    //     //Pulse to wake up the printer
    //     $printer->pulse();

    //     //Closing the connection to print
    //     $printer->close();
    // }

    function checkStock($idProduct)
    {
        $data = $this->model->getProduct($idProduct);
        echo json_encode($data);
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
