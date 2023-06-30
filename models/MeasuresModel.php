<?php
class MeasuresModel extends Query{

    public function __construct() {
        parent::__construct();
    }

    public function getMeasures($status) {

        $sql = "SELECT * FROM measures WHERE status = $status";
        return $this->selectAll($sql);
        
    }
}

?>