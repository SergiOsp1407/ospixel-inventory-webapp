<?php
class AdminModel extends Query{

    public function __construct() {
        parent::__construct();
    }

    public function getData(){

        $sql = "SELECT * FROM configuration";
        return $this->select($sql);

    }

    public function update($nit, $name, $phone, $email ,$address, $tax, $message, $id) {
        
        $sql = "UPDATE configuration SET nit=?, name=?, phone=?, email=? ,address=?, tax=?, message=? WHERE id = ?";
        $array = array($nit, $name, $phone, $email ,$address, $tax, $message, $id);
        return $this->save($sql, $array);
    }

    public function getTotals($table){
        $sql = "SELECT COUNT(*) AS totals FROM $table WHERE status = 1";
        return $this->select($sql);
    }
}
?>