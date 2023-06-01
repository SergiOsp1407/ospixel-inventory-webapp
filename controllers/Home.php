<?php
class Home extends Controller{

    public function __construct() {
        parent::__construct();
    }

    public function index(){    
        
        $data['title'] = 'Iniciar Sesion';
        $this->views->View('main','login',$data);
    }

    //Validate login form
    public function validate(){
        if (isset($_POST['emailAddress']) && isset($_POST['password'])) {
            if (empty($_POST['emailAddress'])) {
                $response = array('msg' => 'El correo es necesario');
            }else if (empty($_POST['password'])) {
                $response = array('msg' => 'La contraseña es necesaria');                
            }else {
                # code...
            }
            echo json_encode($response, JSON_UNESCAPED_UNICODE);
        }
        die();
    }
}
?>