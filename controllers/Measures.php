<?php
class Measures extends Controller{
    public function __construct() {
        parent::__construct();
    }

    public function index(){
        
        $data['title'] = 'Medidas';
        $data['script'] = 'measures.js';
        $this->views->getView('measures', 'index', $data);
    }

    public function list() {

        $data = $this->model->getMeasures(1);
        for ($i=0; $i < count($data); $i++) { 
            $data[$i]['actions'] = '';
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
        
    }
}
