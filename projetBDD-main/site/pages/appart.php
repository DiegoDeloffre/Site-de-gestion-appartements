<?php include '../commonpart/sqlconnect.php'; ?>
<!DOCTYPE html>
<html lang="fr" dir="ltr">
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="/site/css/appart.css" />
        <link rel="stylesheet" href="/site/css/navbar.css" />
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
        <link rel="icon" type="image/png" href="img/favicon.png" />
        <title></title>
    </head>
    <body>
        <?php include "../navbar.php"; 
            $id = $_POST['voirAppart'];
            $response = $bdd->prepare("SELECT a.Libelle AS 'LibelleAppart', t.Libelle, m.NumeroMaison, m.NomRue,m.DegreIsolation, m.EvalEco, v.NomVille, v.CP FROM appart a, typeappart t, maison m, ville v WHERE a.IdTypeAppart=t.IdTypeAppart AND a.IdMaison = m.IdMaison AND v.IdVille=m.IdVille AND a.IdAppart=$id");
            $response->execute();
            while ($row = $response->fetch()) {

        ?>

        <div class="container-fluid">
            <div class="container">
                    <div class="row">
                        <h2><?php echo $row['LibelleAppart'];?></h2>
                        <p>Appartement de type <?php echo $row['Libelle'];?></p>
                        <p><?php echo $row['NumeroMaison'];?> <?php echo $row['NomRue'];?> </p>
                        <p><?php echo $row['CP'];?> <?php echo $row['NomVille'];?> </p>
                        <p>Evaluation Ecologique : <?php echo $row['EvalEco'];?> </p>
                        <p>Degré d'isolation : <?php echo $row['DegreIsolation'];?> </p>
                    </div>
            </div>
        </div>
        
    <?php } ?>


        <h1>Appareils</h1>

        <div class="tout">
            <?php 
            //appareils passer id appart en cliquant
            $todayDate = date("Y/m/d");
            $response = $bdd->prepare("SELECT a.IdAppart, ap.IdAppareil ,ap.Libelle AS 'LibelleAppareil', ap.DescriptionLieu, t.Libelle FROM appart a, appareil ap, contenirAppareil c, typeappareil t WHERE a.IdAppart=c.IdAppart AND ap.IdAppareil = c.IdAppareil AND t.IdTypeAppareil=ap.IdTypeAppareil AND c.IdAppart=$id");

            $response->execute();
            while ($row = $response->fetch()) {
                $idAp=$row['IdAppareil'];
            ?>
                <div class="maison">
                    <h2><?php echo $row['LibelleAppareil'];?></h2>
                    <p>Appareil de type <?php echo $row['Libelle'];?></p>
                    <p><?php echo $row['DescriptionLieu'];?> </p>
                    
                    <div class="boutons">
                        <div class="bouton">
                            <form action='../api/supprimerAppareilapi.php' method='post'>
                                <input type="hidden" name="voirAppart" value="<?php echo $id;?>">
                                <button type="submit" name="supprimerAppareil" value="<?php echo $row['IdAppareil'];?>">Supprimer</button>
                            </form>
                        </div>
                    </div>
                    <br>
                    <div class="boutons">
                        <?php 
                            $res = $bdd->prepare("SELECT IdJournal ,MAX(IdJournal) FROM Allumer WHERE IdAppareil=:id");
                            $res->execute(array('id'=>$idAp));
                            while ($row = $res->fetch()) {
                                $idJ=$row['IdJournal'];
                            }

                            $FinAllu=0;
                            $req = $bdd->prepare("SELECT a.FinAllumage FROM Allumer a WHERE IdAppareil=:idA AND a.IdJournal=:idJ");

                            $req->execute(array('idA'=>$idAp,
                                                'idJ'=>$idJ));
                            while ($row = $req->fetch()) {
                                $FinAllu=$row['FinAllumage'];
                            }

                            if(is_null($FinAllu)){
                                //bouton eteindre
                        ?>
                            <div class="boutonEtat">
                                <form action='../api/allumerAppareilapi.php' method='post'>
                                    <input type="hidden" name="etat" value="1">
                                    <input type="hidden" name="voirAppart" value="<?php echo $id;?>">
                                    <button class="etat" type="submit" name="eteindre" value="<?php echo $idAp;?>">Eteindre</button>
                                </form>
                            </div>
                        <?php
                            }else{
                                //bouton allumer
                        ?>
                            <div class="boutonEtat">
                                <form action='../api/allumerAppareilapi.php' method='post'>
                                    <input type="hidden" name="etat" value="2">
                                    <input type="hidden" name="voirAppart" value="<?php echo $id;?>">
                                    <button class="etat" type="submit" name="allumer" value="<?php echo $idAp;?>">Allumer</button>
                                </form>
                            </div>
                        <?php
                            }
                        ?>
                        
                        
                    </div>
                    
                </div>
            <?php
                }  
            ?>
            <div class="maison">
                <form action='ajouterAppareil.php' method='post'>
                    <input type="hidden" name="idAppt" value="<?php echo $id;?>">
                    <button class="ajout" type="submit" name="IdAppart" value="<?php echo $id;?>"><img src="../img/ajouter.png"></button>
                </form>
            </div>
        </div>
        <br>
    </body>
</html>