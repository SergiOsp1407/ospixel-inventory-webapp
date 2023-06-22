<?php
class UsersModel extends Query{

    public function __construct() {
        parent::__construct();
    }

    public function getUsers($status){

        $sql = "SELECT CONCAT(name, ' ' ,lastname) AS completeName, email, phone, address, rol FROM users WHERE status = $status";
        return $this->selectAll($sql);

    }

    public function register($names, $lastname, $email, $phone, $address, $password, $rol){
        $sql = "INSERT INTO users (name, lastname, email, phone, address, password, rol) VALUES (?,?,?,?,?,?,?)";
        $array = array($names, $lastname, $email, $phone, $address, $password, $rol);
        return $this->insert($sql, $array);
    }
}
?>