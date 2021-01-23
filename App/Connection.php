<?php

namespace App;
//DataBase connection class
class Connection{

    public static function getDb(){
        $host = "127.0.0.1";
        $db_name = "db_tclone";
        $user = "root";
        $pass = "";
        try {
            $conn = new \PDO(
                "mysql:host=$host;dbname=$db_name;charset=utf8",
                $user,
                $pass
            );

            return $conn;
            
        } catch (\PDOException $e) {
            
        }
    }
}

?>
