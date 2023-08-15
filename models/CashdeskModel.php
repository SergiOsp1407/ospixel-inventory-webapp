<?php
class CashdeskModel extends Query{
    public function __construct() {
        parent::__construct();

    }

    public function openCashdesk($initial_value, $opening_date, $id_user) {
        $sql = "INSERT INTO cashdesk (initial_value, opening_date, id_user) VALUES (?,?,?)";
        $array = array($initial_value, $opening_date, $id_user);
        return $this->insert($sql, $array);
    }

    public function getCashdesk($id_user) {
        $sql = "SELECT * FROM cashdesk WHERE status = 1 AND id_user = $id_user";
        return $this->select($sql);
    }

    public function getCashdesks() {
        $sql = "SELECT c.*, u.name FROM cashdesk c INNER JOIN users u ON c.id_user = u.id";
        return $this->selectAll($sql);
    }

    public function registerExpense($value, $description, $route, $id_user) {
        $sql = "INSERT INTO expenses (value, description, photo, id_user) VALUES (?,?,?,?)";
        $array = array($value, $description, $route, $id_user);
        return $this->insert($sql, $array);
    }

    public function getExpenses() {
        $sql = "SELECT * FROM expenses";
        return $this->selectAll($sql);
    }

    public function getCompany() {
        $sql = "SELECT * FROM configuration";
        return $this->select($sql);
    }

    //Transactions
    public function getSales($field, $id_user) {
        $sql = "SELECT SUM($field) AS totalSales FROM sales WHERE payment_method = 'efectivo' AND id_user = $id_user";
        return $this->select($sql);
    }

    public function getReservations($id_user) {
        $sql = "SELECT SUM(partialPayment) AS totalReservation FROM reservations WHERE id_user = $id_user";
        return $this->select($sql);
    }

    public function getPayments($id_user) {
        $sql = "SELECT SUM(a.partial_payment) AS totalPayments FROM payments a INNER JOIN credits c ON a.id_credit = c.id INNER JOIN sales v ON c.id_sale = v.id WHERE v.id_user = $id_user";
        return $this->select($sql);
    }

    public function getPurchases($id_user) {
        $sql = "SELECT SUM(total) AS totalPurchases FROM purchases WHERE id_user = $id_user";
        return $this->select($sql);
    }

    public function getTotalExpenses($id_user) {
        $sql = "SELECT SUM(value) AS totalExpenses FROM expenses WHERE id_user = $id_user";
        return $this->select($sql);
    }
}