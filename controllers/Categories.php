<?php
class Categories extends Controller
{

    public function __construct()
    {
        parent::__construct();
        session_start();
    }

    public function index()
    {

        $data['title'] = 'Categorias';
        $data['script'] = 'categories.js';
        $this->views->getView('categories', 'index', $data);
    }
    
    public function list()
    {

        $data = $this->model->getCategories(1);
        for ($i = 0; $i < count($data); $i++) {
            $data[$i]['actions'] = '<div>
            <button class="btn btn-danger" type="button" onclick="deleteCategory(' . $data[$i]['id'] . ')"><i class="fas fa-trash"></i></button>
            <button class="btn btn-info" type="button" onclick="editCategory(' . $data[$i]['id'] . ')"><i class="fas fa-edit"></i></button>
            </div>';
        }

        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    
    public function register()
    {

        if (isset($_POST['category'])) {
            $category = strClean($_POST['category']);
            $id = strClean($_POST['id']);

            if (empty($category)) {
                $response = array('msg' => 'El nombre de la categoría es necesaria', 'type' => 'warning');
            } else {
                if ($id == "") {
                    $check = $this->model->getValidate('category', $category, 'register', 0);
                    if (empty($check)) {
                        $data = $this->model->register($category);
                        if ($data > 0) {
                            $response = array('msg' => 'Categoría registrada', 'type' => 'success');
                        } else {
                            $response = array('msg' => 'Error al registrar la categoría', 'type' => 'error');
                        }
                    } else {
                        $response = array('msg' => 'La categoría ya existe', 'type' => 'warning');
                    }
                } else {
                    $check = $this->model->getValidate('category', $category, 'edit', $id);
                    if (empty($check)) {
                        $data = $this->model->update($category, $id);
                        if ($data > 0) {
                            $response = array('msg' => 'Categoría actualizada', 'type' => 'success');
                        } else {
                            $response = array('msg' => 'Error al actualizar la categoría', 'type' => 'error');
                        }
                    } else {
                        $response = array('msg' => 'La categoría ya existe', 'type' => 'warning');
                    }
                }
            }
            echo json_encode($response);
            die();
        }
    }

    public function delete($idCategory)
    {

        if (isset($_GET) && is_numeric($idCategory)) {
            $data = $this->model->delete(0, $idCategory);
            if ($data == 1) {
                $response = array('msg' => 'Categoría eliminada', 'type' => 'success');
            } else {
                $response = array('msg' => 'Error al eliminar la categoría', 'type' => 'error');
            }
        } else {
            $response = array('msg' => 'Error desconocido', 'type' => 'error');
        }
        
        echo json_encode($response, JSON_UNESCAPED_UNICODE);
        die();
    }
    
    
    public function edit($idCategory)
    {
        
        $data = $this->model->edit($idCategory);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    
    public function inactives()
    {
        
        $data['title'] = 'Categorías inactivas';
        $data['script'] = 'inactive-categories.js';
        $this->views->getView('categories', 'inactives', $data);
    }
    
    public function listInactives()
    {
    
        $data = $this->model->getCategories(0);
        for ($i = 0; $i < count($data); $i++) {
            $data[$i]['actions'] = '<div>
            <button class="btn btn-success" type="button" onclick="reactivateCategory(' . $data[$i]['id'] . ')"><i class="fas fa-check-circle"></i></button>
            </div>';
        }
    
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    
    public function reactivate($idCategory)
    {
    
        if (isset($_GET) && is_numeric($idCategory)) {
            $data = $this->model->delete(1, $idCategory);
            if ($data == 1) {
                $response = array('msg' => 'Categoría activada', 'type' => 'success');
            } else {
                $response = array('msg' => 'Error al activar la categoría', 'type' => 'error');
            }
        } else {
            $response = array('msg' => 'Error desconocido', 'type' => 'error');
        }
        
        echo json_encode($response, JSON_UNESCAPED_UNICODE);
        die();
    }
    
}
