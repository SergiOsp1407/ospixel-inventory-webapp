<?php
class ConnectionDB{

    private $connect;

    public function __construct() {
        $pdo = "mysql:host" . HOST . ";dbname=" . DBNAME . ";" . CHARSET;
        try {
            $this->connect = new PDO($pdo, USER, PASS);
            $this->connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo 'Connected ';
        } catch (PDOException $e) {
            echo 'Error connecting to DB: ' . $e->getMessage();
        }
    }
    public function connectDB(){
        return $this->connect;
    }
}
?>