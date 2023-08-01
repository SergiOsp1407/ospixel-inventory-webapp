<?php
class ReservationsModel extends Query{
    public function __construct() {
        parent::__construct();
    }

    public function getProduct($idProduct) {

        $sql = "SELECT * FROM products WHERE id = $idProduct";
        return $this->select($sql);
        
    }

    public function registerReservation($products, $date_reservation, $date_retirement, $partialPayment, $total, $color, $idClient) {

        $sql = "INSERT INTO reservations (products, date_reservation, date_retirement, partialPayment, total, color, id_client) VALUES (?,?,?,?,?,?,?)";
        $array = array($products, $date_reservation, $date_retirement, $partialPayment, $total, $color, $idClient);
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

    // public function getQuotes() {

    //     $sql = "SELECT ct.*, cl.name FROM quotes ct INNER JOIN clients cl ON ct.id_client = cl.id";
    //     return $this->selectAll($sql);
        
    // }

}
?>