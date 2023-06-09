<?php
class UsersModel extends Query{

    public function __construct() {
        parent::__construct();
    }

    public function getUsers($status){

        $sql = "SELECT CONCAT(name, ' ' ,lastname) AS completeName, email, phone, address, rol FROM users WHERE status = $status";
        return $this->selectAll($sql);

    }
}
?>