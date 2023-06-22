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

    public function register(){

        if (isset($_POST)) {

            if (empty($_POST['names'])) {
                $res = array('msg' => 'El nombre es requerido');
            }else if (empty($_POST['lastname'])) {
                $res = array('msg' => 'El apellido es requerido');
            }else if (empty($_POST['email'])) {
                $res = array('msg' => 'El correo es requerido');
            }else if (empty($_POST['phone'])) {
                $res = array('msg' => 'El teléfono es requerido');
            }else if (empty($_POST['address'])) {
                $res = array('msg' => 'La dirección es requerida');
            }else if (empty($_POST['password'])) {
                $res = array('msg' => 'La contraseña es requerida');
            }else if (empty($_POST['rol'])) {
                $res = array('msg' => 'El rol es requerido');
            }else {
                
            }
            
        }else {
            
        }
        echo json_encode($response, JSON_UNESCAPED_UNICODE);
        die();                       
    }   
}
?>