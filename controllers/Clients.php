<?php
class Clients extends Controller{
    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $data['title'] = 'Clientes';
        $data['script'] = 'clients.js';
        $this->views->getView('clients', 'index', $data);
    }

    public function list() {

        $data = $this->model->getClients(1);
        for ($i=0; $i < count($data); $i++) { 
            $data[$i]['actions'] = '';
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
        
    }


}
?>