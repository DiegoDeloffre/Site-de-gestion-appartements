
<?php
include '../commonpart/sqlconnect.php';
/*if (isset($_SESSION['user_id'])) {
  header('Location: ../index.php');
}
else {*/
  //if (isset($_POST['nomMaison'])) {
    $idAppart = $_POST['idAppart'];
    $nomMaison = $_POST['nomMaison'];
    $numeroMaison = $_POST['numeroMaison'];
    $rue = $_POST['rue'];
    $ville = $_POST['ville'];
    $codePostal = $_POST['codePostal'];
    $departement = $_POST['departement'];
    $region = $_POST['region'];
    $degreIso = $_POST['degreIso'];
    $evalEco = $_POST['evalEco'];

    $typeappart = $_POST['typeappart'];
    $secu = $_POST['secu'];
    $nomAppt = $_POST['nomAppt'];

    //verif champs vides
    if(empty($nomMaison) || empty($numeroMaison) || empty($rue) || empty($ville) 
      || empty($codePostal) || empty($departement) || empty($region) || empty($degreIso) 
      || empty($evalEco) || empty($proprietaire) || empty($date) || empty($typeappart) 
      || empty($secu) || empty($nomAppt)){
      echo '<script type="text/javascript">';
      echo 'window.location.href = "../pages/tableauDeBord.php?error=emptyfields";';
      echo '</script>';
      exit();
    }
    


    //recuperation IdRegion
    $response = $bdd->prepare("SELECT `IdRegion` FROM `Region` WHERE `NomRegion`=:region");
    $response->execute(array('region'=>$region));
    while ($row = $response->fetch()){
      $region = $row['IdRegion'];
    }

    //recuperation NumDep
    $response = $bdd->prepare("SELECT `NumeroDepartement` FROM `Departement` WHERE `NomDepartement`=:departement");
    $response->execute(array('departement'=>$departement));
    while ($row = $response->fetch()){
      $departement = $row['NumeroDepartement'];
    }


//si existe pas
    $existVille = 0;
    $response = $bdd->prepare("SELECT `IdVille` FROM `Ville` WHERE `NomVille`=:ville AND `CP`=:cp AND `NumeroDepartement`=:numDep");
    $response->execute(array('ville'=>$ville,'cp'=>$codePostal,'numDep'=>$departement));
    while ($row = $response->fetch()){
      $existVille = 1;
      $ville = $row['IdVille'];
    }

    if($existVille != 1){
      //creationVille
      $response = $bdd->prepare("INSERT INTO `Ville` (`IdVille`, `NomVille`, `CP`, `NumeroDepartement`) VALUES (NULL, :ville, :codePostal, :departement)");
      $response->execute(array('ville'=>$ville, 
                                'codePostal'=>$codePostal,
                                'departement'=>$departement));

      //recup IdVille
      $response = $bdd->prepare("SELECT `IdVille` FROM `Ville` WHERE `NomVille`=:ville AND `CP`=:cp AND `NumeroDepartement`=:numDep");
      $response->execute(array('ville'=>$ville,'cp'=>$codePostal,'numDep'=>$departement));
      while ($row = $response->fetch()){
        $ville = $row['IdVille'];
      }
    }
    
//recup IdMaison
    //$maison=1;
    $response = $bdd->prepare("SELECT `IdMaison` FROM `Appart` WHERE `IdAppart`=:id ");
    $response->execute(array('id'=>$idAppart));
    while ($row = $response->fetch()){
      $maison = $row['IdMaison'];
    }


//modif Maison
    $response = $bdd->prepare("UPDATE `Maison` SET `NumeroMaison`=:numero, `nomRue`=:rue, `DegreIsolation`=:DegreIsolation, `EvalEco`=:EvalEco, `NomMaison`=:NomMaison, `IdVille`=:ville WHERE `IdMaison`=:maison");
      $response->execute(array('numero'=>$numeroMaison, 
                                'rue'=>$rue,
                                'DegreIsolation'=>$degreIso,
                                'EvalEco'=>$evalEco,
                                'NomMaison'=>$nomMaison,
                                'ville'=>$ville,
                                'maison'=>$maison));




//modif appart
    $response = $bdd->prepare("UPDATE `Appart` SET `Libelle`=:libelle, `IdSecu`=:IdSecu, `IdTypeAppart`=:IdTypeAppart,`IdMaison`=:IdMaison WHERE `IdAppart`=:id");
    $response->execute(array('libelle'=>$nomAppt, 
                              'IdSecu'=>$secu,
                              'IdTypeAppart'=>$typeappart,
                              'IdMaison'=>$maison,
                              'id'=>$idAppart));

header('Location: ../pages/tableauDeBord.php');
 /* if (isset($_SESSION['user_id'])) {
    header('Location: ../index.php');
  }
  else {
    header('Location: ../pages/inscription.php');
  }
}*/
?>

