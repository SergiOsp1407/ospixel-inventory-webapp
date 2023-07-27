<?php
class Credits extends Controller{

    public function __construct() {
        parent::__construct();
        session_start();
    }
    
    public function index() {

        $data['script'] = 'credits.js';
        $data['title'] = 'Administrar créditos';
        $this->views->getView('credits', 'index', $data);
        
    }

    public function list() {

        $data = $this->model->getCredits();
        for ($i=0; $i < count($data); $i++) { 
            $result = $this->model->getPartialpayment($data[$i]['id']);
            $partialpayment = ($result['total'] == null ) ? 0 : $result['total'];
            $remainingbalance = $data[$i]['value_credit'] - $partialpayment;

            $data[$i]['value_credit'] = number_format($data[$i]['value_credit'], 2);
            $data[$i]['partialpayment'] = number_format($partialpayment, 2);
            $data[$i]['remainingbalance'] = number_format($remainingbalance, 2);
            $data[$i]['sale'] = 'N°: ' . $data[$i]['id_sale'];
            $data[$i]['actions'] = '<a class="btn btn-danger" href="#" target="_blank"><i class="fas fa-file-pdf"></i></a>';
        }

        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();        
    }

    public function search() {

        $array = array();
        $value = strClean($_GET['term']);
        $data = $this->model->searchByName($value);
        foreach ($data as $row) {
            $resultPartialPayment = $this->model->getPartialpayment($row['id']);
            $partialpayment = ($resultPartialPayment['total'] == null ) ? 0 : $resultPartialPayment['total'];
            //Calculate remainingbalance - (result - partialpayment)
            $remainingbalance = $row['value_credit'] - $partialpayment;

            $result['value_credit'] = $row['value_credit'];
            $result['partialpayment'] = $partialpayment;
            $result['remainingbalance'] = $remainingbalance;
            $result['date'] = $row['date'];

            //Clients info
            $result['id'] = $row['id'];
            $result['label'] = $row['name'];
            $result['phone'] = $row['phone'];
            $result['address'] = $row['address'];
            array_push($array, $result);
        }
        echo json_encode($array, JSON_UNESCAPED_UNICODE);
        die();
        
    }

    public function registerPartialPayment() {
        $json = file_get_contents('php://input');
        $dataSet = json_decode($json, true);
        if (!empty($dataSet)) {
            $idCredit = strClean($dataSet['idCredit']);
            $paid_value = strClean($dataSet['paid_value']);
            $data = $this->model->registerPartialPayment($paid_value, $idCredit);
            if ($data > 0) {
                $response = array('msg' => 'Abono registrado', 'type' => 'success');
            }else{
                $response = array('msg' => 'Error al registrar', 'type' => 'error');
            }
        }else {
            $response = array('msg' => 'Todos los campos son requeridos', 'type' => 'warning');
        }
        echo json_encode($response);
        die();
    }

}
