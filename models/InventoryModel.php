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

    public function getProduct($idProduct) {

        $sql = "SELECT * FROM products WHERE id = $idProduct";
        return $this->select($sql);

    }

    public function processAdjustment($quantity, $idProduct) {
        $sql = "UPDATE products SET quantity = ? WHERE id = ?";
        $array = array($quantity, $idProduct);
        return $this->save($sql, $array);
    }

    //Transactions of products for inventory
    public function recordTransaction($transaction, $action, $quantity, $actual_stock, $idProduct, $id_user) {

        $sql = "INSERT INTO inventory (transaction, action, quantity, actual_stock, id_product, id_user) VALUES (?,?,?,?,?,?)";
        $array = array($transaction, $action, $quantity, $actual_stock, $idProduct, $id_user);
        return $this->insert($sql, $array);
        
    }

    public function getKardex($idProduct, $id_user) {
        $sql = "SELECT i.action, i.quantity, i.actual_stock, i.date, p.description FROM inventory i INNER JOIN products p ON i.id_product = p.id WHERE i.id_product = $idProduct AND i.id_user = $id_user";
        return $this->selectAll($sql);


        
    }

    public function getCompany() {

        $sql = "SELECT * FROM configuration";
        return $this->select($sql);

    }

    
}
?>