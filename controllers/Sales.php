<?php
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
                    // $newQuantity = $result['quantity'] + $product['quantity'];
                    // $this->model->updateStock($newQuantity, $result['id']);
                }
                $productsData = json_encode($array['products']);
                $sale = $this->model->registerSale($productsData, $total, $date, $time, $paymentMethod, $idClient, $this->id_user);
                if ($sale > 0) {
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
}
