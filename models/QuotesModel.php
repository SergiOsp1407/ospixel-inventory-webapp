<?php
class QuotesModel extends Query{
    public function __construct() {
        parent::__construct();
    }

    public function getProduct($idProduct) {

        $sql = "SELECT * FROM products WHERE id = $idProduct";
        return $this->select($sql);
        
    }

    public function registerQuote($products, $total, $date, $time, $method, $validity, $discount, $idClient) {

        $sql = "INSERT INTO quotes (products, total, date, time, method, validity, discount, id_client) VALUES (?,?,?,?,?,?,?,?)";
        $array = array($products, $total, $date, $time, $method, $validity, $discount, $idClient);
        return $this->insert($sql, $array);
        
    }

    public function getCompany() {

        $sql = "SELECT * FROM configuration";
        return $this->select($sql);
        
    }

    public function getQuote($idQuote) {

        $sql = "SELECT ct.*, cl.identity_type, cl.client_identity, cl.name, cl.phone, cl.address FROM quotes ct INNER JOIN clients cl ON ct.id_client = cl.id WHERE ct.id = $idQuote";
        return $this->select($sql);
                
    }

    public function getQuotes() {

        $sql = "SELECT ct.*, cl.name FROM quotes ct INNER JOIN clients cl ON ct.id_client = cl.id";
        return $this->selectAll($sql);
        
    }

}
?>