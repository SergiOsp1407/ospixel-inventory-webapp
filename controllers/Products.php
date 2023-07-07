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
            $data[$i]['actions'] = '';
        }

        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function register()
    {
        if (isset($_POST['code']) && isset($_POST['description'])) {
            $code = strClean($_POST['code']);
            $description = strClean($_POST['description']);
            $purchase_price = strClean($_POST['purchase_price']);
            $sale_price = strClean($_POST['sale_price']);
            $id_measure = strClean($_POST['id_measure']);
            $id_category = strClean($_POST['id_category']);
            $photo = $_FILES['photo'];
            $name = $photo['name'];
            $tmp = $photo['tmp_name'];
            $date = date('YmdHis');
            $route = 'assets/images/products/' . $date . '.jpg';
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
                $check = $this->model->getValidate('code', $code, 'register', 0);
                if (empty($check)) {
                    $data = $this->model->register($code, $description, $purchase_price, $sale_price, $id_measure, $id_category, $route);

                    if ($data > 0) {
                        $response = array('msg' => 'Producto registrado', 'type' => 'success');
                    } else {
                        $response = array('msg' => 'Error al registrar el producto', 'type' => 'error');
                    }
                } else {
                    $response = array('msg' => 'El código debe ser único', 'type' => 'warning');
                }
            }
        } else {
            $response = array('msg' => 'Error desconocido', 'type' => 'error');
        }
        echo json_encode($response);
        die();
    }
}
