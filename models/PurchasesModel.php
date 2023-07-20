<?php
class PurchasesModel extends Query{
    public function __construct() {
        parent::__construct();
    }

    public function getProduct($idProduct) {

        $sql = "SELECT * FROM products WHERE id = $idProduct";
        return $this->select($sql);
        
    }

    public function registerPurchase($products, $total, $date, $time, $serie, $idSupplier, $id_user) {

        $sql = "INSERT INTO purchases (products, total, date, time, serie, id_supplier, id_user) VALUES (?,?,?,?,?,?,?)";
        $array = array($products, $total, $date, $time, $serie, $idSupplier, $id_user);
        return $this->insert($sql, $array);
        
    }

    public function getCompany() {

        $sql = "SELECT * FROM configuration";
        return $this->select($sql);
        
    }

    public function getPurchase($idPurchase) {

        $sql = "SELECT c.*, p.nit, p.name, p.phone, p.address FROM purchases c INNER JOIN suppliers p ON c.id_supplier = p.id WHERE c.id = $idPurchase";
        return $this->select($sql);
        
    }
}
?>