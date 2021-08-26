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
        <link rel="stylesheet" href="../css/ajouterMaison.css" />
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
                    <form class="login-form" action="/site/api/ajouterMaisonapi.php" method="post">
                        <p>Ajouter une maison</p>
                        <div class="row">
                            <p>
                            <label for="proprietaire">Vous etes :</label>
                              <select id="proprietaire" name="proprietaire">
                                <option value="1">Propriétaire</option>
                                <option value="2">Locataire</option>
                              </select>
                              
                           </p>

                           <p>
                            <label for="prop">Habitez vous dans votre appartement ?</label><br>
                                <input type="radio" id="oui" name="prop" value="1">
                                <label for="non">Oui</label>
                                <input type="radio" id="non" name="prop" value="0">
                                <label for="non">Non</label>
                               
                           </p> 

                              <p>
                                <label for="achat">Date d'achat / location</label>
                                <input type="date" name="achat" id="achat" placeholder="Achat / Location">
                            </p>
                        </div>
                        <div class="row">


                          <div class="block">
                            <p>
                                <input type="text" name="nomMaison" id="nomMaison" placeholder="Nom maison">
                            </p>
                            <p>
                                <input type="number" name="numeroMaison" id="numeroMaison" placeholder="Numero">
                            </p>
                            <p>
                                <input type="text" name="rue" id="rue" placeholder="Rue">
                            </p>
                            <p>
                                <input type="text" name="ville" id="ville" placeholder="Ville">
                            </p>
                            
                          </div>
                          <div class="block spacer">
                            <p>
                                <input type="number" name="codePostal" id="codePostal" placeholder="codePostal">
                            </p>
                            <p>
                              <label for="departement">Departement :</label>
                              <select id="departement" name="departement">
                                <?php 
                                    $response = $bdd->prepare("SELECT * FROM `Departement` ORDER BY `NomDepartement` ASC");
                                    $response->execute();
                                    while ($row = $response->fetch()) {
                                ?>
                                    <option value="<?php echo $row['NumeroDepartement'];?>"><?php echo $row['NomDepartement'];?></option>
                                <?php
                                    }  
                                ?>
                              </select>
                            </p>
                            <p>
                              <label for="region">Région :</label>
                              <select id="region" name="region"> 
                                <?php 
                                    $response = $bdd->prepare("SELECT * FROM `Region` ORDER BY `NomRegion` ASC");
                                    $response->execute();
                                    while ($row = $response->fetch()) {
                                ?>
                                    <option value="<?php echo $row['IdRegion'];?>"><?php echo $row['NomRegion'];?></option>
                                <?php
                                    }  
                                ?>
                              </select>
                            </p>
                            <p>
                                <input type="text" class="nomprenom" name="degreIso" id="degreIso" placeholder="DegreIsolation">
                                <input type="text" class="nomprenom" name="evalEco" id="evalEco" placeholder="EvalEco">
                            </p>
                          </div>
                        </div>

                        <br>
                        <p>Appartement</p>

                        <div class="row">
                            <p>
                                <input type="text" name="nomAppt" id="nomAppt" placeholder="Nom Appartement">
                            </p>
                            <div class="block">
                                <p>
                              <label for="typeappart">Type :</label>
                              <select id="typeappart" name="typeappart"> 

                                <?php 
                                    $response = $bdd->prepare("SELECT * FROM `TypeAppart`");
                                    $response->execute();
                                    while ($row = $response->fetch()) {
                                ?>
                                    <option value="<?php echo $row['IdTypeAppart'];?>"><?php echo $row['Libelle'];?></option>
                                <?php
                                    }  
                                ?>
                              </select>
                            </p>
                                
                            </div>
                            <div class="block spacer">
                                <p>
                                  <label for="secu">Securité :</label>
                                  <select id="secu" name="secu">
                                    <?php 
                                    $response = $bdd->prepare("SELECT * FROM `Securite`");
                                    $response->execute();
                                    while ($row = $response->fetch()) {
                                ?>
                                    <option value="<?php echo $row['IdSecu'];?>"><?php echo $row['Libelle'];?></option>
                                <?php
                                    }  
                                ?>
                                  </select>
                                </p>
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
