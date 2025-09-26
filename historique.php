<?php
session_start();

include("connexion.php"); 

if (!isset($_SESSION['user'])) {
  header("Location: index.php");
  exit;
}
?>
<?php

$selectHist = $pdo->query("SELECT * FROM historique ");
$historique = $selectHist->fetchAll(PDO::FETCH_ASSOC);

?>

<?php
$search = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search'])) {
    $search = trim($_POST['search']);
}

$sql = "SELECT * FROM historique";
$params = [];

if (!empty($search)) {
    $sql .= " WHERE admin_email LIKE :search OR operation LIKE :search OR prenom_ST LIKE :search OR nom_ST LIKE :search OR filiere_ST LIKE :search";
    $params[':search'] = '%' . $search . '%';
}

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$historique = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    body {
      background-color:rgb(230, 230, 230);
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
        <span class="navbar-brand">Historique</span>
        <span class=""><img src="img/OIP (1).jpeg" class="logo" alt=""></span>
        
    </div>
</nav>
  <div class="container">
    <h2 class="mb-3">Historique</h2>
    <div class="d-flex justify-content-between mb-3">
      <form method="POST" class="d-flex w-50">
        <input type="text" 
               name="search" 
               class="form-control" 
               placeholder="Rechercher par email, opération, nom, prénom ou filière..."
               value="<?= ($search) ?>">
        <button type="submit" class="btn btn-outline-dark ms-2">Rechercher</button>
      </form>
    </div>

    <table class="table table-bordered table-striped">
      <thead class="table-dark">
        <tr>
          <th>Admin Email</th>
          <th>Operation</th>
          <th>Prenom</th>
          <th>Nom</th>
          <th>Filiere</th>
          <th>Date</th>
          <th>Temps</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($historique)): ?>
          <?php foreach($historique as $hist): ?>
            <tr>
              <th scope='row'><?= ($hist["admin_email"]) ?></th>
              <td><?= ($hist["operation"]) ?></td>
              <td><?= ($hist["prenom_ST"]) ?></td>
              <td><?= ($hist["nom_ST"]) ?></td>
              <td><?= ($hist["filiere_ST"]) ?></td> 
              <td><?= ($hist["date_operation"]) ?></td>
              <td><?= ($hist["time_operation"]) ?></td> 
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr>
            <td colspan="7" class="text-center">
              <?= empty($search) ? 'Aucune activité trouvée' : 'Aucun résultat pour "' . htmlspecialchars($search) . '"' ?>
            </td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</body>
</html>