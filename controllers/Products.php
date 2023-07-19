<?php
class Products extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {

        $data['title'] = 'Productos';
        $data['script'] = 'products.js';
        $data['measures'] = $this->model->getData('measures');
        $data['categories'] = $this->model->getData('categories');
        $this->views->getView('products', 'index', $data);
    }

    public function list()
    {

        $data = $this->model->getProducts(1);
        for ($i = 0; $i < count($data); $i++) {
            $data[$i]['image'] = '<img class="img-thumbnail" src="' . $data[$i]['photo'] . '" width="100">';
            $data[$i]['actions'] = '<div>
            <button class="btn btn-danger" type="button" onclick="deleteProduct(' . $data[$i]['id'] . ')" ><i class="fas fa-trash"></i></button>            
            <button class="btn btn-primary" type="button" onclick="editProduct(' . $data[$i]['id'] . ')" ><i class="fas fa-edit"></i></button>            
            </div>';
        }

        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function register()
    {
        if (isset($_POST['code']) && isset($_POST['description'])) {
            $id = strClean($_POST['id']);
            $code = strClean($_POST['code']);
            $description = strClean($_POST['description']);
            $purchase_price = strClean($_POST['purchase_price']);
            $sale_price = strClean($_POST['sale_price']);
            $id_measure = strClean($_POST['id_measure']);
            $id_category = strClean($_POST['id_category']);
            $actual_photo = strClean($_POST['actual_photo']);
            $photo = $_FILES['photo'];
            $name = $photo['name'];
            $tmp = $photo['tmp_name'];

            $route = null;
            if (!empty($name)) {
                $date = date('YmdHis');
                $route = 'assets/images/products/' . $date . '.png';
            } elseif (!empty($actual_photo) && empty($name)) {
                $route = $actual_photo;
            }

            if (empty($code)) {
                $response = array('msg' => 'El código es necesario', 'type' => 'warning');
            } else if (empty($description)) {
                $response = array('msg' => 'El nombre es necesario', 'type' => 'warning');
            } else if (empty($purchase_price)) {
                $response = array('msg' => 'El valor de compra es necesario', 'type' => 'warning');
            } else if (empty($sale_price)) {
                $response = array('msg' => 'El valor de venta es necesario', 'type' => 'warning');
            } else if (empty($id_measure)) {
                $response = array('msg' => 'La medida es necesaria', 'type' => 'warning');
            } else if (empty($id_category)) {
                $response = array('msg' => 'La categoría es necesaria', 'type' => 'warning');
            } else {
                if ($id == '') {
                    $check = $this->model->getValidate('code', $code, 'register', 0);
                    if (empty($check)) {
                        $data = $this->model->register($code, $description, $purchase_price, $sale_price, $id_measure, $id_category, $route);

                        if ($data > 0) {
                            if (!empty($name)) {
                                move_uploaded_file($tmp, $route);
                            }
                            $response = array('msg' => 'Producto registrado', 'type' => 'success');
                        } else {
                            $response = array('msg' => 'Error al registrar el producto', 'type' => 'error');
                        }
                    } else {
                        $response = array('msg' => 'El código debe ser único', 'type' => 'warning');
                    }
                } else {
                    $check = $this->model->getValidate('code', $code, 'edit', $id);
                    if (empty($check)) {
                        $data = $this->model->update($code, $description, $purchase_price, $sale_price, $id_measure, $id_category, $route, $id);

                        if ($data > 0) {
                            if (!empty($name)) {
                                move_uploaded_file($tmp, $route);
                            }
                            $response = array('msg' => 'Producto modificado', 'type' => 'success');
                        } else {
                            $response = array('msg' => 'Error al modificar el producto', 'type' => 'error');
                        }
                    } else {
                        $response = array('msg' => 'El código debe ser único', 'type' => 'warning');
                    }
                }
            }
        } else {
            $response = array('msg' => 'Error desconocido', 'type' => 'error');
        }
        echo json_encode($response);
        die();
    }

    public function delete($idProduct)
    {

        if (isset($_GET) && is_numeric($idProduct)) {
            $data = $this->model->delete(0, $idProduct);
            if ($data == 1) {
                $response = array('msg' => 'Producto eliminado', 'type' => 'success');
            } else {
                $response = array('msg' => 'Error al eliminar el producto', 'type' => 'error');
            }
        } else {
            $response = array('msg' => 'Error desconocido', 'type' => 'error');
        }
        echo json_encode($response);
        die();
    }

    public function edit($idProduct)
    {

        $data = $this->model->edit($idProduct);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function inactives()
    {
        $data['title'] = 'Productos inactivos';
        $data['script'] = 'inactive-products.js';
        $this->views->getView('products', 'inactives', $data);
    }


    public function listInactives()
    {

        $data = $this->model->getProducts(0);
        for ($i = 0; $i < count($data); $i++) {
            $data[$i]['image'] = '<img class="img-thumbnail" src="' . $data[$i]['photo'] . '" width="100">';
            $data[$i]['actions'] = '<div>
            <button class="btn btn-success" type="button" onclick="reactivateProduct(' . $data[$i]['id'] . ')" ><i class="fas fa-check-circle"></i></button>            
            </div>';
        }

        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function reactivate($idProduct)
    {

        if (isset($_GET) && is_numeric($idProduct)) {
            $data = $this->model->delete(1, $idProduct);
            if ($data == 1) {
                $response = array('msg' => 'Producto reactivado', 'type' => 'success');
            } else {
                $response = array('msg' => 'Error al reactivar el producto', 'type' => 'error');
            }
        } else {
            $response = array('msg' => 'Error desconocido', 'type' => 'error');
        }
        echo json_encode($response);
        die();
    }

    // Search Products using the code
    public function searchByCode($value)
    {

        $data = $this->model->searchByCode($value);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    //Search products using the product name
    public function searchByName()
    {

        $array = array();
        $value = $_GET['term'];
        $data = $this->model->searchByName($value);
        foreach ($data as $row) {
            $result['id'] = $row['id'];
            $result['label'] = $row['description'];
            array_push($array, $result);
        }
        echo json_encode($array, JSON_UNESCAPED_UNICODE);
        die();
    }

    //Show products from localStorage
    public function showData()
    {

        $json = file_get_contents('php://input');
        $dataSet = json_decode($json, true);
        $array['products'] = array();
        $total = 0;
        if (!empty($dataSet)) {
            foreach ($dataSet as $product) {
                $result = $this->model->edit($product['id']);
                $data['id'] = $result['id'];
                $data['description'] = $result['description'];
                $data['purchase_price'] = $result['purchase_price'];
                $data['quantity'] = $product['quantity'];
                $subTotal = $result['purchase_price'] * $product['quantity'];
                $data['subTotal'] = number_format($subTotal, 2);
                array_push($array['products'], $data);
                $total += $subTotal;
            }
        }
        $array['total'] = number_format($total, 2);
        echo json_encode($array, JSON_UNESCAPED_UNICODE);
        die();
    }
}
