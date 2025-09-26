<?php
$dsn = "mysql:host=localhost;dbname=gestion_stagiaire";
$username = "root";
$password = "root";

try {
    $pdo = new PDO($dsn,$username,$password);
    echo "";
} catch (PDOException $e) {

    echo "failed ". $e->getMessage();
}
?>

<?php
$dsn = "mysql:host=localhost;dbname=gestion_stagiaire;charset=utf8";
$username = "root";
$password = "root";

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "";
} catch (PDOException $e) {
    echo "Échec de la connexion : " . $e->getMessage();
}
?>