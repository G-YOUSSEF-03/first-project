<?php
session_start();
include("connexion.php"); 

var_dump($_SESSION['user']);

if (!isset($_SESSION['user'])) {
  header("Location: index.php");
  exit;
}
?>

<?php

@$cin = $_POST["cin"];
@$nom =$_POST["nom"];
@$prenom = $_POST["prenom"];
@$dateN = $_POST["date"];
@$adresse = $_POST["adresse"];
@$filiere = $_POST["filiere"];
$user = $_SESSION['user'];

date_default_timezone_set("Africa/Casablanca");

if (isset($_POST["save"])){

  if(!empty($cin) && !empty($nom) && !empty($prenom) && !empty($dateN) && !empty($adresse) && !empty($filiere)){


    $insertSt = $pdo->prepare("INSERT INTO stagiaire (cin, nom, prenom, date_naissance, adresse, filiere) VALUES (?,?,?,?,?,?)");
    $insertSt->execute([$cin, $nom, $prenom, $dateN, $adresse, $filiere]);

  
    $hist_insert = $pdo->prepare("INSERT INTO historique ( admin_email, operation, prenom_ST, nom_ST, filiere_ST, date_operation, time_operation) VALUES (?,?,?,?,?,?,?)");
     $hist_insert->execute([$user['email'], "AJOUTER STAGIAIRE", $prenom, $nom, $filiere, date("Y-m-d"), date("H:i:s")]);
     
     echo "<div class='alert alert-success text-center'>Insertion réussie</div>";    
  }else{
    echo "<div class='alert alert-danger text-center'>les valeurs obligatoires.</div>";
  }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Ajouter un stagiaire</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: rgb(230, 230, 230); 
      font-family: Arial, sans-serif;
    }

    .container {
      background-color: white;
      color: black;
      padding: 30px;
      border-radius: 10px;
      margin-top: 50px;
      max-width: 600px;
    }

    h3 {
      text-align: center;
      margin-bottom: 30px;
      color:rgb(0, 0, 0); 
    }

    .form-control, .form-select {
      border-radius: 5px;
    }

    .btn-danger {
      color: white;
      border-radius: 5px;
    }

    .btn-secondary {
      background-color: #6c757d;
      color: white;
      border-radius: 5px;
    }

    .btn-secondary:hover, .btn-danger:hover {
      opacity: 0.9;
    }

    .mb-2, .mb-3 {
      margin-bottom: 15px;
    }
  </style>
</head>
<body>

  <div class="container">
    <h3>Ajouter un stagiaire</h3>
    <form method="post">
      <input type="hidden" name="code" value="">
      <div class="mb-2">
        <input type="text" name="cin" class="form-control" placeholder="CIN" value="" required>
      </div>
      <div class="mb-2">
        <input type="text" name="nom" class="form-control" placeholder="Nom" value="" required>
      </div>
      <div class="mb-2">
        <input type="text" name="prenom" class="form-control" placeholder="Prénom" value="" required>
      </div>
      <div class="mb-2">
        <input type="date" name="date" class="form-control" value="" required>
      </div>
      <div class="mb-2">
        <textarea  name="adresse" placeholder="Adresse" class="form-control" ></textarea>
      </div>
      <div class="mb-3">
        <label for="filiere" class="form-label">Filière</label>
        <select name="filiere" id="filiere" class="form-select" required>
          <option value="DEVELOPPEMENT DIGITAL">DEVELOPPEMENT DIGITAL</option>
          <option value="COMMERCE">COMMERCE</option>
          <option value="INFOGRAPHIE">INFOGRAPHIE</option>
        </select>
      </div>
      <button type="submit" class="btn btn-danger w-100 p-3" name="save"></button>
      <a href="index1.php" class="btn btn-secondary w-100 mt-3 p-3" ></a>
      
    </form>
  </div>

</body>
</html>