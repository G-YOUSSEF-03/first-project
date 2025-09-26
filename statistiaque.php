<?php
session_start();
include("connexion.php");

if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit;
  }
 ?>



<?php

try {
$selectTotal = $pdo->query("SELECT COUNT(code) AS Nombre_Stagiaire FROM stagiaire ");

$totalStg = $selectTotal->fetchAll(PDO::FETCH_ASSOC);


foreach($totalStg as $tot){
    @$total = $tot["Nombre_Stagiaire"];
 }

} catch (PDOException $e) {

    echo "failed ". $e->getMessage();

}

?>

<?php



try {
$selectDev = $pdo->query("SELECT COUNT(code) AS total_dev FROM stagiaire WHERE filiere = 'DEVELOPPEMENT DIGITAL' ");

$totalDev = $selectDev->fetchAll(PDO::FETCH_ASSOC);


foreach($totalDev as $dev){
    @$developpment = $dev["total_dev"];
 }

} catch (PDOException $e) {

    echo "failed ". $e->getMessage();

}

?>


<?php



try {
$selectCom = $pdo->query("SELECT COUNT(code) AS total_comemrce FROM stagiaire WHERE filiere = 'COMMERCE' ");

$totalCom = $selectCom->fetchAll(PDO::FETCH_ASSOC);


foreach($totalCom as $com){
    @$commerece = $com["total_comemrce"];
 }

} catch (PDOException $e) {

    echo "failed ". $e->getMessage();

}

?>

<?php



try {
$selectCom = $pdo->query("SELECT COUNT(code) AS total_comemrce FROM stagiaire WHERE filiere = 'COMMERCE' ");

$totalCom = $selectCom->fetchAll(PDO::FETCH_ASSOC);


foreach($totalCom as $com){
    @$commerece = $com["total_comemrce"];
 }

} catch (PDOException $e) {

    echo "failed ". $e->getMessage();

}

?>


<?php



try {
$selectInfog = $pdo->query("SELECT COUNT(code) AS total_infog FROM stagiaire WHERE filiere = 'INFOGRAPHIE' ");

$totalInfog = $selectInfog->fetchAll(PDO::FETCH_ASSOC);


foreach($totalInfog as $infog){
    @$infographie = $infog["total_infog"];
 }

} catch (PDOException $e) {

    echo "failed ". $e->getMessage();

}

?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
        .navbar {
        background-color: rgb(5, 101, 126);
        padding: 10px;
    }

    .navbar .navbar-brand {
        color: #fff;
        font-weight: bold;
    }
    .logo {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        border: 2px solid white;
    }
    .navbar-brand{
        margin-left: 360px;
    }
</style>
</head>

<body class="bg-light">
<nav class="navbar navbar-dark">
    <div class="container-fluid">
        <span class="navbar-brand">Statistiques !</span>
        <span class=""><img src="img/OIP (1).jpeg" class="logo" alt=""></span>
        
    </div>
</nav>

<div class="container py-5">
    <h2 class="text-center mb-5">Statistiques des Stagiaires</h2>
    
    <div class="row g-4">

        <div class="col-md-4 col-lg-3">
            <div class="card shadow-sm border-0 text-center h-100">
                <div class="card-body">
                    <h5 class="card-title text-primary">Total Stagiaires</h5>
                    <p class="display-6"><?= $total; ?></p>
                </div>
            </div>
        </div>

        <div class="col-md-4 col-lg-3">
            <div class="card shadow-sm border-0 text-center h-100">
                <div class="card-body">
                    <h5 class="card-title text-success">Développement Digital</h5>
                    <p class="display-6"><?= $developpment; ?></p>
                </div>
            </div>
        </div>

        <div class="col-md-4 col-lg-3">
            <div class="card shadow-sm border-0 text-center h-100">
                <div class="card-body">
                    <h5 class="card-title text-warning">Commerce</h5>
                    <p class="display-6"><?= $commerece; ?></p>
                </div>
            </div>
        </div>

        <div class="col-md-4 col-lg-3">
            <div class="card shadow-sm border-0 text-center h-100">
                <div class="card-body">
                    <h5 class="card-title text-danger">Infographie</h5>
                    <p class="display-6"><?= $infographie; ?></p>
                </div>
            </div>
        </div>

    </div>
</div>

</body>
    

</html>

