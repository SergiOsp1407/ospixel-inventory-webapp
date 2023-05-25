<?php
class Home extends Controller{

    public function __construct() {
        parent::__construct();
    }

    public function index($param){
        $data = $this->model->getData($param);
        $this->views->View('main','login',$data);
    }

}
?>