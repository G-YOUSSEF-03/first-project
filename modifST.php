<?php 
session_start();

include("connexion.php"); 

if (!isset($_SESSION['user'])) {
  header("Location: index.php");
  exit;
}
?>

<?php


$getId = $_GET["modifId"];
$user = $_SESSION['user'];


@$cin = $_POST["cin"];
@$nom =$_POST["nom"];
@$prenom = $_POST["prenom"];
@$dateN = $_POST["date"];
@$adresse = $_POST["adresse"];
@$filiere = $_POST["filiere"];

$selectST = $pdo->query("SELECT * FROM stagiaire WHERE code = $getId");

$stagiaire = $selectST->fetchAll(PDO::FETCH_ASSOC);


date_default_timezone_set("Africa/Casablanca");

if(isset($_POST["modifier"])){

    try{ 

        $modifierST = $pdo->prepare("UPDATE stagiaire SET cin = ? , nom = ? , prenom = ? , date_naissance = ? , adresse = ? , filiere = ? WHERE Code = ? ");
        $modifierST ->execute([$cin, $nom, $prenom, $dateN, $adresse, $filiere, $getId]);  
        $message ="Les détails du stagiaire ont été mis à jour avec succès !";
        

        $hist_insert = $pdo->prepare("INSERT INTO historique ( admin_email, operation, prenom_ST, nom_ST,   filiere_ST, date_operation, time_operation) VALUES (?,?,?,?,?,?,?)");
        $hist_insert->execute([$user['email'], "MODIFIER STAGIAIRE", $prenom, $nom, $filiere, date("Y-m-d"),  date("H:i:s")]);

        ?> 
        <?php echo "<div class='alert alert-success text-center'>$message</div>" ?>
        <?php

    } catch (PDOException $e) {

       echo "failed ". $e->getMessage();

    }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Student Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: rgb(230, 230, 230);
      color: white;
      font-family: Arial, sans-serif;
      margin-top: 20px;
    }
    .container {
      background-color: white;
      color: black;
      padding: 30px;
      border-radius: 10px;
      max-width: 800px;
      margin: 20px auto;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    }
    .modal-header {
      background-color:rgb(0, 0, 0);
      color: white;
    }
    .modal-footer .btn {
      margin-right: 10px;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2 class="text-center mb-4">Mettre à jour les informations de l'étudiant</h2>
    <form action="" method="POST">
      <?php foreach ($stagiaire as $stgr) { ?>
        <div class="mb-3">
          <label for="cin" class="form-label">CIN:</label>
          <input type="text" name="cin" id="cin" class="form-control" placeholder="Enter CIN" value="<?= (isset($_POST["modifier"])) ? $cin : $stgr["cin"]; ?>" />
        </div>
        <div class="mb-3">
          <label for="nom" class="form-label">Nom:</label>
          <input type="text" name="nom" id="nom" class="form-control" placeholder="Enter Nom" value="<?= (isset($_POST["modifier"])) ? $nom : $stgr["nom"]; ?>" />
        </div>
        <div class="mb-3">
          <label for="prenom" class="form-label">Prenom:</label>
          <input type="text" name="prenom" id="prenom" class="form-control" placeholder="Enter Prenom" value="<?= (isset($_POST["modifier"])) ? $prenom : $stgr["prenom"]; ?>" />
        </div>
        <div class="mb-3">
          <label for="date" class="form-label">Date de Naissance:</label>
          <input type="date" name="date" id="date" class="form-control" value="<?= (isset($_POST["modifier"])) ? $dateN : $stgr["date_naissance"]; ?>" />
        </div>
        <div class="mb-3">
          <label for="adresse" class="form-label">Adresse:</label>
          <textarea name="adresse" id="adresse" rows="3" class="form-control" placeholder="Enter Adresse"><?= (isset($_POST["modifier"])) ? $adresse : $stgr["adresse"]; ?></textarea>
        </div>
        <div class="mb-3">
          <label for="filiere" class="form-label">Filiere:</label>
          <select name="filiere" id="filiere" class="form-select">
            <option value="<?= (isset($_POST["modifier"])) ? $filiere : $stgr["filiere"]; ?>">Old Value (<?= (isset($_POST["modifier"])) ? $filiere : $stgr["filiere"]; ?>)</option>
            <option value="DEVELOPPEMENT DIGITAL">DEVELOPPEMENT DIGITAL</option>
            <option value="COMMERCE">COMMERCE</option>
            <option value="INFOGRAPHIE">INFOGRAPHIE</option>
          </select>
        </div>
      <?php } ?>
      <div class="d-flex justify-content-between">
        <a href="index1.php" class="btn btn-secondary">Annuler</a>
        <button type="submit" name="modifier" class="btn btn-primary">modifier</button>
      </div>
    </form>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>