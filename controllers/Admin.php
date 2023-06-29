<?php
class Admin extends Controller{

    public function __construct() {
        parent::__construct();
        session_start();
    }

    //Graphic reports
    public function index(){    
        
        $data['title'] = 'Panel Administrativo';
        $data['script'] = 'index.js';
        $this->views->getView('admin','home',$data);

    }

    //Company information
    public function data(){    
        
        $data['title'] = 'Información de la Empresa';
        $data['script'] = 'admin.js';
        $data['company'] = $this->model->getData();
        $this->views->getView('admin','index',$data);

    }

    //Edit company info
    public function edit(){
        $nit = strClean($_POST['nit']);
        $name = strClean($_POST['name']);
        $phone = strClean($_POST['phone']);
        $email = strClean($_POST['email']);
        $address = strClean($_POST['address']);
        $tax = strClean($_POST['tax']);
        $message = strClean($_POST['message']);
        $id = strClean($_POST['id']);
        $data = $this->model->update($nit, $name, $phone, $email ,$address, $tax, $message, $id);
        
    }

   
}
?>