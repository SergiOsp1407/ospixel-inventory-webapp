<?php
class CashdeskModel extends Query
{
    public function __construct()
    {
        parent::__construct();
    }

    public function openCashdesk($initial_value, $opening_date, $id_user)
    {
        $sql = "INSERT INTO cashdesk (initial_value, opening_date, id_user) VALUES (?,?,?)";
        $array = array($initial_value, $opening_date, $id_user);
        return $this->insert($sql, $array);
    }

    public function getCashdesk($id_user)
    {
        $sql = "SELECT * FROM cashdesk WHERE status = 1 AND id_user = $id_user";
        return $this->select($sql);
    }

    public function getCashdesks()
    {
        $sql = "SELECT c.*, u.name FROM cashdesk c INNER JOIN users u ON c.id_user = u.id";
        return $this->selectAll($sql);
    }

    public function registerExpense($value, $description, $route, $id_user)
    {
        $sql = "INSERT INTO expenses (value, description, photo, id_user) VALUES (?,?,?,?)";
        $array = array($value, $description, $route, $id_user);
        return $this->insert($sql, $array);
    }

    public function getExpenses()
    {
        $sql = "SELECT * FROM expenses";
        return $this->selectAll($sql);
    }

    public function getCompany()
    {
        $sql = "SELECT * FROM configuration";
        return $this->select($sql);
    }

    //Transactions
    public function getSales($field, $id_user)
    {
        $sql = "SELECT SUM($field) AS totalSales FROM sales WHERE payment_method = 'efectivo' AND opening = 1 AND id_user = $id_user";
        return $this->select($sql);
    }

    public function getReservations($id_user)
    {
        $sql = "SELECT SUM(d.value) AS totalReservation FROM reservations_details d INNER JOIN reservations a ON d.id_reservation = a.id WHERE d.opening = 1 AND a.id_user = $id_user";
        return $this->select($sql);
    }

    public function getPayments($id_user)
    {
        $sql = "SELECT SUM(a.partial_payment) AS totalPayments FROM payments a INNER JOIN credits c ON a.id_credit = c.id INNER JOIN sales v ON c.id_sale = v.id WHERE a.opening = 1 AND v.id_user = $id_user";
        return $this->select($sql);
    }

    public function getPurchases($id_user)
    {
        $sql = "SELECT SUM(total) AS totalPurchases FROM purchases WHERE opening = 1 AND id_user = $id_user";
        return $this->select($sql);
    }

    public function getTotalExpenses($id_user)
    {
        $sql = "SELECT SUM(value) AS totalExpenses FROM expenses WHERE opening = 1 AND id_user = $id_user";
        return $this->select($sql);
    }

    public function getTotalSales($id_user) {
        $sql = "SELECT COUNT(*) AS totalSalesQuantity FROM sales WHERE opening = 1 AND id_user = $id_user";
        return $this->select($sql);
    }

    //Close cashdesk
    public function closeCashdesk($closing_date, $final_value, $total_sales_quantity, $outgoings, $expenses, $id_user)
    {
        $sql = "UPDATE cashdesk SET closing_date=?, final_value=?, total_sales_quantity=?, outgoings=?, expenses=?, status=? WHERE status = ? AND id_user = ?";
        $array = array($closing_date, $final_value, $total_sales_quantity, $outgoings, $expenses, 0, 1, $id_user);
        return $this->save($sql, $array);
    }

    //Update opening in cashdesk
    public function updateOpening($table, $id_user)
    {
        $sql = "UPDATE $table SET opening=? WHERE id_user = ?";
        $array = array(0, $id_user);
        return $this->save($sql, $array);
    }

    public function getHistoryCashdesk($idCashdesk) {

        $sql = "SELECT * FROM cashdesk WHERE id = $idCashdesk";
        return $this->select($sql);        
    }
}
