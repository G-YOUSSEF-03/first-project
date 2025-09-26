<?php
session_start();
include('include.php');

if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit;
}

$user = $_SESSION['user'];
$addpost = null;

if (isset($_POST['submit'])) {
    if (!empty($_POST['addpost'])) {
        $addpost = htmlspecialchars(trim($_POST['addpost']));
        $insertpost = $conn->prepare("INSERT INTO posts (text) VALUES (?)");
        $insertpost->execute([$addpost]);
        header("Location: posts.php");
        exit;
    }
}
$posts = $conn->query("SELECT * FROM posts ORDER BY date_post DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Administrateur</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background-color: rgb(230, 230, 230);
            font-family: Arial, sans-serif;
        }

        .navbar {
            background-color: rgb(0, 0, 0);
        }

        .navbar .navbar-brand {
            color: #fff;
            font-weight: bold;
           margin-left: 370px;
        }

        .navbar span {
            color: #e0e0e0;
        }

        .container {
            padding-top: 30px;
        }

        .add-post {
            background: linear-gradient(to right, rgb(5, 101, 126), rgb(146, 151, 154));
            border-radius: 10px;
            margin: 50px auto;
            padding: 30px;
            width: 60%;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        textarea {
            width: 100%;
            height: 150px;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
            border: none;
            font-size: 16px;
        }

        .btn-primary {
            background-color: rgba(27, 28, 29, 0.57);
            color: white;
            border: none;
            padding: 12px 20px;
            width: 100%;
            border-radius: 8px;
            font-size: 16px;
        }

        .btn-danger {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 8px;
        }

        .btn:hover {
            opacity: 0.8;
        }

        .card {
            margin: 20px auto;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .card-body {
            display: flex;
            justify-content: space-between;
            padding: 20px;
        }

        .post-header {
            font-weight: bold;
            font-size: 18px;
            color: #333;
        }

        .post-actions {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .post-actions a {
            color: #dc3545;
            text-decoration: none;
            font-size: 16px;
        }

        .post-actions a:hover {
            text-decoration: underline;
        }

        .navbar .text-white {
            font-size: 16px;
        }

        .navbar {
            background-color: rgb(5, 101, 126);
            padding: 10px;
        }

        .navbar .navbar-brand {
            color: #fff;
            font-weight: bold;
            text-align: center;
        }

        .profile-card {
            background: linear-gradient(to right, rgb(227, 224, 224), rgb(5, 101, 126));
            border-radius: 12px;
            color: white;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.4);
            transition: transform 0.3s ease;
        }

        .profile-card:hover {
            transform: scale(1.02);
        }

        .profile-img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            border: 3px solid white;
            object-fit: cover;
        }

        .text-muted {
            color: white;
        }

        .logo {
            width: 50px;
            height: 50px;
            border-radius: 50%;
        }

        .post {
            text-align: center;
            color: rgb(0, 0, 0);
            font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-dark">
    <div class="container-fluid">
        <span class="navbar-brand">Profil de l'Administrateur !</span>
        <span class=""><img src="img/OIP (1).jpeg" class="logo" alt=""></span>
    </div>
</nav>

<div class="container">
    <h3>Bienvenue, <?php echo htmlspecialchars($user['nom']); ?> !</h3>
    <p>Ceci est votre page d'administration.</p>
    <div class="profile-card d-flex align-items-center p-3 mb-4">
        <img src="https://api.dicebear.com/9.x/micah/svg?seed=<?php echo htmlspecialchars($user['email']); ?>" alt="Photo de profil" class="profile-img me-3">
        <div>
            <h5 class="mb-0"><?php echo htmlspecialchars($user['nom']); ?></h5>
            <small class="text-muted"><?php echo htmlspecialchars($user['email']); ?></small>
        </div>
    </div>

    <br><br>

    <form action="posts.php" method="post">
        <div class="add-post">
            <h3 class="post">Ajouter un Post :</h3>
            <textarea name="addpost" placeholder="Écrivez votre publication ici..." required></textarea>
            <button class="btn btn-light" name="submit">
                <i class="fas fa-plus"></i> Ajouter un Post
            </button>
        </div>
    </form>

</div>

</body>
</html>