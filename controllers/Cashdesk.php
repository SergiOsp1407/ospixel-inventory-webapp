<?php
class Cashdesk extends Controller{

    private $id_user;
    public function __construct() {
        parent::__construct();
        session_start();
        $this->id_user = $_SESSION['id_user'];
    }

    public function index() {

        $data['script'] = 'cashdesk.js';
        $data['title'] = 'Movimientos en caja';
        $this->views->getView('cashdesk', 'index', $data);
        
    }

    public function openCashdesk() {

        $json = file_get_contents('php://input');
        $dataSet = json_decode($json, true);
        if (empty(['amount'])) {
            $response = array('msg' => 'El valor es requerido', 'type' => 'warning');
        }else {
            $opening_date = date('Y-m-d');
            $initial_value = strClean($dataSet['amount']);
            $data = $this->model->openCashdesk($initial_value, $opening_date, $this->id_user);
            if ($data > 0) {
                $response = array('msg' => 'Caja abierta con éxito', 'type' => 'success');
            } else {
                $response = array('msg' => 'Error al abrir la caja', 'type' => 'ERROR');
            }
            
        }
        echo json_encode($response);
        die();
        
    }

    
}
?>