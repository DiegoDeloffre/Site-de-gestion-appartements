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
        $id = $_POST['idAppt'];?>
        <div class="container-fluid">
            <div class="container">
                <div class="login-form-div">
                    <form class="login-form" action="/site/api/ajouterAppareilapi.php" method="post">
                        <input type="hidden" name="idAppt" value="<?php echo $id;?>">
                        <input type="hidden" name="libelle" id="libelle" value="<?php echo $_POST['libelle']; ?>">

                        <input type="hidden" name="description" id="description" value="<?php echo $_POST['description']; ?>">

                        <input type="hidden" name="typeappareil" id="typeappareil" value="<?php echo $_POST['typeappareil']; ?>">

                        <input type="hidden" name="piece" id="piece" value="<?php echo $_POST['piece']; ?>">

                        <input type="hidden" name="descLieu" id="descLieu" value="<?php echo $_POST['descLieu']; ?>">

                        <p>Définir les consommations et émissions respectives des ressources et substances pour cet appareil</p>
                        <div class="rowx">
                          <div class="block">
                            <p>
                                Ressources
                            </p>
                            <?php
                                if(isset($_POST['Eau'])){
                                    $response = $bdd->prepare("SELECT * FROM Ressources WHERE IdRessource=:nomRes");
                                    $response->execute(array('nomRes'=>$_POST['Eau']));
                                    while ($row = $response->fetch()) {
                                        $libell=$row['Libelle'];
                            ?>
                                <p>
                                    <label for="typeappareil"><?php echo $row['Libelle'];?></label><br>
                                    <input type="hidden" name="<?php echo $row['Libelle'];?>" id="<?php echo $row['Libelle'];?>" value="<?php echo $row['IdRessource'];?>">
                                    <input type="number" step="0.01" name="<?php echo $row['IdRessource'];?>" id="<?php echo $row['IdRessource'];?>" placeholder="Conso / h">
                                </p>
                            <?php
                                }
                            }else{
                            ?>
                                    <input type="hidden" name="<?php echo $libell;?>" id="<?php echo $libell;?>" value="0">
                            <?php
                            }
                                if(isset($_POST['Electricité'])){
                                    $response = $bdd->prepare("SELECT * FROM Ressources WHERE IdRessource=:nomRes");
                                    $response->execute(array('nomRes'=>$_POST['Electricité']));
                                    while ($row = $response->fetch()) {
                                        $libell=$row['Libelle'];
                            ?>
                                <p>
                                    <label for="typeappareil"><?php echo $row['Libelle'];?></label><br>
                                    <input type="hidden" name="Electricité" value="<?php echo $row['IdRessource'];?>">
                                    <input type="number" step="0.01" name="<?php echo $row['IdRessource'];?>"  placeholder="Conso / h">
                                </p>
                            <?php
                                }
                            }else{
                            ?>
                                    <input type="hidden" name="Electricité" value="0">
                            <?php
                                }
                                if(isset($_POST['Gaz'])){
                                    $response = $bdd->prepare("SELECT * FROM Ressources WHERE IdRessource=:nomRes");
                                    $response->execute(array('nomRes'=>$_POST['Gaz']));
                                    while ($row = $response->fetch()) {
                            ?>
                                <p>
                                    <label for="typeappareil"><?php echo $row['Libelle'];?></label><br>
                                    <input type="hidden" name="Gaz" value="<?php echo $row['IdRessource'];?>">
                                    <input type="number" step="0.01" name="<?php echo $row['IdRessource'];?>" placeholder="Conso / h">
                                </p>
                            <?php
                                }
                            }else{
                            ?>
                                    <input type="hidden" name="Gaz"  value="0">
                            <?php
                                }
                        ?>


                          </div>
                          <div class="block spacer">
                            <p>
                                Substances
                            </p>
                            <?php
                                if(isset($_POST['CO2'])){
                                    $response = $bdd->prepare("SELECT * FROM Substances WHERE IdSubstance=:nomSub");
                                    $response->execute(array('nomSub'=>$_POST['CO2']));
                                    while ($row = $response->fetch()) {
                                        $libell=$row['Libelle'];
                            ?>
                            <p>
                            <label for="typeappareil"><?php echo $row['Libelle'];?></label><br>
                            <input type="hidden" name="<?php echo $row['Libelle'];?>" value="<?php echo $row['IdSubstance'];?>">
                            <input type="number" step="0.01" name="<?php echo $row['IdSubstance'];?>"  placeholder="Emission / h">
                            </p>
                            <?php
                                }
                            }else{
                            ?>
                                    <input type="hidden" name="CO2" value="0">
                            <?php
                                }
                            if(isset($_POST['Eaux-grises'])){
                                    $response = $bdd->prepare("SELECT * FROM Substances WHERE IdSubstance=:nomSub");
                                    $response->execute(array('nomSub'=>$_POST['Eaux-grises']));
                                    while ($row = $response->fetch()) {
                            ?>
                            <p>
                            <label for="typeappareil"><?php echo $row['Libelle'];?></label><br>
                            <input type="hidden" name="<?php echo $row['Libelle'];?>" value="<?php echo $row['IdSubstance'];?>">
                            <input type="number" step="0.01" name="<?php echo $row['IdSubstance'];?>" placeholder="Emission / h">
                            </p>
                            <?php
                                }
                            }else{
                            ?>
                                    <input type="hidden" name="Eaux-grises" value="0">
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
