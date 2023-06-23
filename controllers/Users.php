<?php
class Users extends Controller
{

    public function __construct()
    {
        parent::__construct();
        session_start();
    }

    public function index()
    {

        $data['title'] = 'Usuarios';
        $data['script'] = 'users.js';
        $this->views->getView('users', 'index', $data);
    }

    public function list()
    {

        $data = $this->model->getUsers(1);
        for ($i = 0; $i < count($data); $i++) {
            if ($data[$i]['rol'] == 1) {
                $data[$i]['rol'] = '<span class="badge bg-danger">Administrador</span>';
            } else {
                $data[$i]['rol'] = '<span class="badge bg-info">Empleado</span>';
            }

            $data[$i]['actions'] = '';
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function register()
    {

        if (isset($_POST)) {

            if (empty($_POST['names'])) {
                $response = array('msg' => 'El nombre es requerido', 'type' => 'warning');
            } else if (empty($_POST['lastname'])) {
                $response = array('msg' => 'El apellido es requerido', 'type' => 'warning');
            } else if (empty($_POST['email'])) {
                $response = array('msg' => 'El correo es requerido', 'type' => 'warning');
            } else if (empty($_POST['phone'])) {
                $response = array('msg' => 'El teléfono es requerido', 'type' => 'warning');
            } else if (empty($_POST['address'])) {
                $response = array('msg' => 'La dirección es requerida', 'type' => 'warning');
            } else if (empty($_POST['password'])) {
                $response = array('msg' => 'La contraseña es requerida', 'type' => 'warning');
            } else if (empty($_POST['rol'])) {
                $response = array('msg' => 'El rol es requerido', 'type' => 'warning');
            } else {
                $names = strClean($_POST['names']);
                $lastname = strClean($_POST['lastname']);
                $email = strClean($_POST['email']);
                $phone = strClean($_POST['phone']);
                $address = strClean($_POST['address']);
                $password = strClean($_POST['password']);
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $rol = strClean($_POST['rol']);

                //Check if data exist
                $checkEmail = $this->model->getValidate('email', $email);
                if (empty($checkEmail)) {
                    $checkPhone = $this->model->getValidate('phone', $phone);
                    if (empty($checkPhone)) {
                        $data = $this->model->register($names, $lastname, $email, $phone, $address, $hash, $rol);
                        if ($data > 0) {
                            $response = array('msg' => 'Usuario registrado con éxito', 'type' => 'success');
                        } else {
                            $response = array('msg' => 'Error al registrar', 'type' => 'error');
                        }
                    }else {
                        $response = array('msg' => 'El telefono ya se encuentra asociado a otro usuario', 'type' => 'warning');
                    }
                } else {
                    $response = array('msg' => 'El correo ya se encuentra asociado a otro usuario', 'type' => 'warning');
                }
            }
        } else {
            $response = array('msg' => 'Error desconocido', 'type' => 'error');
        }
        echo json_encode($response, JSON_UNESCAPED_UNICODE);
        die();
    }
}
