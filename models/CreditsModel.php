<?php
class CreditsModel extends Query{
    public function __construct() {
        parent::__construct();
    }

    public function getCredits() {

        $sql = "SELECT cr.*, cl.name FROM credits cr INNER JOIN sales v ON cr.id_sale = v.id INNER JOIN clients cl ON v.id_client = cl.id";
        return $this->selectAll($sql);
    }

    public function getPartialpayment($idCredit) {

        $sql = "SELECT SUM(partial_payment) AS total FROM payments WHERE id_credit = $idCredit";
        return $this->select($sql);
    }

    public function searchByName($value) {

        $sql = "SELECT cr.*, cl.name, cl.phone, cl.address FROM credits cr INNER JOIN sales v ON cr.id_sale = v.id INNER JOIN clients cl ON v.id_client = cl.id WHERE cl.name LIKE '%".$value."%' AND cr.status = 1 LIMIT 10";
        return $this->selectAll($sql);
        
    }

    public function registerPartialPayment($paid_value, $idCredit, $id_user) {

        $sql = "INSERT INTO payments (partial_payment, id_credit, id_user) VALUES (?,?,?)";
        $array = array($paid_value, $idCredit, $id_user);
        return $this->insert($sql, $array);
    }

    public function getCredit($idCredit) {

        $sql = "SELECT cr.*, v.products, cl.identity_type, cl.client_identity, cl.name, cl.phone, cl.address FROM credits cr INNER JOIN sales v ON cr.id_sale = v.id INNER JOIN clients cl ON v.id_client = cl.id WHERE cr.id = $idCredit";
        return $this->select($sql);
    }

    public function updateCredit($status, $idCredit) {

        $sql = "UPDATE credits SET status = ? WHERE id = ?";        
        $array = array($status, $idCredit);
        return $this->save($sql, $array);
    }

    public function getPartialPayments($idCredit) {

        $sql = "SELECT * FROM payments WHERE id_credit = $idCredit";
        return $this->selectAll($sql);
    
    }
    
    public function getHistorialPartialPayments() {
    
        $sql = "SELECT * FROM payments";
        return $this->selectAll($sql);
    
    }

    public function getCompany() {
        
        $sql = "SELECT * FROM configuration";
        return $this->select($sql);
    }

}
?>