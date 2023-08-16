<?php
// somewhere early in your project's loading, require the Composer autoloader
// see: http://getcomposer.org/doc/00-intro.md
require 'vendor/autoload.php';

// reference the Dompdf namespace
use Dompdf\Dompdf;

class Credits extends Controller{
    private $id_user;
    public function __construct() {
        parent::__construct();
        session_start();
        $this->id_user = $_SESSION['id_user'];
    }
    
    public function index() {

        $data['script'] = 'credits.js';
        $data['title'] = 'Administrar créditos';
        $this->views->getView('credits', 'index', $data);
        
    }

    public function list() {

        $data = $this->model->getCredits();
        for ($i=0; $i < count($data); $i++) { 
            $credit = $this->model->getCredit($data[$i]['id']);
            $result = $this->model->getPartialpayment($data[$i]['id']);
            $partialpayment = ($result['total'] == null ) ? 0 : $result['total'];
            $remainingbalance = $data[$i]['value_credit'] - $partialpayment;
            if ($remainingbalance < 1 && $credit['status'] = 1) {
                $this->model->updateCredit(0, $data[$i]['id']);
            }

            $data[$i]['value_credit'] = number_format($data[$i]['value_credit'], 2);
            $data[$i]['partialpayment'] = number_format($partialpayment, 2);
            $data[$i]['remainingbalance'] = number_format($remainingbalance, 2);
            $data[$i]['sale'] = 'N°: ' . $data[$i]['id_sale'];
            $data[$i]['actions'] = '<a class="btn btn-danger" href="'.BASE_URL.'credits/report/'.$data[$i]['id'].'" target="_blank"><i class="fas fa-file-pdf"></i></a>';
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
            $data = $this->model->registerPartialPayment($paid_value, $idCredit, $this->id_user);
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

    
    //Using Dompdf for invoices and tickets
    public function report($idCredit)
    {    
        ob_start();
        $data['title'] = 'Reporte';
        $data['company'] = $this->model->getCompany();
        $data['credit'] = $this->model->getCredit($idCredit);
        $data['partialpayments'] = $this->model->getPartialPayments($idCredit);
    
        //Condition for 'Page not found' error
        if (empty($data['credit'])) {
            echo 'Pagina no encontrada';
            exit;
        }
        $this->views->getView('credits', 'report', $data);
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
        $dompdf->stream('Report.pdf', array('Attachment' => false));
    }

    public function listPartialPayments() {
        $data = $this->model->getHistorialPartialPayments();
        for ($i=0; $i < count($data); $i++) { 
            $data[$i]['credit'] = 'N°: ' . $data[$i]['id_credit'];
        }
        echo json_encode($data);
        die();
    }

}
