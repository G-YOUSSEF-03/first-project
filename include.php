<?php

$dsn = "mysql:host=localhost;dbname=gestion_stagiaire";
$dbname = "root";
$password = "root";

try{
    $conn = new PDO($dsn,$dbname,$password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e){
    echo "error".$e ;
}
?>