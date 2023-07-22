<?php
class SalesModel extends Query{
    public function __construct() {
        parent::__construct();
    }

    public function getProduct($idProduct) {

        $sql = "SELECT * FROM products WHERE id = $idProduct";
        return $this->select($sql);
        
    }

    public function registerSale($products, $total, $date, $time, $paymentMethod, $discount, $serie, $idClient, $id_user) {

        $sql = "INSERT INTO sales (products, total, date, time, payment_method, discount, serie, id_client, id_user) VALUES (?,?,?,?,?,?,?,?,?)";
        $array = array($products, $total, $date, $time, $paymentMethod, $discount, $serie, $idClient, $id_user);
        return $this->insert($sql, $array);
        
    }

    //Update stock
    public function updateStock($quantity, $idProduct) {
        $sql = "UPDATE products SET quantity = ? WHERE id = ?";
        $array = array($quantity, $idProduct);
        return $this->save($sql, $array);
    }

    public function registerCredits($value_credit, $idSale) {

        $sql = "INSERT INTO credits (value_credit, id_sale) VALUES (?,?)";
        $array = array($value_credit, $idSale);
        return $this->insert($sql, $array);
        
    }

    public function getCompany() {

        $sql = "SELECT * FROM configuration";
        return $this->select($sql);
        
    }

    public function getSale($idSale) {

        $sql = "SELECT v.*, c.identity_type, c.client_identity, c.name, c.phone, c.address FROM sales v INNER JOIN clients c ON v.id_client = c.id WHERE v.id = $idSale";
        return $this->select($sql);
        
    }

    public function getSerie() {

        $sql = "SELECT MAX(id) AS total FROM sales";
        return $this->select($sql);
        
    }

    

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