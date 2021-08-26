<?php include '../commonpart/sqlconnect.php';
if (isset($_SESSION['user_id'])){
  header('Location: ../index.php');
} else {
?>
<!DOCTYPE html>
<html lang="fr" dir="ltr">
    <head>
        <meta charset="utf-8">
        <meta charset="utf-8">
        <link rel="stylesheet" href="../css/login.css" />
        <link rel="stylesheet" href="../css/navbar.css" />
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
        <link rel="icon" type="image/png" href="../img/favicon.png" />
        <title></title>
    </head>
    <body>
        <?php include "../navbar.php"; ?>
        <div class="container-fluid">
            <div class="container">
                <div class="login-form-div">
                    <form class="login-form" action="/site/api/loginapi.php" method="post">
                        <p>SE CONNECTER</p>
                        <p>
                            <input type="text" name="email" id="email" placeholder="Adresse mail">
                        </p>
                        <p>
                            <input type="password" name="password" id="password" placeholder="Mot de passe">
                        </p>
                        <p class="submit-button"><input class="submit-button" type="submit" name="submit"></p>
                        <a class="link-inscription" href="inscription.php">Pas de compte ? Inscrivez-vous en cliquant ici !</a>
                    </form>
                </div>
            </div>
        </div>

    </body>
</html>
<?php } ?>
