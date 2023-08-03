<?php
class InventoryModel extends Query{
    public function __construct() {
        parent::__construct();
    }

    public function getTransactions($id_user) {

        $sql = "SELECT i.*, p.description FROM inventory i INNER JOIN products p ON i.id_product = p.id WHERE i.id_user = $id_user";
        return $this->selectAll($sql);

    }

    public function getTransactionsMonth($year, $month, $id_user) {

        $sql = "SELECT i.*, p.description FROM inventory i INNER JOIN products p ON i.id_product = p.id WHERE MONTH(i.date) = $month AND YEAR(i.date) = $year AND i.id_user = $id_user";
        return $this->selectAll($sql);
        
    }

    public function getCompany() {

        $sql = "SELECT * FROM configuration";
        return $this->select($sql);

    }

    
}
?>