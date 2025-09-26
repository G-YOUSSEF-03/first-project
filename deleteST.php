<?php 
session_start();

include("connexion.php"); 
if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit;
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <title>Document</title>
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
 <style>
    body{
        background-color: rgb(230, 230, 230);
    }
 button {
     background-color: black;
     border: none;
     border-radius: 8px;
     padding: 8px;
 }
 .link {
     text-decoration: none;
     color: white;
 }
 </style>
</head>
<body>

<?php
$user = $_SESSION['user'];


$getId = $_GET["deleteId"]; 

$selectEtud = $pdo->query("SELECT * FROM stagiaire WHERE code = $getId");

$selectNom = $pdo->query("SELECT nom FROM stagiaire WHERE code = $getId");
$echoNom = $selectNom->fetchAll(PDO::FETCH_ASSOC);

$selectPrenom = $pdo->query("SELECT prenom FROM stagiaire WHERE code = $getId");
$echoPrenom = $selectPrenom->fetchAll(PDO::FETCH_ASSOC);

$selectfiliere = $pdo->query("SELECT filiere FROM stagiaire WHERE code = $getId");
$echofiliere = $selectfiliere->fetchAll(PDO::FETCH_ASSOC);

foreach ($echoNom as $nom) {
 @$n = $nom["nom"];
}
foreach ($echoPrenom as $pre) {
@$p = $pre["prenom"];
}
foreach ($echofiliere as $fil) {
 @$f = $fil["filiere"];
}

$etudiant = $selectEtud->fetchAll(PDO::FETCH_ASSOC);

date_default_timezone_set("Africa/Casablanca");

try {  
 $hist_insert = $pdo->prepare("INSERT INTO historique (admin_email, operation, prenom_ST, nom_ST, filiere_ST, date_operation, time_operation) VALUES (?,?,?,?,?,?,?)");
 $hist_insert->execute([$user['email'], "SUPPRIMER STAGIAIRE", $p, $n, $f, date("Y-m-d"), date("H:i:s")]);

 $deleteST = $pdo->prepare("DELETE FROM stagiaire WHERE code = ? ");
 $deleteST->execute([$getId]); 

 $message = "Stagiaire supprimé avec succès !";
 echo "<div class='alert alert-success text-center'>$message</div>";

} catch (PDOException $e) {
 echo "<div class='alert alert-danger text-center'>Failed: " . $e->getMessage() . "</div>";
}
?>
<div class="text-center mt-4">
 <button class="btn btn-dark"><a href="index1.php" class="link">Liste des stagiaires</a></button>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>