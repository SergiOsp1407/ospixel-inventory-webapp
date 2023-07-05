<?php
class MeasuresModel extends Query{

    public function __construct() {
        parent::__construct();
    }

    public function getMeasures($status) {

        $sql = "SELECT * FROM measures WHERE status = $status";
        return $this->selectAll($sql);
        
    }

    public function register($measure, $short_name) {
        
        $sql = "INSERT INTO measures(measure, short_name) VALUES (?,?)";
        $array = array($measure, $short_name);
        return $this->insert($sql,$array);
    }

    public function getValidate($field, $value, $action, $id) {
        if ($action == 'register' && $id == 0) {
            $sql = "SELECT id FROM measures WHERE $field = '$value'";
        }else {
            $sql = "SELECT id FROM measures WHERE $field = '$value' AND id != $id";
        }
        return $this->select($sql);
    }

    public function delete($status, $idMeasure) {
        $sql = "UPDATE measures SET status = ? WHERE id = ?";
        $array = array($status, $idMeasure);
        return $this->save($sql, $array);        
    }

    public function edit($idMeasure) {

        $sql = "SELECT * FROM measures WHERE id = $idMeasure";
        return $this->select($sql);
        
    }

    public function update($measure, $short_name, $id) {
        
        $sql = "UPDATE measures SET measure = ?, short_name = ? WHERE id = ?";
        $array = array($measure, $short_name, $id);
        return $this->save($sql,$array);
    }
}

?>
