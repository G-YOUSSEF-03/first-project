<?php 
session_start();
include("connexion.php"); 

if (!isset($_SESSION['user'])) {
  header("Location: index.php");
  exit;
}

?>

<?php

// $selectST = $pdo->query("SELECT * FROM stagiaire");
// $stagiaire = $selectST->fetchAll(PDO::FETCH_ASSOC);

?>

<?php
$search = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search'])) {
    $search = trim($_POST['search']);
}

$sql = "SELECT * FROM stagiaire";
$params = [];

if (!empty($search)) {
    $sql .= " WHERE nom LIKE :search OR prenom LIKE :search OR cin LIKE :search OR filiere LIKE :search";
    $params[':search'] = '%' . $search ;
}

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$stagiaires = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Student Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <style>
    :root {
      --main-color:rgb(230, 230, 230);
      --secondary-color:rgb(43, 153, 231);
    }

    body {
      background-color:var(--main-color);
      color: white;
    }
    .container {
      background-color: white;
      color: black;
      padding: 20px;
      border-radius: 10px;
      margin-top: 20px;
    }
    a{
      text-decoration: none;
      color: white;
    }
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
<body>
<nav class="navbar navbar-dark">
    <div class="container-fluid">
        <span class="navbar-brand">Operation !</span>
        <span class=""><img src="img/OIP (1).jpeg" class="logo" alt=""></span>
        
    </div>
</nav>
  <div class="container">
    <h2 class="mb-3">Gestion Stagiaire</h2>
    <div class="d-flex justify-content-between mb-3">
      <form method="POST" class="d-flex">
        <input type="text" 
               name="search" 
               class="form-control me-2" 
               placeholder="Rechercher par nom, prénom, CIN ou filière..."
               value="<?= htmlspecialchars($search) ?>">
        <button type="submit" class="btn btn-dark me-2">Rechercher</button>
      </form>
      <div>
        <!-- <button class="btn btn-primary text-white"><a href="historique.php">Historique</a></button> -->
        <button class="btn btn-dark text-white"><a href="ajouter.php">+ Ajouter</a></button>
      </div>
    </div>

    <table class="table table-bordered table-striped">
      <thead class="table-dark">
        <tr>
          <th>ID</th>
          <th>Cin</th>
          <th>Nom</th>
          <th>Prenom</th>
          <th>Date Naissance</th>
          <th>Adresse</th>
          <th>Filiere</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($stagiaires)): ?>
          <?php foreach($stagiaires as $stgr): ?>
            <tr>
              <th scope='row'><?= $stgr["code"] ?></th>
              <td><?= htmlspecialchars($stgr["cin"]) ?></td>
              <td><?= htmlspecialchars($stgr["nom"]) ?></td>
              <td><?= htmlspecialchars($stgr["prenom"]) ?></td>
              <td><?= htmlspecialchars($stgr["date_naissance"]) ?></td> 
              <td><?= htmlspecialchars($stgr["adresse"]) ?></td>
              <td><?= htmlspecialchars($stgr["filiere"]) ?></td> 
              <td>
                <button class="btn btn-primary text-white">
                  <a href="modifST.php?modifId=<?= $stgr["code"] ?>">modifier</a>
                </button>
                <button class="btn btn-danger text-white">
                  <a href="deleteST.php?deleteId=<?= $stgr["code"] ?>">supprimer</a>
                </button>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr>
            <td colspan="8" class="text-center">
              <?= empty($search) ? 'Aucun stagiaire trouvé' : 'Aucun résultat pour "' . htmlspecialchars($search) . '"' ?>
            </td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</body>
</html>