<?php
class Clients extends Controller
{
    public function __construct()
    {
        parent::__construct();
        session_start();
    }

    public function index()
    {
        $data['title'] = 'Clientes';
        $data['script'] = 'clients.js';
        $this->views->getView('clients', 'index', $data);
    }

    public function list()
    {

        $data = $this->model->getClients(1);
        for ($i = 0; $i < count($data); $i++) {
            $data[$i]['actions'] = '<div>
            <button class="btn btn-danger" type="button" onclick="deleteClient(' . $data[$i]['id'] . ')"><i class="fas fa-trash"></i></button>
            <button class="btn btn-info" type="button" onclick="editClient(' . $data[$i]['id'] . ')"><i class="fas fa-edit"></i></button>
            </div>';
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function register()
    {
        if (isset($_POST['identity_type']) && isset($_POST['client_identity'])) {
            $id = strClean($_POST['id']);
            $identity_type = strClean($_POST['identity_type']);
            $client_identity = strClean($_POST['client_identity']);
            $name = strClean($_POST['name']);
            $phone = strClean($_POST['phone']);
            $email  = (empty($_POST['email'])) ? null : strClean($_POST['email']);
            $address = strClean($_POST['address']);

            if (empty($identity_type)) {
                $response = array('msg' => 'El tipo de identificación es requerido', 'type' => 'warning');
            } else if (empty($client_identity)) {
                $response = array('msg' => 'El número de identificación es requerido', 'type' => 'warning');
            } else if (empty($name)) {
                $response = array('msg' => 'El nombre del cliente es requerido', 'type' => 'warning');
            } else if (empty($phone)) {
                $response = array('msg' => 'El teléfono del cliente es requerido', 'type' => 'warning');
            } else if (empty($address)) {
                $response = array('msg' => 'La dirección del cliente es requerida', 'type' => 'warning');
            } else {
                if ($id == '') {
                    $checkIdentity = $this->model->getValidate('client_identity', $client_identity, 'register', 0);
                    if (empty($checkIdentity)) {
                        $checkPhone = $this->model->getValidate('phone', $phone, 'register', 0);
                        if (empty($checkPhone)) {
                            if ($email != null) {
                                $checkEmail = $this->model->getValidate('email', $email, 'register', 0);
                                if (!empty($checkEmail)) {
                                    $response = array('msg' => 'El correo debe ser único', 'type' => 'warning');
                                    echo json_encode($response);
                                    die();
                                }
                            }
                            $data = $this->model->register($identity_type, $client_identity, $name, $phone, $email, $address);
                            if ($data > 0) {
                                $response = array('msg' => 'Cliente registrado', 'type' => 'success');
                            } else {
                                $response = array('msg' => 'Error al registrar el cliente', 'type' => 'error');
                            }
                        } else {
                            $response = array('msg' => 'El teléfono debe ser único', 'type' => 'warning');
                        }
                    } else {
                        $response = array('msg' => 'El número de identificación debe ser único', 'type' => 'warning');
                    }
                } else {
                    $checkIdentity = $this->model->getValidate('client_identity', $client_identity, 'edit', $id);
                    if (empty($checkIdentity)) {
                        $checkPhone = $this->model->getValidate('phone', $phone, 'edit', $id);
                        if (empty($checkPhone)) {
                            if ($email != null) {
                                $checkEmail = $this->model->getValidate('email', $email, 'edit', $id);
                                if (!empty($checkEmail)) {
                                    $response = array('msg' => 'El correo debe ser único', 'type' => 'warning');
                                    echo json_encode($response);
                                    die();
                                }
                            }
                            $data = $this->model->update($identity_type, $client_identity, $name, $phone, $email, $address, $id);
                            if ($data > 0) {
                                $response = array('msg' => 'Cliente modificado', 'type' => 'success');
                            } else {
                                $response = array('msg' => 'Error al modificar el cliente', 'type' => 'error');
                            }
                        } else {
                            $response = array('msg' => 'El teléfono debe ser único', 'type' => 'warning');
                        }
                    } else {
                        $response = array('msg' => 'El número de identificación debe ser único', 'type' => 'warning');
                    }
                }
            }
        } else {
            $response = array('msg' => 'Error desconocido', 'type' => 'error');
        }
        echo json_encode($response);
        die();
    }

    public function delete($idClient)
    {

        if (isset($_GET) && is_numeric($idClient)) {
            $data = $this->model->delete(0, $idClient);
            if ($data > 0) {
                $response = array('msg' => 'Cliente desactivado con éxito', 'type' => 'success');
            } else {
                $response = array('msg' => 'Error al desactivar el cliente', 'type' => 'error');
            }
        } else {
            $response = array('msg' => 'Error desconocido', 'type' => 'error');
        }
        echo json_encode($response, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function edit($idClient)
    {

        $data = $this->model->edit($idClient);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function inactives() {

        $data['title'] = 'Clientes inactivos';
        $data['script'] = 'inactive-clients.js';
        $this->views->getView('clients', 'inactives', $data);
        
    }

    public function listInactives()
    {

        $data = $this->model->getClients(0);
        for ($i = 0; $i < count($data); $i++) {
            $data[$i]['actions'] = '<div>
            <button class="btn btn-success" type="button" onclick="reactivateClient(' . $data[$i]['id'] . ')"><i class="fas fa-check-circle"></i></button>
            </div>';
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function reactivate($idClient)
    {

        if (isset($_GET) && is_numeric($idClient)) {
            $data = $this->model->delete(1, $idClient);
            if ($data > 0) {
                $response = array('msg' => 'Cliente reactivado con éxito', 'type' => 'success');
            } else {
                $response = array('msg' => 'Error al reactivar el cliente', 'type' => 'error');
            }
        } else {
            $response = array('msg' => 'Error desconocido', 'type' => 'error');
        }
        echo json_encode($response, JSON_UNESCAPED_UNICODE);
        die();
    }

    //Search client using the name for purchases
    public function search()
    {

        $array = array();
        $value = strClean($_GET['term']);
        $data = $this->model->searchByName($value);
        foreach ($data as $row) {
            $result['id'] = $row['id'];
            $result['label'] = $row['name'];
            $result['phone'] = $row['phone'];
            $result['address'] = $row['address'];
            array_push($array, $result);
        }
        echo json_encode($array, JSON_UNESCAPED_UNICODE);
        die();
    }
}
