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
                    <form class="login-form" action="/site/api/modifierMaisonapi.php" method="post">
                        <?php 
                            $idAppart = $_POST['modif'];
                            $response = $bdd->prepare("SELECT a.IdAppart, a.Libelle AS 'LibelleAppart',a.IdSecu, t.Libelle, m.NumeroMaison, m.NomRue, v.NomVille, v.CP, m.NomMaison, v.NumeroDepartement ,m.DegreIsolation, m.EvalEco FROM appart a, typeappart t, maison m, ville v WHERE a.IdTypeAppart=t.IdTypeAppart AND a.IdMaison = m.IdMaison AND v.IdVille=m.IdVille AND a.IdAppart=:idAppart");
                            $response->execute(array('idAppart'=>$idAppart));
                            while ($row = $response->fetch()) {
                                $dep = $row['NumeroDepartement'];
                                $typeAppart = $row['Libelle'];
                                $idsecurite = $row['IdSecu'];
                                $NomAppart = $row['LibelleAppart'];
                                $iso = $row['DegreIsolation'];
                                $eco = $row['EvalEco'];


                        ?>
                        <p>Modifier une maison</p>
                        <input type="hidden" name="idAppart" id="idAppart" value="<?php echo $idAppart;?>">
                        <div class="row">
                          <div class="block">
                            <p>
                                <input type="text" name="nomMaison" id="nomMaison" value="<?php echo $row['NomMaison'];?>">
                            </p>
                            <p>
                                <input type="number" name="numeroMaison" id="numeroMaison" value="<?php echo $row['NumeroMaison'];?>">
                            </p>
                            <p>
                                <input type="text" name="rue" id="rue" value="<?php echo $row['NomRue'];?>">
                            </p>
                            <p>
                                <input type="text" name="ville" id="ville" value="<?php echo $row['NomVille'];?>">
                            </p>
                            
                          </div>
                          <div class="block spacer">
                            <p>

                                <input type="number" name="codePostal" id="codePostal" value="<?php echo $row['CP'];?>">
                            </p>
                            <p>
                              <label for="departement">Departement :</label>
                              <select id="departement" name="departement">
                                <?php 
                                    $response = $bdd->prepare("SELECT * FROM `Departement`");
                                    $response->execute();
                                    while ($row = $response->fetch()) {
                                        if($dep == $row['NumeroDepartement']){
                                ?>
                                <option value="<?php echo $row['NumeroDepartement'];?> " selected><?php echo $row['NomDepartement'];?></option>
                                <?php
                                        }else{
                                ?>
                                    <option value="<?php echo $row['NumeroDepartement'];?>"><?php echo $row['NomDepartement'];?></option>
                                <?php
                                        }
                                    }  
                                ?>
                              </select>
                            </p>
                            <p>

                              <label for="region">Région :</label>
                              <select id="region" name="region"> 
                                <?php 
                                //recup IdRegion
                                    $response = $bdd->prepare("SELECT IdRegion FROM `Departement` WHERE `NumeroDepartement`=:id");
                                    $response->execute(array('id'=>$dep));
                                    while ($row = $response->fetch()) {
                                        $idReg = $row['IdRegion'];
                                    }


                                //affiche toutes les régions
                                    $response = $bdd->prepare("SELECT * FROM `Region`");
                                    $response->execute();
                                    while ($row = $response->fetch()) {
                                        if($idReg == $row['IdRegion']){
                                ?>
                                    <option value="<?php echo $row['IdRegion'];?>" selected><?php echo $row['NomRegion'];?></option>
                                <?php
                                        }else{
                                ?>
                                    <option value="<?php echo $row['IdRegion'];?>"><?php echo $row['NomRegion'];?></option>
                                <?php
                                        }
                                    }  
                                ?>
                              </select>
                            </p>
                            <p>
                                <input type="text" class="nomprenom" name="degreIso" id="degreIso" value="<?php echo $iso;?>">
                                <input type="text" class="nomprenom" name="evalEco" id="evalEco" value="<?php echo $eco;?>">
                            </p>
                          </div>
                        </div>

                        <br>
                        <p>Appartement</p>

                        <div class="row">
                            <p> 
                                <input type="text" name="nomAppt" id="nomAppt" value="<?php echo $NomAppart;?>">
                            </p>
                            <div class="block">
                                <p>
                              <label for="typeappart">Type :</label>
                              <select id="typeappart" name="typeappart"> 

                                <?php 
                                    $response = $bdd->prepare("SELECT * FROM `TypeAppart`");
                                    $response->execute();
                                    while ($row = $response->fetch()) {
                                        if($typeAppart == $row['Libelle']){
                                ?>
                                    <option value="<?php echo $row['IdTypeAppart'];?>" selected><?php echo $row['Libelle'];?></option>
                                <?php
                                        }else{
                                ?>
                                    <option value="<?php echo $row['IdTypeAppart'];?>"><?php echo $row['Libelle'];?></option>
                                <?php
                                        }
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
                                        if($idsecurite == $row['IdSecu']){
                                ?>
                                    <option value="<?php echo $row['IdSecu'];?>" selected><?php echo $row['Libelle'];?></option>
                                <?php
                                        }else{
                                ?>
                                    <option value="<?php echo $row['IdSecu'];?>"><?php echo $row['Libelle'];?></option>
                                <?php
                                        }
                                    }  
                                ?>

                                  </select>
                                </p>
                            </div>

                        <?php } ?>
                            
                          
                        </div>
                        <p class="submit-button"><input class="submit-button" type="submit" name="submit"></p>
                        
                    </form>
                </div>
            </div>
          </div>
    </body>
</html>
<?php } ?>
