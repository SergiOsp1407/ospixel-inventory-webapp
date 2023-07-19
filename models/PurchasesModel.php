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
}
?>