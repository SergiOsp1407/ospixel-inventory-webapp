<?php
class SuppliersModel extends Query{
    public function __construct() {
        parent::__construct();
    }

    public function getSuppliers($status) {

        $sql = "SELECT * FROM suppliers WHERE status = $status";
        return $this->selectAll($sql);
        
    }

    public function register($nit, $name, $phone, $email, $address) {

        $sql = "INSERT INTO suppliers (nit, name, phone, email, address) VALUES (?,?,?,?,?)";
        $array = array($nit, $name, $phone, $email, $address);
        return $this->insert($sql,$array);
        
    }

    public function getValidate($field, $value, $action, $id) {
        if ($action == 'register' && $id == 0) {
            $sql = "SELECT id FROM suppliers WHERE $field = '$value'";
        }else {
            $sql = "SELECT id FROM suppliers WHERE $field = '$value' AND id != $id";
        }
        return $this->select($sql);
    }

    public function delete($status, $idSupplier) {

        $sql = "UPDATE suppliers SET status = ? WHERE id = ?";
        $array = array($status, $idSupplier);
        return $this->save($sql,$array);
        
    }

    public function edit($idSupplier) {

        $sql = "SELECT * FROM suppliers WHERE id = $idSupplier";
        return $this->select($sql);
        
    }

    public function update($nit,$name,$phone,$email,$address, $id){

        $sql = "UPDATE suppliers SET nit=?,name=?,phone=?,email=?,address=? WHERE id=?";
        $array = array($nit,$name,$phone,$email,$address, $id);
        return $this->save($sql, $array);
        
    }

    public function searchByName($value) {

        $sql = "SELECT id, name, phone, address FROM suppliers WHERE name LIKE '%".$value."%' AND status = 1 LIMIT 10";
        return $this->selectAll($sql);
        
    }
}
?>