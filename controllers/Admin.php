<?php
class Admin extends Controller
{

    public function __construct()
    {
        parent::__construct();
        session_start();
    }

    //Graphic reports
    public function index()
    {

        $data['title'] = 'Panel Administrativo';
        $data['script'] = 'index.js';
        $this->views->getView('admin', 'home', $data);
    }

    //Company information
    public function data()
    {

        $data['title'] = 'Información de la Empresa';
        $data['script'] = 'admin.js';
        $data['company'] = $this->model->getData();
        $this->views->getView('admin', 'index', $data);
    }

    //Edit company info
    public function edit()
    {

        if (isset($_POST)) {

            $nit = strClean($_POST['nit']);
            $name = strClean($_POST['name']);
            $phone = strClean($_POST['phone']);
            $email = strClean($_POST['email']);
            $address = strClean($_POST['address']);
            $tax = strClean($_POST['tax']);
            $message = strClean($_POST['message']);
            $id = strClean($_POST['id']);

            if (empty($nit)) {
                $response = array('msg' => 'El NIT es obligatorio', 'type' => 'warning');
            } else if (empty($name)) {
                $response = array('msg' => 'El nombre es obligatorio', 'type' => 'warning');
            } else if (empty($phone)) {
                $response = array('msg' => 'El teléfono es obligatorio', 'type' => 'warning');
            } else if (empty($email)) {
                $response = array('msg' => 'El correo es obligatorio', 'type' => 'warning');
            } else if (empty($address)) {
                $response = array('msg' => 'La dirección es obligatorio', 'type' => 'warning');
            } else {
                $data = $this->model->update($nit, $name, $phone, $email, $address, $tax, $message, $id);
                if ($data == 1) {
                    $response = array('msg' => 'Datos modificados correctamente', 'type' => 'success');
                } else {
                    $response = array('msg' => 'Error al modificar los datos', 'type' => 'error');
                }
            }
        } else {
            $response = array('msg' => 'Error desconocido ', 'type' => 'warning');
        }
        echo json_encode($response, JSON_UNESCAPED_UNICODE);
        die();
    }
}
