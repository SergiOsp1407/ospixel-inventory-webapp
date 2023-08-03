<?php
class ReservationsModel extends Query{
    public function __construct() {
        parent::__construct();
    }

    public function getProduct($idProduct) {

        $sql = "SELECT * FROM products WHERE id = $idProduct";
        return $this->select($sql);
        
    }

    public function registerReservation($products, $date_create, $date_reservation, $date_retirement, $partialPayment, $total, $color, $idClient) {

        $sql = "INSERT INTO reservations (products, date_create, date_reservation, date_retirement, partialPayment, total, color, id_client) VALUES (?,?,?,?,?,?,?,?)";
        $array = array($products, $date_create, $date_reservation, $date_retirement, $partialPayment, $total, $color, $idClient);
        return $this->insert($sql, $array);
        
    }

    public function getCompany() {

        $sql = "SELECT * FROM configuration";
        return $this->select($sql);
        
    }

    public function getReservation($idReservation) {

        $sql = "SELECT ap.*, cl.identity_type, cl.client_identity, cl.name, cl.phone, cl.address FROM reservations ap INNER JOIN clients cl ON ap.id_client = cl.id WHERE ap.id = $idReservation";
        return $this->select($sql);
                
    }

    public function getReservations() {

        $sql = "SELECT ap.*, cl.client_identity, cl.name FROM reservations ap INNER JOIN clients cl ON ap.id_client = cl.id";
        return $this->selectAll($sql);
                
    }

    public function processRetirement($partialPayment, $status, $idReservation) {
        $sql = "UPDATE reservations SET partialPayment = ?, status = ? WHERE id = ?";
        $array = array($partialPayment, $status, $idReservation);
        return $this->save($sql, $array);
    }

    //Transactions of products for inventory
    public function recordTransaction($transaction, $action, $quantity, $idProduct, $id_user) {

        $sql = "INSERT INTO inventory (transaction, action, quantity, id_product, id_user) VALUES (?,?,?,?,?)";
        $array = array($transaction, $action, $quantity, $idProduct, $id_user);
        return $this->insert($sql, $array);
        
    }

    
}
?>