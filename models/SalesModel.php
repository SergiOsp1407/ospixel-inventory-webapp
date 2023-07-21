<?php
class SalesModel extends Query{
    public function __construct() {
        parent::__construct();
    }

    public function getProduct($idProduct) {

        $sql = "SELECT * FROM products WHERE id = $idProduct";
        return $this->select($sql);
        
    }

    public function registerSale($products, $total, $date, $time, $paymentMethod, $idClient, $id_user) {

        $sql = "INSERT INTO sales (products, total, date, time, payment_method, id_client, id_user) VALUES (?,?,?,?,?,?,?)";
        $array = array($products, $total, $date, $time, $paymentMethod, $idClient, $id_user);
        return $this->insert($sql, $array);
        
    }

//     public function getCompany() {

//         $sql = "SELECT * FROM configuration";
//         return $this->select($sql);
        
//     }

//     public function getPurchase($idPurchase) {

//         $sql = "SELECT c.*, p.nit, p.name, p.phone, p.address FROM purchases c INNER JOIN suppliers p ON c.id_supplier = p.id WHERE c.id = $idPurchase";
//         return $this->select($sql);
        
//     }

//     //Update stock
//     public function updateStock($quantity, $idProduct) {
//         $sql = "UPDATE products SET quantity = ? WHERE id = ?";
//         $array = array($quantity, $idProduct);
//         return $this->save($sql, $array);
//     }

//     //Get historic of purchases
//     public function getPurchases() {

//         $sql = "SELECT c.*, p.name FROM purchases c INNER JOIN suppliers p ON c.id_supplier = p.id";
//         return $this->selectAll($sql);
        
//     }

//     public function cancel($idPurchase) {
//         $sql = "UPDATE purchases SET status = ? WHERE id = ?";
//         $array = array(0, $idPurchase);
//         return $this->save($sql, $array);
//     }
}
?>