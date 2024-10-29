<?php

function db_connect() {
    $host = 'localhost';
    $dbname = 'ChefMe';
    $username = 'root';
    $password = '';
    try{
        return new PDO('mysql:host=' . $host . ';dbname=' . $dbname, $username, $password);
    }
    catch(PDOException $e){
        echo 'Error: ' . $e->getMessage();
    
    }
}


?>