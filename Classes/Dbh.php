<?php

namespace Classes;

class Dbh {
     protected function create_connection() {
        try {
            // $db_connection = new \PDO('mysql:host=localhost;port=3306;dbname=NotesDbFinal', 'root', 'root');
            $db_connection = new \PDO('mysql:host=containers-us-west-187.railway.app;dbname=railway;port=5543;', 'root', 'YNGgO639C3fVlgGSMx8g');
            return $db_connection;
        } catch(PDOException $e) {
            echo 'Database connection failed';
            error_log($e);
        }
    }

}


?>