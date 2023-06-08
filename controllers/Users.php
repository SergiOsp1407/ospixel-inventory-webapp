<?php
class Users extends Controller{

    public function __construct() {
        parent::__construct();
        session_start();
    }

    public function index(){    
        
        $data['title'] = 'Usuarios';
        $this->views->getView('users','index',$data);

    }

   
}
?>