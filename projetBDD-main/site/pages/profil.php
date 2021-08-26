<?php include '../commonpart/sqlconnect.php';
if (isset($_SESSION['user_id'])){
?>
<!DOCTYPE html>
<html lang="fr" dir="ltr">
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="/site/css/profil.css" />
        <link rel="stylesheet" href="/site/css/navbar.css" />
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
        <link rel="icon" type="image/png" href="img/favicon.png" />
        <title></title>
    </head>
    <body>
        <?php include "../navbar.php";
        if (isset($_GET['error'])) {
            echo '<script> alert("'. $_GET['error'] . '"); </script>';
        }
        ?>
        <div class="container-fluid">
            <div class="container">
            <div class="profil-form-div">
            <form class="profil-form" action="../api/profilapi.php" method="post">
                <div class="row">
                    <?php
                        $response=$bdd->prepare("SELECT * From `personne` WHERE `Id_personne`=:Id_personne");
                        $response->execute(array('Id_personne'=>$_SESSION['user_id']));
                        while($row = $response->fetch()){
                    ?>
                    <div class="block">
                        <p>
                            <input type="text" class="NomPrenom" name="Nom" id="Nom" value="<?php echo $row['Nom']?>">
                            <input type="text" class="NomPrenom" name="Prenom" id="Prenom" value="<?php echo $row['Prenom']?>">
                        </p>
                        <p>
                            <input type="email" name="email" id="email" value="<?php echo $row['AdresseMail']?>">
                        </p>
                        <p>
                            <input type="password" name="password" id="password" placeholder="Mot de passe actuel">

                            <input type="password" name="password2" id="password2" placeholder="Nouveau Mot de passe">
                            <input type="password" name="password3" id="password3" placeholder="Confirmer Nouveau Mot de passe">
                        </p>
                    </div>
                    <div class="block-spacer">

                            <p>
                                    <input type="date" name="naissance" id="naissance" value="<?php echo $row['DateNaissance']?>">
                                </p>
                            <p>
                                <label for="gender">Genre :</label>
                                <?php
                                    $gender=$row['Genre'];
                                ?>
                                <select id="gender" name="gender">
                                    <?php
                                        if($gender=='m'){
                                    ?>
                                        <option value="m" selected>M</option>
                                        <option value="f">F</option>
                                        <option value="o">Autre</option>
                                    <?php
                                        }
                                        else if($gender=='f'){
                                    ?>
                                        <option value="m" >M</option>
                                        <option value="f" selected>F</option>
                                        <option value="o">Autre</option>
                                    <?php
                                        }else{
                                    ?>
                                        <option value="m" >M</option>
                                        <option value="f" >F</option>
                                        <option value="o" selected>Autre</option>

                                    <?php
                                        }
                                    ?>

                                </select>
                            </p>
                            <p>
                                    <input type="tel" name="telephone" id="telephone" value="<?php echo $row['Telephone']?>">
                            </p>
                    </div>


                </div>

                <p class="submit-button"><input class="submit-button" type="submit" name="modifier"></p>
            </form>

            </div>
            </div>
        </div>
    </body>
    <?php
        }
    ?>
</html>
<?php
}else {
    header('Location: ../index.php');
} ?>
