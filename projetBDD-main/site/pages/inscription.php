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
        <link rel="stylesheet" href="../css/inscription.css" />
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
                    <form class="login-form" action="/site/api/registerapi.php" method="post">
                        <p>S'INSCRIRE</p>
                        <div class="row">
                          <div class="block">
                            <p>
                                <input type="text" name="email" id="email" placeholder="Adresse mail">
                            </p>
                            <p>
                                <input type="password" name="password" id="password" placeholder="Mot de passe">
                            </p>
                            <p>
                                <input type="text" class="nomprenom" name="nom" id="nom" placeholder="Nom">
                                <input type="text" class="nomprenom" name="prenom" id="prenom" placeholder="Prénom">
                            </p>
                          </div>
                          <div class="block spacer">
                            <p>
                                <input type="date" name="naissance" id="naissance" placeholder="Naissance">
                            </p>
                            <p>
                              <label for="gender">Genre :</label>
                              <select id="gender" name="gender">
                                <option value="m">M</option>
                                <option value="f">F</option>
                                <option value="o">Autre</option>
                              </select>
                            </p>
                            <p>
                                <input type="tel" name="telephone" id="telephone" placeholder="Téléphone">
                            </p>
                          </div>
                        </div>
                        <p class="submit-button"><input class="submit-button" type="submit" name="submit"></p>
                        <a class="link-inscription" href="login.php">Déjà un compte ? Connectez-vous en cliquant ici !</a>
                    </form>
                </div>
            </div>
          </div>
    </body>
</html>
<?php } ?>
