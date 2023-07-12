<?php
class ClientsModel extends Query{
    public function __construct() {
        parent::__construct();
    }

    public function getClients($status) {

        $sql = "SELECT * FROM clients WHERE status = $status";
        return $this->selectAll($sql);
        
    }

    public function register($identity_type,$client_identity,$name,$phone,$email,$address){

        $sql = "INSERT INTO clients (identity_type,client_identity,name,phone,email,address) VALUES (?,?,?,?,?,?)";
        $array = array($identity_type,$client_identity,$name,$phone,$email,$address);
        return $this->insert($sql, $array);
        
    }

    public function getValidate($field, $value, $action, $id) {
        if ($action == 'register' && $id == 0) {
            $sql = "SELECT id FROM clients WHERE $field = '$value'";
        }else {
            $sql = "SELECT id FROM clients WHERE $field = '$value' AND id != $id";
        }
        return $this->select($sql);
    }

    public function delete($status, $idClient) {

        $sql = "UPDATE clients SET status = ? WHERE id = ?";
        $array = array($status, $idClient);
        return $this->save($sql, $array);
        
    }

    public function edit($idClient) {

        $sql = "SELECT * FROM clients WHERE id = $idClient";
        return $this->select($sql);
        
    }

    public function update($identity_type,$client_identity,$name,$phone,$email,$address, $id){

        $sql = "UPDATE clients SET identity_type=?,client_identity=?,name=?,phone=?,email=?,address=? WHERE id=?";
        $array = array($identity_type,$client_identity,$name,$phone,$email,$address, $id);
        return $this->save($sql, $array);
        
    }
}
?>