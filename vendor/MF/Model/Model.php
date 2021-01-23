<?php
//Abstract class for models
namespace MF\Model;

abstract class Model {
    protected $db;

    public function __construct(\PDO $db){
        $this->db = $db;
    }
}

?>