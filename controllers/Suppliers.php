<?php
class Suppliers extends Controller
{
    public function __construct()
    {
        parent::__construct();
        session_start();
    }

    public function index()
    {

        $data['title'] = 'Proveedores';
        $data['script'] = 'suppliers.js';
        $this->views->getView('suppliers', 'index', $data);
    }

    public function list()
    {

        $data = $this->model->getSuppliers(1);
        for ($i = 0; $i < count($data); $i++) {
            $data[$i]['actions'] = '<div>
            <button class="btn btn-danger" type="button" onclick="deleteSupplier(' . $data[$i]['id'] . ')"><i class="fas fa-trash"></i></button>
            <button class="btn btn-info" type="button" onclick="editSupplier(' . $data[$i]['id'] . ')"><i class="fas fa-edit"></i></button>
            </div>';
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function register()
    {
        if (isset($_POST['nit']) && isset($_POST['name'])) {
            $id = strClean($_POST['id']);
            $nit = strClean($_POST['nit']);
            $name = strClean($_POST['name']);
            $phone = strClean($_POST['phone']);
            $email  = strClean($_POST['email']);
            $address = strClean($_POST['address']);
            if (empty($nit)) {
                $response = array('msg' => 'El NIT es requerido', 'type' => 'warning');
            } else if (empty($name)) {
                $response = array('msg' => 'El nombre del proveedor es requerido', 'type' => 'warning');
            } else if (empty($phone)) {
                $response = array('msg' => 'El teléfono del proveedor es requerido', 'type' => 'warning');
            } else if (empty($email)) {
                $response = array('msg' => 'El correo electrónico del proveedor es requerido', 'type' => 'warning');
            } else if (empty($address)) {
                $response = array('msg' => 'La dirección del proveedor es requerida', 'type' => 'warning');
            } else {
                if ($id == '') {
                    $checkNit = $this->model->getValidate('nit', $nit, 'register', 0);
                    if (empty($checkNit)) {
                        $checkPhone = $this->model->getValidate('phone', $phone, 'register', 0);
                        if (empty($checkPhone)) {
                            $checkEmail = $this->model->getValidate('email', $email, 'register', 0);
                            if (empty($checkEmail)) {
                                $data = $this->model->register($nit, $name, $phone, $email, $address);
                                if ($data > 0) {
                                    $response = array('msg' => 'Proveedor registrado', 'type' => 'success');
                                } else {
                                    $response = array('msg' => 'Error al registrar el proveedor', 'type' => 'error');
                                }
                            } else {
                                $response = array('msg' => 'El correo ya se encuentra asignado a otro proveedor', 'type' => 'warning');
                            }
                        } else {
                            $response = array('msg' => 'El teléfono ya se encuentra asignado a otro proveedor', 'type' => 'warning');
                        }
                    } else {
                        $response = array('msg' => 'El NIT ya se encuentra asignado a otro proveedor', 'type' => 'warning');
                    }
                } else {
                    $checkNit = $this->model->getValidate('nit', $nit, 'edit', $id);
                    if (empty($checkNit)) {
                        $checkPhone = $this->model->getValidate('phone', $phone, 'edit', $id);
                        if (empty($checkPhone)) {
                            $checkEmail = $this->model->getValidate('email', $email, 'edit', $id);
                            if (empty($checkEmail)) {
                                $data = $this->model->update($nit, $name, $phone, $email, $address, $id);
                                if ($data > 0) {
                                    $response = array('msg' => 'Proveedor modificado', 'type' => 'success');
                                } else {
                                    $response = array('msg' => 'Error al modificar el proveedor', 'type' => 'error');
                                }
                            } else {
                                $response = array('msg' => 'El correo ya se encuentra asignado a otro proveedor', 'type' => 'warning');
                            }
                        } else {
                            $response = array('msg' => 'El teléfono ya se encuentra asignado a otro proveedor', 'type' => 'warning');
                        }
                    } else {
                        $response = array('msg' => 'El NIT ya se encuentra asignado a otro proveedor', 'type' => 'warning');
                    }
                }
            }
        } else {
            $response = array('msg' => 'Error desconocido', 'type' => 'error');
        }
        echo json_encode($response);
        die();
    }

    public function delete($idSupplier)
    {

        if (isset($_GET) && is_numeric($idSupplier)) {
            $data = $this->model->delete(0, $idSupplier);
            if ($data == 1) {
                $response = array('msg' => 'Proveedor desactivado', 'type' => 'success');
            } else {
                $response = array('msg' => 'Error al desactivar el proveedor', 'type' => 'error');
            }
        } else {
            $response = array('msg' => 'Error desconocido', 'type' => 'error');
        }

        echo json_encode($response);
        die();
    }

    public function edit($idSupplier)
    {

        $data = $this->model->edit($idSupplier);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function inactives()
    {

        $data['title'] = 'Proveedores inactivos';
        $data['script'] = 'inactive-suppliers.js';
        $this->views->getView('suppliers', 'inactives', $data);
    }

    public function listInactives()
    {

        $data = $this->model->getSuppliers(0);
        for ($i = 0; $i < count($data); $i++) {
            $data[$i]['actions'] = '<div>
            <button class="btn btn-success" type="button" onclick="reactivateSupplier(' . $data[$i]['id'] . ')"><i class="fas fa-check-circle"></i></button>
            </div>';
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function reactivate($idSupplier)
    {

        if (isset($_GET) && is_numeric($idSupplier)) {
            $data = $this->model->delete(1, $idSupplier);
            if ($data > 0) {
                $response = array('msg' => 'Proveedor reactivado con éxito', 'type' => 'success');
            } else {
                $response = array('msg' => 'Error al reactivar el proveedor', 'type' => 'error');
            }
        } else {
            $response = array('msg' => 'Error desconocido', 'type' => 'error');
        }
        echo json_encode($response, JSON_UNESCAPED_UNICODE);
        die();
    }
}
