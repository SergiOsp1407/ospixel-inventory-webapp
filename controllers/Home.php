<?php
class Home extends Controller{

    public function __construct() {
        parent::__construct();
        session_start();
    }

    public function index(){    
        
        $data['title'] = 'Iniciar Sesion';
        $this->views->View('main','login',$data);
    }

    //Validate login form
    public function validate(){
        if (isset($_POST['emailAddress']) && isset($_POST['password'])) {
            if (empty($_POST['emailAddress'])) {
                $response = array('msg' => 'El correo es necesario', 'type' => 'warning');
            }else if (empty($_POST['password'])) {
                $response = array('msg' => 'La contraseña es necesaria', 'type' => 'warning');                
            }else {
                $email = strClean($_POST['emailAddress']);
                $password = strClean($_POST['password']);
                $data = $this->model->getData($email);
                if (empty($data)) {
                    $response = array('msg' => 'El correo no existe', 'type' => 'warning');                
                }else {
                    if (password_verify($password, $data['password'] )) {
                        $_SESSION['name_user'] = $data['name'];                        
                        $_SESSION['email_user'] = $data['email'];
                        $response = array('msg' => 'Datos correctos', 'type' => 'success'); 
                    }else {
                        $response = array('msg' => 'Contraseña incorrecta', 'type' => 'error'); 
                    }
                }
            }
        }else {
            $response = array('msg' => 'Error desconocido', 'type' => 'error'); 
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
}
?>