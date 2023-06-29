<?php
class UsersModel extends Query{

    public function __construct() {
        parent::__construct();
    }

    public function getUsers($status){

        $sql = "SELECT id, CONCAT(name, ' ' ,lastname) AS completeName, email, phone, address, rol FROM users WHERE status = $status";
        return $this->selectAll($sql);

    }

    public function register($names, $lastname, $email, $phone, $address, $password, $rol){
        $sql = "INSERT INTO users (name, lastname, email, phone, address, password, rol) VALUES (?,?,?,?,?,?,?)";
        $array = array($names, $lastname, $email, $phone, $address, $password, $rol);
        return $this->insert($sql, $array);
    }

    public function getValidate($field, $value, $action, $id) {
        if ($action == 'register' && $id == 0) {
            $sql = "SELECT id, email, phone FROM users WHERE $field = '$value'";
        }else {
            $sql = "SELECT id, email, phone FROM users WHERE $field = '$value' AND id != $id";
        }
        return $this->select($sql);
    }

    public function delete($status,$id){

        $sql = "UPDATE users SET status = ? WHERE id = ?";
        $array = array($status,$id);
        return $this->save($sql, $array);
        
    }

    public function edit($id) {
        
        $sql = "SELECT id,name,lastname,email,phone,address,rol FROM users WHERE id = $id";
        return $this->select($sql);
    }

    public function update($names, $lastname, $email, $phone, $address, $rol, $id){
        $sql = "UPDATE users SET name=?, lastname=?, email=?, phone=?, address=?, rol=? WHERE id=?";
        $array = array($names, $lastname, $email, $phone, $address, $rol, $id);
        return $this->save($sql, $array);
    }
}
?>