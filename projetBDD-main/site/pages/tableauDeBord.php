<?php include '../commonpart/sqlconnect.php'; ?>
<!DOCTYPE html>
<html lang="fr" dir="ltr">
<?php 
    if($_SESSION['user_id']){
        $sess=$_SESSION['user_id'];
?>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="/site/css/tableauDeBord.css" />
        <link rel="stylesheet" href="/site/css/navbar.css" />
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
        <link rel="icon" type="image/png" href="img/favicon.png" />
        <title></title>
    </head>
    <body>
        <?php include "../navbar.php"; ?>
        <h1>Tableau de Bord</h1>
        <div class="tout">
            <?php 
            //affichage maison possédée
            $todayDate = date("Y/m/d");
            $response = $bdd->prepare("SELECT a.IdAppart, a.Libelle AS 'LibelleAppart', t.Libelle, m.NumeroMaison, m.NomRue, v.NomVille, v.CP FROM appart a, typeappart t, maison m, ville v, propriétaire p WHERE a.IdTypeAppart=t.IdTypeAppart AND a.IdMaison = m.IdMaison AND v.IdVille=m.IdVille AND m.IdMaison=p.IdMaison AND p.Id_Personne=$sess AND p.FinPossession is NULL ");
            $response->execute();
            while ($row = $response->fetch()) {
            ?>
                <div class="maison">
                    <h2><?php echo $row['LibelleAppart'];?></h2>
                    <p>Appartement de type <?php echo $row['Libelle'];?></p>
                    <p><?php echo $row['NumeroMaison'];?> <?php echo $row['NomRue'];?> </p>
                    <p><?php echo $row['CP'];?> <?php echo $row['NomVille'];?> </p>
                    <br>
                    <div class="boutons">
                        <div class="bouton">
                            <form action='modifierMaison.php' method='post'>
                                <button onclick="window.location.href = 'modifierMaison.php';" type="submit" name="modif" value="<?php echo $row['IdAppart'];?>"><img src="../img/modifier.png"></button>
                            </form>
                        </div>
                        <div class="boutonVoir">
                            <form action='appart.php' method='post'>
                                <button class="voir" type="submit" name="voirAppart" value="<?php echo $row['IdAppart'];?>">Voir l'appartement</button>
                            </form>
                        </div>
                        <div class="bouton">
                            <form action='../api/supprimerMaisonapi.php' method='post'>
                                <button type="submit" name="supprimerMaison" value="<?php echo $row['IdAppart'];?>"><img src="../img/supprimer.png"></button>
                            </form>
                        </div>
                    </div>
                    <br>
                    
                    <p>Propriétaire</p>
                    
                </div>
            <?php
                }  
            ?>

            <?php 
            //affichage maison louée
            $response = $bdd->prepare("SELECT l.FinLocation, a.IdAppart, a.Libelle AS 'LibelleAppart', t.Libelle, m.NumeroMaison, m.NomRue, v.NomVille, v.CP FROM appart a, typeappart t, maison m, ville v, louer l WHERE a.IdTypeAppart=t.IdTypeAppart AND a.IdMaison = m.IdMaison AND v.IdVille=m.IdVille AND l.IdAppart=a.IdAppart AND l.Id_Personne=$sess AND l.FinLocation is NULL");
            
            $response->execute();
            while ($row = $response->fetch()) {
            ?>
                <div class="maison">
                    <h2><?php echo $row['LibelleAppart'];?></h2>
                    <p>Appartement de type <?php echo $row['Libelle'];?></p>
                    <p><?php echo $row['NumeroMaison'];?> <?php echo $row['NomRue'];?> </p>
                    <p><?php echo $row['CP'];?> <?php echo $row['NomVille'];?> </p>
                    <br>
                    <div class="boutons">
                        <div class="bouton">
                            <form action='modifierMaison.php' method='post'>
                                <button onclick="window.location.href = 'modifierMaison.php';" type="submit" name="modif" value="<?php echo $row['IdAppart'];?>"><img src="../img/modifier.png"></button>
                            </form>
                        </div>
                        <div class="boutonVoir">
                            <form action='appart.php' method='post'>
                                <button class="voir" type="submit" name="voirAppart" value="<?php echo $row['IdAppart'];?>">Voir l'appartement</button>
                            </form>
                        </div>
                        <div class="bouton">
                            <form action='../api/supprimerMaisonapi.php' method='post'>
                                <button type="submit" name="supprimerMaison" value="<?php echo $row['IdAppart'];?>"><img src="../img/supprimer.png"></button>
                            </form>
                        </div>
                        
                    </div>
                    <br>
                    <p>Locataire</p>
                    
                </div>
            <?php
                }  
            ?>

        <div class="maison">
            <button class="ajout" onclick="window.location.href = 'ajouterMaison.php';" ><img src="../img/ajouter.png"></button>
        </div>
        </div>
        <br><br>
        
    </body>

    <?php 
    }else{
        header('Location: ../pages/inscription.php');
    }
?>
</html>