<?php
class Query extends ConnectionDB{

    private $pdo, $connection;

    public function __construct() {
        $this->pdo = new ConnectionDB();
        $this->connection = $this->pdo->connectDB();
    }

    public function select($sql){
        
        $result = $this->connection->prepare($sql);
        $result->execute();
        return $result->fetch(PDO::FETCH_ASSOC);
    }

    public function selectAll($sql){
        
        $result = $this->connection->prepare($sql);
        $result->execute();
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insert($sql, $array){
        
        $result = $this->connection->prepare($sql);
        $data = $result->execute($array);

        if ($data) {
            $response = $this->connection->lastInsertId();
        } else {
            $response = 0;
        }

        return $response;
        
    }

    public function save($sql, $array){
        
        $result = $this->connection->prepare($sql);
        $data = $result->execute($array);

        if ($data) {
            $response = 1;
        } else {
            $response = 0;
        }

        return $response;
        
    }

}
?>