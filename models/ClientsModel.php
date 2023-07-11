<?php
class ClientsModel extends Query{
    public function __construct() {
        parent::__construct();
    }

    public function getClients($status) {

        $sql = "SELECT * FROM clients WHERE status = $status";
        return $this->selectAll($sql);
        
    }
}
?>