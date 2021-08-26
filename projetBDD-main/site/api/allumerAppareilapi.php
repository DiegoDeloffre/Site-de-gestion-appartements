<?php
include '../commonpart/sqlconnect.php';

    $etat = $_POST['etat'];
    $id = $_POST['voirAppart'];

    if($etat==1){
        //appareil allumé à éteindre
        $eteindre = $_POST['eteindre']; //idAppareil
        if(empty($eteindre)){
            echo '<script type="text/javascript">';
            echo 'window.location.href = "../pages/appareil.php?error=emptyfields";';
            echo '</script>';
            exit();
        }
        $response = $bdd->prepare("UPDATE Allumer SET `FinAllumage`=:allumage WHERE FinAllumage is NULL AND IdAppareil=:id");
        $response->execute(array('allumage'=>date("Y-m-d H:i:s"),'id'=>$eteindre));

        


    }else{
        //appareil éteint à allumer
        $allumer = $_POST['allumer'];
        //creztion entrée journal
        $response = $bdd->prepare("INSERT INTO journal_allumage (IdJournal) VALUES(NULL)");
        $response->execute();

        $response = $bdd->prepare("SELECT IdJournal, MAX(IdJournal) FROM journal_allumage");
        $response->execute();
        while ($row = $response->fetch()) {
            $idJ=$row['IdJournal'];
        }

        $response = $bdd->prepare("INSERT INTO Allumer (IdAppareil, DebutAllumage, FinAllumage, IdJournal) VALUES(:idA, :debut, NULL, :idJ)");
        $response->execute(array('idA'=>$allumer,'debut'=>date("Y-m-d H:i:s"), 'idJ'=>$idJ));

    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
        <link rel="stylesheet" href="/site/css/boutonapi.css" />
<link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
        <link rel="icon" type="image/png" href="img/favicon.png" />
</head>
<body>
    <form action="../pages/appart.php" method="POST">
        <input type="hidden" name="voirAppart" value="<?php echo $id;?>">
        <div class="boutonVoir">
        <button class="voir" type="submit" name="confirmer">Confirmer</button>
        </div> 
    </form>

</body>
</html>
