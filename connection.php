<?php

try {
    $host = "localhost";
    $db_name = "";
    $user = "root";
    $pass = "";

     $db = new PDO("mysql:host=$host;dbname=$db_name;charset=utf8", $user, $pass);
} catch ( PDOException $e ){
     print $e->getMessage();
}

require_once __DIR__ . '/functions.php';

?>