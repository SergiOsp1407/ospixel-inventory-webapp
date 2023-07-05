<?php
class Measures extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {

        $data['title'] = 'Medidas';
        $data['script'] = 'measures.js';
        $this->views->getView('measures', 'index', $data);
    }

    public function list()
    {

        $data = $this->model->getMeasures(1);
        for ($i = 0; $i < count($data); $i++) {
            $data[$i]['actions'] = '<div>
            <button class="btn btn-danger" type="button" onclick="deleteMeasure(' . $data[$i]['id'] . ')" ><i class="fas fa-trash"></i></button>
            <button class="btn btn-info" type="button" onclick="editMeasure(' . $data[$i]['id'] . ')" ><i class="fas fa-edit"></i></button>
            </div>';
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }


    public function register()
    {
        $measure = strClean($_POST['measure']);
        $short_name = strClean($_POST['short_name']);
        $id = strClean($_POST['id']);

        if (empty($measure)) {
            $response = array('msg' => 'El nombre de la medida es requerido ', 'type' => 'warning');
        } else if (empty($short_name)) {
            $response = array('msg' => 'La abreviación es requerida', 'type' => 'warning');
        } else {
            if ($id == '') {
                $check = $this->model->getValidate('measure', $measure, 'register', 0);
                if (empty($check)) {

                    $data = $this->model->register($measure, $short_name);
                    if ($data > 0) {
                        $response = array('msg' => 'Medida creada', 'type' => 'success');
                    } else {
                        $response = array('msg' => 'Error al crear la medida', 'type' => 'error');
                    }
                } else {
                    $response = array('msg' => 'La medida ya existe', 'type' => 'warning');
                }
            } else {
                $check = $this->model->getValidate('measure', $measure, 'edit', $id);
                if (empty($check)) {

                    $data = $this->model->update($measure, $short_name, $id);
                    if ($data == 1) {
                        $response = array('msg' => 'Medida actualizada', 'type' => 'success');
                    } else {
                        $response = array('msg' => 'Error al actualizar la medida', 'type' => 'error');
                    }
                } else {
                    $response = array('msg' => 'La medida ya existe', 'type' => 'warning');
                }
            }
        }

        echo json_encode($response, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function delete($idMeasure)
    {
        if (isset($_GET)) {
            if (is_numeric($idMeasure)) {
                $data = $this->model->delete(0, $idMeasure);
                if ($data == 1) {
                    $response = array('msg' => 'Medida eliminada', 'type' => 'success');
                } else {
                    $response = array('msg' => 'Error al eliminar la medida', 'type' => 'error');
                }
            } else {
                $response = array('msg' => 'Error desconocido', 'type' => 'error');
            }
        } else {
            $response = array('msg' => 'Error desconocido', 'type' => 'error');
        }

        echo json_encode($response, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function edit($idMeasure)
    {

        $data = $this->model->edit($idMeasure);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }


    public function inactives()
    {

        $data['title'] = 'Medidas inactivas';
        $data['script'] = 'inactive-measures.js';
        $this->views->getView('measures', 'inactives', $data);
    }

    public function listInactives()
    {

        $data = $this->model->getMeasures(0);
        for ($i = 0; $i < count($data); $i++) {
            $data[$i]['actions'] = '<div>
            <button class="btn btn-success" type="button" onclick="reactivateMeasure(' . $data[$i]['id'] . ')" ><i class="fas fa-check-circle"></i></button>
            </div>';
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function reactivate($idMeasure)
    {
        if (isset($_GET)) {
            if (is_numeric($idMeasure)) {
                $data = $this->model->delete(1, $idMeasure);
                if ($data == 1) {
                    $response = array('msg' => 'Medida activada correctamente', 'type' => 'success');
                } else {
                    $response = array('msg' => 'Error al activar la medida', 'type' => 'error');
                }
            } else {
                $response = array('msg' => 'Error desconocido', 'type' => 'error');
            }
        } else {
            $response = array('msg' => 'Error desconocido', 'type' => 'error');
        }

        echo json_encode($response, JSON_UNESCAPED_UNICODE);
        die();
    }

    
}
