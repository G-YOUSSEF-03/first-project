<?php
session_start();
include('include.php');

if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit;
}

$user = $_SESSION['user'];

if (isset($_POST['submit'])) {
    if (!empty($_POST['addpost'])) {
        $addpost = htmlspecialchars(trim($_POST['addpost']));
        $insertpost = $conn->prepare("INSERT INTO posts (contenu) VALUES (?)");
        $insertpost->execute([$addpost]);
        header("Location: posts.php");
        exit;
    }
}

if (isset($_GET['delete'])) {
    $delete_id = intval($_GET['delete']);
    $delete = $conn->prepare("DELETE FROM posts WHERE id = ?");
    $delete->execute([$delete_id]);
    header("Location: posts.php");
    exit;
}

$posts = $conn->query("SELECT * FROM posts ORDER BY date_post DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Posts</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"/>
    <style>
        
    body {
        background:linear-gradient(to right ,rgbrgb(230, 230, 230), white); 
        color: #f1f1f1;
        font-family: 'Arial', sans-serif;
    }

    .navbar {
        background-color: rgb(5, 101, 126);
        padding: 10px;
    }

    .navbar .navbar-brand {
        color: #fff;
        font-weight: bold;
    }

    .container {
        padding-top: 30px;
        background:linear-gradient(to right ,rgb(5, 101, 126), white); 
        border-radius: 12px;
        padding: 40px;
        margin-top: 40px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.5);
        width: 85%;
    }

    .container h4 {
        border-left: 5px solid black;
        padding-left: 10px;
    }

    .add-post, .post-card {
        background-color: rgb(255, 255, 255);
        color: #f1f1f1;
        border: 1px solid black;
    }

    .post-card {
        border-left: 4px solid rgb(255, 255, 255);
    }

    .btn-primary {
        background-color:rgb(255, 255, 255);
        border: none;
    }

    .btn-danger {
        background-color:rgb(35, 35, 35);
        border: none;
    }

    .btn:hover {
        opacity: 0.9;
    }

    textarea {
        background-color: #1c1c1e;
        color: white;
        border: 1px solid #555;
    }

    i {
        color: #aaa;
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
    .titel{
        color: black;
    }
    .post-header{
        color: black;
    }
</style>

</head>
<body>

<nav class="navbar navbar-dark">
    <div class="container-fluid">
        <span class="navbar-brand">Gestion des posts </span>
        <span class=""><img src="img/OIP (1).jpeg" class="logo" alt=""></span>
        
    </div>
</nav>
<div class="container">
    <h4 class="mt-4 titel">Posts</h4>
    
    <?php foreach ($posts as $post): ?>
        <div class="card post-card">
            <div class="card-body">
                <div class="post-header"><?php echo htmlspecialchars($post['contenu']);
                echo "<br/>" ."<i>". htmlspecialchars($post['date_post'])."</i>";?></div>
                <div class="post-actions">
                    <a href="posts.php?delete=<?php echo $post['id']; ?>" class="btn btn-dark">Supprimer</a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

</body>
</html>