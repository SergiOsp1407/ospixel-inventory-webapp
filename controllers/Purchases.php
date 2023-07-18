<?php
class Purchases extends Controller{
    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $data['title'] = 'Purchases';
        $data['script'] = 'purchases.js';
        $this->views->getView('purchases', 'index', $data);
        
    }
}

?>