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
}