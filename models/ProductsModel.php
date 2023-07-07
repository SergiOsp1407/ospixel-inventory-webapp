<?php
class ProductsModel extends Query{
    public function __construct() {
        parent::__construct();
    }

    public function getProducts($status) {

        $sql = "SELECT p.*, m.measure, c.category FROM products p INNER JOIN measures m ON p.id_measure = m.id INNER JOIN categories c ON p.id_category = c.id WHERE p.status = $status";
        return $this->selectAll($sql);
        
    }

    public function getData($table) {

        $sql = "SELECT * FROM $table WHERE status = 1";
        return $this->selectAll($sql);
        
    }

    public function register($code, $description, $purchase_price, $sale_price, $id_measure, $id_category, $photo) {

        $sql = "INSERT INTO products (code, description, purchase_price, sale_price, id_measure, id_category, photo) VALUES (?,?,?,?,?,?,?)";
        $array = array($code, $description, $purchase_price, $sale_price, $id_measure, $id_category, $photo);
        return $this->insert($sql, $array);
        
    }

    public function getValidate($field, $value, $action, $id) {
        if ($action == 'register' && $id == 0) {
            $sql = "SELECT id FROM products WHERE $field = '$value'";
        }else {
            $sql = "SELECT id FROM products WHERE $field = '$value' AND id != $id";
        }
        return $this->select($sql);
    }

}
?>