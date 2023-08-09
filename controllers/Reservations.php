<?php

// somewhere early in your project's loading, require the Composer autoloader
// see: http://getcomposer.org/doc/00-intro.md
require 'vendor/autoload.php';

// reference the Dompdf namespace
use Dompdf\Dompdf;

class Reservations extends Controller
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
        $data['script'] = 'reservations.js';
        $data['title'] = 'Reservaciones';
        $data['search'] = 'search.js';
        $data['cart'] = 'posReservations';
        $this->views->getView('reservations', 'index', $data);
    }

    public function registerReservation()
    {

        $json = file_get_contents('php://input');
        $dataSet = json_decode($json, true);
        $array['products'] = array();
        $total = 0;
        if (!empty($dataSet['products'])) {
            $date_create = date('Y-m-d');
            $date_reservation = $dataSet['date_reservation'] . ' ' . date('H:i:s');
            $date_retirement = $dataSet['date_retirement'] . ' 23:59:59';
            $partialPayment = $dataSet['partialPayment'];
            $color = $dataSet['color'];
            $idClient = $dataSet['idClient'];

            if (empty($idClient)) {
                $response = array('msg' => 'El cliente es necesario', 'type' => 'warning');
            } else if (empty($date_reservation)) {
                $response = array('msg' => 'La fecha de reserva es necesaria', 'type' => 'warning');
            } else if (empty($date_retirement)) {
                $response = array('msg' => 'La fecha de reserva retiro del producto es necesaria', 'type' => 'warning');
            } else if (empty($partialPayment)) {
                $response = array('msg' => 'El valor del abono es necesario', 'type' => 'warning');
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
                $reservation = $this->model->registerReservation($productsData, $date_create, $date_reservation, $date_retirement, $partialPayment, $total, $color, $idClient);
                if ($reservation > 0) {
                    foreach ($dataSet['products'] as $product) {
                        $result = $this->model->getProduct($product['id']);
                        //Update stock
                        $newQuantity = $result['quantity'] + $product['quantity'];
                        $this->model->updateStock($newQuantity, $result['id']);

                        //Transactions of products for inventory
                        $transaction = 'Reservación N°: ' . $reservation;
                        $this->model->recordTransaction($transaction, 'output', $product['quantity'], $newQuantity,$product['id'], $this->id_user);
                    }
                    $response = array('msg' => 'Reservación realizada', 'type' => 'success', 'idReservation' => $reservation);
                } else {
                    $response = array('msg' => 'Error al generar la reservación', 'type' => 'error');
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
        $idReservation = $array[1];

        $data['title'] = 'Reporte';
        $data['company'] = $this->model->getCompany();
        $data['reservation'] = $this->model->getReservation($idReservation);

        //Condition for 'Page not found' error
        if (empty($data['reservation'])) {
            echo 'Pagina no encontrada';
            exit;
        }
        $this->views->getView('reservations', $type, $data);
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

    public function list()
    {
        $data = $this->model->getReservations();
        for ($i = 0; $i < count($data); $i++) {
            $status = ($data[$i]['status'] == 0) ? 'Completado' : 'Pendiente';

            $data[$i]['title'] = $status . ' - ' . $data[$i]['name'];
            $data[$i]['start'] = $data[$i]['date_reservation'];
            $data[$i]['end'] = $data[$i]['date_retirement'];
        }
        echo json_encode($data);
        die();
    }

    public function showData($idReservation)
    {
        $data = $this->model->getReservation($idReservation);
        echo json_encode($data);
        die();
    }

    public function processRetirement($idReservation)
    {
        $reservation = $this->model->getReservation($idReservation);
        $data = $this->model->processRetirement($reservation['total'], 0, $idReservation);
        if ($data == 1) {
            $response = array('msg' => 'Procesado con éxito', 'type' => 'success');
        } else {
            $response = array('msg' => 'Error al procesar', 'type' => 'error');
        }

        echo json_encode($response, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function listHistory()
    {
        $data = $this->model->getReservations();
        for ($i = 0; $i < count($data); $i++) {
            if ($data[$i]['status'] == 0) {
                $data[$i]['status'] = '<span class="badge bg-success">Completado</span>';
            } else {
                $data[$i]['status'] = '<span class="badge bg-danger">Pendiente</span>';
            }

            $data[$i]['name'] = '<span class="badge" style="background: ' . $data[$i]['color'] . ';">' . $data[$i]['name'] . '</span>';
            $data[$i]['actions'] = '<a class="btn btn-danger" href="#" onclick="viewReport(' . $data[$i]['id'] . ')"><i class="fas fa-file-pdf"></i></a>';
        }
        echo json_encode($data);
        die();
    }
}
