<?php
include '../commonpart/sqlconnect.php';
    $nomAppareil = $_POST['libelle'];
    $descAppareil = $_POST['description'];
    $typeAppareil = $_POST['typeappareil'];
    $pieceAppareil = $_POST['piece'];
    $descLocAppareil = $_POST['descLieu'];
    $id = $_POST['idAppt'];
    if(empty($nomAppareil) || empty($descAppareil) || empty($typeAppareil) || empty($pieceAppareil) 
      || empty($descLocAppareil)){
      echo '<script type="text/javascript">';
      echo 'window.location.href = "../pages/appart.php?error=emptyfields";';
      echo '</script>';
      exit();
    }
    


    //ajouter Appareil
    $response = $bdd->prepare("INSERT INTO `Appareil` (`IdAppareil`, `DescriptionLieu`, `Libelle`, `Description`,`IdPiece`,`IdTypeAppareil`) VALUES (NULL, :descriptionLieu, :libelle, :description,:idpiece, :idtype)");
    $response->execute(array('descriptionLieu'=>$descLocAppareil, 
                                'libelle'=>$nomAppareil,
                                'description'=>$descAppareil,
                                'idpiece'=>$pieceAppareil,
                                'idtype'=>$typeAppareil));


    //recup IdAppareil
    $response = $bdd->prepare("SELECT `IdAppareil` FROM `Appareil` WHERE `DescriptionLieu`=:DescriptionLieu AND `Libelle`=:Libelle AND `Description`=:Description AND `IdPiece`=:idpiece AND `IdTypeAppareil`=:idtype");
    $response->execute(array('DescriptionLieu'=>$descLocAppareil,'Libelle'=>$nomAppareil,'Description'=>$descAppareil,'idpiece'=>$pieceAppareil,'idtype'=>$typeAppareil));
      while ($row = $response->fetch()){
        $idApp = $row['IdAppareil'];
      }

    //ajout appareil a l'appart
       $response = $bdd->prepare("INSERT INTO `contenirappareil` (`IdAppart`, `IdAppareil`) VALUES (:idappt, :idappa)");
    $response->execute(array('idappt'=>$id,'idappa'=>$idApp));



    //ajouter Emissions substances
    $response = $bdd->prepare("SELECT * FROM Substances");
    $response->execute();
    while ($row = $response->fetch()) {
        if ($_POST[$row['Libelle']]!=0) {
            $idSub = $_POST[$row['Libelle']]; // renvoie l'id de la ressource
            $emiSub = $_POST[$row['IdSubstance']]; //renvoie les émissions / h
            $req = $bdd->prepare("INSERT INTO Emettre (IdAppareil, IdSubstance, EmissionParHeure) VALUES (:IdAppareil, :IdSubstance, :EmissionParHeure)");
            $req->execute(array('IdAppareil'=>$idApp,'IdSubstance'=>$idSub,'EmissionParHeure'=>$emiSub));
        }
    }

    //ajouter Conso Ressources
    $response = $bdd->prepare("SELECT * FROM Ressources");
    $response->execute();
    while ($row = $response->fetch()) {
        if ($_POST[$row['Libelle']]!=0) {
            $idRes = $_POST[$row['Libelle']]; //renvoie l'id de la ressource
            $consoRes = $_POST[$row['IdRessource']];//renvoie la conso
            $req = $bdd->prepare("INSERT INTO Consommer (IdAppareil, IdRessource, ConsoParHeure) VALUES (:IdAppareil, :IdRessource, :ConsoParHeure)");
            $req->execute(array('IdAppareil'=>$idApp,'IdRessource'=>$idRes,'ConsoParHeure'=>$consoRes));
        }
    }

    header('Location: ../pages/tableauDeBord.php');

?>