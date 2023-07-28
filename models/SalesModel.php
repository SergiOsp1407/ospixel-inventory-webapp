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

    public function registerCredits($value_credit, $date, $time, $idSale) {

        $sql = "INSERT INTO credits (value_credit, date, time, id_sale) VALUES (?,?,?,?)";
        $array = array($value_credit, $date, $time, $idSale);
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

    //Get historic of sales
    public function getSales() {

        $sql = "SELECT v.*, c.name FROM sales v INNER JOIN clients c ON v.id_client = c.id";
        return $this->selectAll($sql);
        
    }
    
    public function cancel($idSale) {
        $sql = "UPDATE sales SET status = ? WHERE id = ?";
        $array = array(0, $idSale);
        return $this->save($sql, $array);
    }
    
    public function cancelCredit($idSale) {
        $sql = "UPDATE credits SET status = ? WHERE id_sale = ?";
        $array = array(2, $idSale);
        return $this->save($sql, $array);
    }

    public function getSerie() {

        $sql = "SELECT MAX(id) AS total FROM sales";
        return $this->select($sql);
        
    }    

}
?>