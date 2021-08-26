<?php
include '../commonpart/sqlconnect.php';

    $nomMaison = $_POST['nomMaison'];
    $numeroMaison = $_POST['numeroMaison'];
    $rue = $_POST['rue'];
    $ville = $_POST['ville'];
    $codePostal = $_POST['codePostal'];
    $departement = $_POST['departement'];
    $region = $_POST['region'];
    $degreIso = $_POST['degreIso'];
    $evalEco = $_POST['evalEco'];
    $proprietaire=$_POST['proprietaire'];
    $date=$_POST['achat'];
    $prop=$_POST['prop']; //si 1 le mec vit dans sa maison et si 0 le mec loue à qqun d'autre

    $typeappart = $_POST['typeappart'];
    $secu = $_POST['secu'];
    $nomAppt = $_POST['nomAppt'];

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
    
//verification existence maison IdMaison
    $existMaison=0;
    $response = $bdd->prepare("SELECT `IdMaison` FROM `Maison` WHERE `NumeroMaison`=:numero AND `nomRue`=:rue AND `DegreIsolation`=:DegreIsolation AND `EvalEco`=:EvalEco AND `NomMaison`=:NomMaison AND `IdVille`=:ville");
    $response->execute(array('numero'=>$numeroMaison, 
                              'rue'=>$rue,
                              'DegreIsolation'=>$degreIso,
                              'EvalEco'=>$evalEco,
                              'NomMaison'=>$nomMaison,
                              'ville'=>$ville));
    while ($row = $response->fetch()){
      $existMaison=1;
    }

// si existe pas
    if($existMaison!=1){
      //creationMaison
      $response = $bdd->prepare("INSERT INTO `Maison` (`IdMaison`, `NumeroMaison`, `NomRue`, `DegreIsolation`,`EvalEco`,`NomMaison`,`IdVille`) VALUES (NULL, :numero, :nomRue, :DegreIsolation, :EvalEco, :NomMaison, :IdVille)");
      $response->execute(array('numero'=>$numeroMaison, 
                                'nomRue'=>$rue,
                                'DegreIsolation'=>$degreIso,
                                'EvalEco'=>$evalEco,
                                'NomMaison'=>$nomMaison,
                                'IdVille'=>$ville));

      
    }

//recup IdMaison
    $existMaison=0;
    $response = $bdd->prepare("SELECT `IdMaison` FROM `Maison` WHERE `NumeroMaison`=:numero AND `nomRue`=:rue AND `DegreIsolation`=:DegreIsolation AND `EvalEco`=:EvalEco AND `NomMaison`=:NomMaison AND `IdVille`=:ville");
    $response->execute(array('numero'=>$numeroMaison, 
                              'rue'=>$rue,
                              'DegreIsolation'=>$degreIso,
                              'EvalEco'=>$evalEco,
                              'NomMaison'=>$nomMaison,
                              'ville'=>$ville));
    while ($row = $response->fetch()){
      $maison = $row['IdMaison'];
    }


//verification existence Appart
    $existAppart=0;
$response = $bdd->prepare("SELECT a.IdAppart FROM appart a WHERE a.IdMaison=:maison AND a.libelle=:nomAppart");
    $response->execute(array('maison'=>$maison,'nomAppart'=>$nomAppt));
  while ($row = $response->fetch()){
      $existAppart = 1;
    }

//si existe pas
    if($existAppart!=1){
    //creation appart
    $response = $bdd->prepare("INSERT INTO `Appart` (`IdAppart`, `Libelle`, `IdSecu`, `IdTypeAppart`,`IdMaison`) VALUES (NULL, :libelle, :IdSecu, :IdTypeAppart, :IdMaison)");
    $response->execute(array('libelle'=>$nomAppt, 
                              'IdSecu'=>$secu,
                              'IdTypeAppart'=>$typeappart,
                              'IdMaison'=>$maison));
    }

    //recup Id Appart
    $response = $bdd->prepare("SELECT a.IdAppart FROM appart a WHERE a.IdMaison=:maison AND a.libelle=:nomAppart");
    $response->execute(array('maison'=>$maison,'nomAppart'=>$nomAppt));
    while ($row = $response->fetch()){
      $appart = $row['IdAppart'];
    }

    
    //recup des idPiece en fonction du type Appart
    $response = $bdd->prepare("SELECT p.IdPiece FROM Piece p, TypePiece t, ContenirTypePiece c WHERE p.IdTypePiece=t.IdTypePiece AND c.IdTypePiece=t.IdTypePiece AND c.IdTypeAppart=:typeappart");
    $response->execute(array('typeappart'=>$typeappart));
    while ($row = $response->fetch()){
      //insertion dans contenir Piece des pieces correspondantes à l'appart
      //en fonction de son type
      $req = $bdd->prepare("INSERT INTO `ContenirPiece` (`IdAppart`,`IdPiece`) VALUES(:idappt, :idpiece)");
      $idpi=$row['IdPiece'];
      $req->execute(array('idappt'=>$appart,'idpiece'=>$idpi));
    }


//recup Id Appart
$response = $bdd->prepare("SELECT a.IdAppart FROM appart a WHERE a.IdMaison=:maison AND a.libelle=:nomAppart");
    $response->execute(array('maison'=>$maison,'nomAppart'=>$nomAppt));
  while ($row = $response->fetch()){
      $appart = $row['IdAppart'];
    }


$existDate = 0;
//si la personne est proprietaire   
    if($proprietaire==1){
      //verif existence Date
      $response = $bdd->prepare("SELECT DebutPossession FROM DateProprio WHERE DebutPossession=:dateAchat");
      $response->execute(array('dateAchat'=>$date));
      while ($row = $response->fetch()){
        $existDate = 1;
      }
      if($existDate!=1){
        //creation DateAchat
        $response = $bdd->prepare("INSERT INTO `DateProprio` (`DebutPossession`) VALUES (:dateAchat)");
        $response->execute(array('dateAchat'=>$date));
      }

      //si personne et date similaire pb

      //creation Possession
      $response = $bdd->prepare("INSERT INTO `Propriétaire` (`Id_Personne`,`DebutPossession`,`IdMaison`) VALUES (:IdPersonne,:DebutPossession,:IdMaison)");
      $response->execute(array('IdPersonne'=>$_SESSION['user_id'], 
                              'DebutPossession'=>$date,
                              'IdMaison'=>$maison));

      //si le mec vit dans sa maison
      if($prop == 1){
        $response = $bdd->prepare("INSERT INTO `Louer` (`Id_Personne`,`DebutLocation`,`IdAppart`) VALUES (:IdPersonne,:DebutLocation,:IdAppart)");
        $response->execute(array('IdPersonne'=>$_SESSION['user_id'], 
                              'DebutLocation'=>$date,
                              'IdAppart'=>$appart));
      }

    }else{ //la personne est locataire
      //verif existence dateLoc
      $response = $bdd->prepare("SELECT DebutLocation FROM DateLocation WHERE DebutLocation=:dateLoc");
      $response->execute(array('dateLoc'=>$date));
      while ($row = $response->fetch()){
        $existDate = 1;
      }

      //si la date n'existe pas
      if($existDate!=1){
        //creation dateLoc
        $response = $bdd->prepare("INSERT INTO `DateLocation` (`DebutLocation`) VALUES (:dateLoc)");
        $response->execute(array('dateLoc'=>$date));
      }
      //creation Location
      $response = $bdd->prepare("INSERT INTO `Louer` (`Id_Personne`,`DebutLocation`,`IdAppart`) VALUES (:IdPersonne,:DebutLocation,:IdAppart)");
      $response->execute(array('IdPersonne'=>$_SESSION['user_id'], 
                              'DebutLocation'=>$date,
                              'IdAppart'=>$appart));
  }
  header('Location: ../pages/tableauDeBord.php');

?>
