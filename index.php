<?php
include('include.php');

if(isset($_POST['btn1'])) {
    try {
        if(!empty($_POST['email']) && !empty($_POST['password'])) {
            $nom = htmlspecialchars($_POST['name']);
            $email = htmlspecialchars($_POST['email']);
            $password = htmlspecialchars($_POST['password']);
            
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $sql = "INSERT INTO administrateur(nom, email, password) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$nom, $email, $hashedPassword]);

            $ressu2 =  "<div class='alert alert-success'>Inscription réussie !</div>";
        }
    } catch(PDOException $e) {
        echo "<div class='alert alert-danger'>Erreur : " . $e->getMessage() . "</div>";
    }
}

// Connexion
if(isset($_POST['btn2'])) {
    try {
        if(!empty($_POST['fullname2']) && !empty($_POST['password'])) {
            $email = htmlspecialchars($_POST['fullname2']);
            $password = $_POST['password'];

            $sql = "SELECT * FROM administrateur WHERE email = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$email]);

            if($stmt->rowCount() > 0) {
                $user = $stmt->fetch(PDO::FETCH_ASSOC);

                if(password_verify($password, $user['password'])) {
                    session_start();
                    $_SESSION['user'] = $user;
                    header("Location: Menu-jamili.php");
                    exit;
                } else {
                    $incorrectpass = "<div class='alert alert-danger'>Mot de passe incorrect.</div>";
                }
            } else {
                $incorrectemail =  "<div class='alert alert-danger'>Email introuvable.</div>";
            }
        } else {
            $obliger =  "<div class='alert alert-warning'>Veuillez remplir tous les champs.</div>";
        }
    } catch(PDOException $e) {
        echo "<div class='alert alert-danger'>Erreur : " . $e->getMessage() . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login Page</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css"/>
  <style>
    body {
        background: linear-gradient( rgb(206, 206, 206), rgb(255, 255, 255));
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        }

        .card {
        border: none;
        border-radius: 20px;
        overflow: hidden;
        display: flex;
        flex-direction: row;
        width: 950px;
        height: 450px;
        max-width: 100%;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }

        .left-panel {
        background: linear-gradient(135deg, rgb(5, 101, 126), #444444);
        color: white;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
        padding: 50px;
        flex: 1;
        border-top-left-radius: 20px;
        border-bottom-left-radius: 20px;
        }

        .left-panel h2 {
        font-weight: bold;
        margin-bottom: 15px;
        }

        .left-panel button {
        border: 2px solid white;
        padding: 10px 20px;
        border-radius: 25px;
        color: white;
        background: transparent;
        transition: 0.3s;
        }

        .left-panel button:hover {
        background: red;
        color: white;
        }

        .right-panel {
        flex: 1;
        background: #f8f9fa;
        position: relative;
        padding: 50px;
        border-top-right-radius: 20px;
        border-bottom-right-radius: 20px;
        overflow: hidden;
        margin: 50px;
        }

        .form-container {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        transition: all 0.5s ease-in-out;
        opacity: 0;
        transform: translateX(100%);
        }

        .form-container.active {
        opacity: 1;
        transform: translateX(0);
        z-index: 1;
        }

        .form-container.inactive-left {
        transform: translateX(-100%);
        }

        .form-title {
        text-align: center;
        margin-bottom: 25px;
        }

        .input-group-text {
        background: #f8f9fa;
        border-right: 0;
        }

        .form-control {
        border-left: 0;
        }

        .social-buttons button {
        width: 40px;
        height: 40px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        border-radius: 50%;
        border: 1px solid #ccc;
        background: white;
        margin: 5px;
        }

        button {
        background-color:rgb(5, 101, 126)!important;
        color: white !important;
        }

        button:hover {
        border-color:rgb(65, 65, 65) !important;
        }
        a{
          text-decoration: none;
        }
        #login-form{
          margin-top: 30px;
        }
        

  </style>
</head>
<body>
  <div class="card">
    <div class="left-panel">
      <h2>Bonjour, Bienvenue !</h2>
      <p id="toggle-text">Pas encore de compte ?</p>
      <button id="toggle-btn" class="btn">S'inscrire</button>
    </div>
    <div class="right-panel">
      <!-- Connexion -->
      <div id="login-form" class="form-container active">
        <h3 class="form-title">Connexion</h3>
        <!-- Formulaire de Connexion -->
        <form method="post">
          <div class="mb-3 input-group">
            <span class="input-group-text"><i class="bi bi-person"></i></span>
            <input type="text" name="fullname2" class="form-control" placeholder="Administrateur@gmail.com" required>
          </div>
          <div class="mb-3 input-group">
            <span class="input-group-text"><i class="bi bi-lock"></i></span>
            <input type="password" name="password" class="form-control" placeholder="Mot de passe" required>
          </div>
          <div class="mb-3 text-end">
            <a href="#" class="text-decoration-none">Mot de passe oublié ?</a>
          </div>
          
          <button class="btn btn-info w-100" name="btn2">Connexion</button>

          <p>
            <?php if(isset($incorrectpass)) echo $incorrectpass;?>
            <?php if(isset($incorrectemail)) echo $incorrectemail;?>
            <?php if(isset($obliger)) echo $obliger;?>
            <?php if(isset($ressu)) echo $ressu;?>
            <?php if(isset($ressu2)) echo $ressu2;?>
          </p>
          
        </form>
        
        <!-- <div class="text-center mt-3">
          <p>ou connectez-vous avec</p>
          <div class="social-buttons">
            <button class="btn"><i class="bi bi-google"></i></button>
            <button class="btn"><i class="bi bi-facebook"></i></button>
            <button class="btn"><i class="bi bi-linkedin"></i></button>
          </div>
        </div> -->
      </div>

      <!-- Inscription -->
      <div id="register-form" class="form-container">
        <h3 class="form-title">Créer un compte</h3>
        <!-- Formulaire d'inscription -->
        <form method="post">
          <div class="mb-3 input-group">
            <span class="input-group-text"><i class="bi bi-person"></i></span>
            <input type="text" name="name" class="form-control" placeholder="Nom complet" required>
          </div>
          <div class="mb-3 input-group">
            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
            <input type="email" name="email" class="form-control" placeholder="Email" required>
          </div>
          <div class="mb-3 input-group">
            <span class="input-group-text"><i class="bi bi-lock"></i></span>
            <input type="password" name="password" class="form-control" placeholder="Mot de passe" required>
          </div>
          <button class="btn btn-light w-100" name="btn1">S'inscrire</button>
        </form>
      </div>
    </div>
  </div>

  <script>
    const toggleBtn = document.getElementById('toggle-btn');
    const toggleText = document.getElementById('toggle-text');
    const loginForm = document.getElementById('login-form');
    const registerForm = document.getElementById('register-form');

    toggleBtn.addEventListener('click', () => {
      const isLoginActive = loginForm.classList.contains('active');

      if (isLoginActive) {
        loginForm.classList.remove('active');
        loginForm.classList.add('inactive-left');
        registerForm.classList.remove('inactive-left');
        registerForm.classList.add('active');
        toggleBtn.textContent = 'Connexion';
        toggleText.textContent = 'Déjà un compte ?';
      } else {
        registerForm.classList.remove('active');
        registerForm.classList.add('inactive-left');
        loginForm.classList.remove('inactive-left');
        loginForm.classList.add('active');
        toggleBtn.textContent = "S'inscrire";
        toggleText.textContent = "Pas encore de compte ?";
      }
    });
  </script>
</body>
</html>