<?php
class Users extends Controller{

    public function __construct() {
        parent::__construct();
        session_start();
    }

    public function index(){    
        
        $data['title'] = 'Usuarios';
        $data['script'] = 'users.js';
        $this->views->getView('users','index',$data);

    }

    public function list(){
        
        $data = $this->model->getUsers(1);
        for ($i=0; $i < count($data); $i++) { 
            if ($data[$i]['rol'] == 1) {
                $data[$i]['rol'] = '<span class="badge bg-danger">Administrador</span>';
            }else{
                $data[$i]['rol'] = '<span class="badge bg-info">Vendedor</span>';
            }

            $data[$i]['actions'] = '';
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();

    }

   
}
?>