<?php
class Cashdesk extends Controller{

    public function __construct() {
        parent::__construct();
        session_start();
    }

    public function index() {

        $data['title'] = 'Movimientos en caja';

        $this->views->getView('cashdesk', 'index', $data);
        
    }

    
}
?>