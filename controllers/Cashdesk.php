<?php
class Cashdesk extends Controller
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

        $data['script'] = 'cashdesk.js';
        $data['title'] = 'Movimientos en caja';
        $data['cashdesk'] = $this->model->getCashdesk($this->id_user);
        $this->views->getView('cashdesk', 'index', $data);
    }

    public function openCashdesk()
    {

        $json = file_get_contents('php://input');
        $dataSet = json_decode($json, true);
        if (empty(['amount'])) {
            $response = array('msg' => 'El valor es requerido', 'type' => 'warning');
        } else {
            $check = $this->model->getCashdesk($this->id_user);
            if (empty($check)) {
                $opening_date = date('Y-m-d');
                $initial_value = strClean($dataSet['amount']);
                $data = $this->model->openCashdesk($initial_value, $opening_date, $this->id_user);
                if ($data > 0) {
                    $response = array('msg' => 'Caja abierta con éxito', 'type' => 'success');
                } else {
                    $response = array('msg' => 'Error al abrir la caja', 'type' => 'error');
                }
            } else {
                $response = array('msg' => 'La caja ya se encuentra abierta', 'type' => 'warning');
            }
        }
        echo json_encode($response);
        die();
    }

    public function list()
    {
        $data = $this->model->getCashdesks();
        echo json_encode($data);
        die();
    }

    public function registerExpense()
    {
        if (isset($_POST['value']) && isset($_POST['description'])) {
            if (empty($_POST['value'])) {
                $response = array('msg' => 'El valor es requerido!', 'type' => 'warning');
            } else if (empty($_POST['description'])) {
                $response = array('msg' => 'La descripción es requerida', 'type' => 'warning');
            } else {
                $value = strClean($_POST['value']);
                $description = strClean($_POST['description']);
                $photo = $_FILES['photo'];
                $name = $photo['name'];
                $tmp = $photo['tmp_name'];

                $route = null;
                if (!empty($name)) {
                    $date = date('YmdHis');
                    $route = 'assets/images/expenses/' . $date . '.png';
                }
                $data = $this->model->registerExpense($value, $description, $route, $this->id_user);
                if ($data > 0) {
                    if (!empty($name)) {
                        move_uploaded_file($tmp, $route);
                    }
                    $response = array('msg' => 'Gasto registrado', 'type' => 'success');
                } else {
                    $response = array('msg' => 'Error al registrar el gasto', 'type' => 'error');
                }
                
            }
        }
        echo json_encode($response);
        die();
    }
}
