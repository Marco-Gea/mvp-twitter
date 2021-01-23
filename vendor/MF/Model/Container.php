<?php
//Abstract class for controllers and models work
namespace MF\Model;

//Use database's connection class
use App\Connection;

class Container {

    public static function getmodel($model){
        $class = "\\App\\Models\\".ucfirst($model);

        $conn = Connection::getDb();

        return new $class($conn);
    }

}

?>