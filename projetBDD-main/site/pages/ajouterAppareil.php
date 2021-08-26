<?php include '../commonpart/sqlconnect.php';
if (!isset($_SESSION['user_id'])){
  header('Location: ../index.php');
} else {
?>
<!DOCTYPE html>
<html lang="fr" dir="ltr">
    <head>
        <meta charset="utf-8">
        <meta charset="utf-8">
        <link rel="stylesheet" href="../css/ajouterAppareil.css" />
        <link rel="stylesheet" href="../css/navbar.css" />
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
        <link rel="icon" type="image/png" href="../img/favicon.png" />
        <title></title>
    </head>
    <body>
        <?php include "../navbar.php";
            $id = $_POST['idAppt'];
        ?>
        <div class="container-fluid">
            <div class="container">
                <div class="login-form-div">
                    <form class="login-form" action="/site/pages/ajouterResSub.php" method="post">
                        <input type="hidden" name="idAppt" value="<?php echo $id;?>">
                        <p>Ajouter un appareil</p>
                        <div class="row">
                            <p>
                                <input type="text" name="libelle" id="libelle" placeholder="Nom Appareil">
                            </p>
                            <p>
                                <input type="textarea" name="description" id="description" placeholder="Description de l'appareil">
                            </p>
                            <p>
                            <label for="typeappareil">Type de l'appareil :</label>
                            <select id="typeappareil" name="typeappareil">
                            <?php
                                    $response = $bdd->prepare("SELECT * FROM `TypeAppareil` ORDER BY `Libelle` ASC");
                                    $response->execute();
                                    while ($row = $response->fetch()) {
                                ?>
                                    <option value="<?php echo $row['IdTypeAppareil'];?>"><?php echo $row['Libelle'];?></option>
                                <?php
                                    }
                                ?>
                              </select>

                           </p>
                            <p>
                            <label for="piece">Piece de l'appareil :</label>
                              <select id="piece" name="piece">
                                <?php
                                    $response = $bdd->prepare("SELECT DISTINCT p.IdPiece, p.Libelle FROM Piece p, ContenirPiece c WHERE p.IdPiece = c.IdPiece");

                                    $response->execute();
                                    while ($row = $response->fetch()) {
                                ?>
                                    <option value="<?php echo $row['IdPiece'];?>"><?php echo $row['Libelle'];?></option>
                                <?php
                                    }
                                ?>
                              </select>

                           </p>
                            <p>
                                <input type="text" name="descLieu" id="descLieu" placeholder="Description LocalisationAppareil">
                            </p>
                        </div>
                        <div class="rowx">


                          <div class="block">
                            <p>
                                Ressources
                            </p>
                            <?php
                                $response = $bdd->prepare("SELECT * FROM Ressources");
                                $response->execute();
                                while ($row = $response->fetch()) {
                            ?>
                            <p><input type="radio" name="<?php echo $row['Libelle'];?>" id="<?php echo $row['Libelle'];?>" value="<?php echo $row['IdRessource'];?>">
                                <label for="radio"><?php echo $row['Libelle'];?></label></p>
                            <?php
                                }
                            ?>

                          </div>
                          <div class="block spacer">
                            <p>
                                Substances
                            </p>
                            <?php
                                $response = $bdd->prepare("SELECT * FROM Substances");
                                $response->execute();
                                while ($row = $response->fetch()) {
                            ?>
                            <p><input type="radio" name="<?php echo $row['Libelle'];?>"  value="<?php echo $row['IdSubstance'];?>">
                                <label for="radio"><?php echo $row['Libelle'];?></label></p>
                            <?php
                                }
                            ?>
                          </div>
                        </div>

                        <p class="submit-button"><input class="submit-button" type="submit" name="submit"></p>

                    </form>
                </div>
            </div>
          </div>
    </body>
</html>
<?php } ?>
