<?php
	include '../commonpart/sqlconnect.php';

	if(isset($_POST['supprimerMaison'])){
		$id = $_POST['supprimerMaison']; //idAppart
		
		//recup id Maison
		$response = $bdd->prepare("SELECT IdMaison FROM `Appart` WHERE `IdAppart`=:id");
		$response->execute(array('id'=>$id));
		while ($row = $response->fetch()){
      		$idMaison = $row['IdMaison'];
    	}

    	//cherche dans louer et propriétaire
    	//pour mettre finPossession/finLocationLocation
    	$response = $bdd->prepare("UPDATE Louer SET FinLocation=:finLoc WHERE `IdAppart`=:id AND `Id_Personne`=:idPers");
		$response->execute(array('finLoc'=> date("Y-m-d"),'id'=>$id,'idPers'=>$_SESSION['user_id']));
		
		$response = $bdd->prepare("UPDATE Propriétaire SET FinPossession=:finPos WHERE `IdMaison`=:id AND `Id_Personne`=:idPers");
		$response->execute(array('finPos'=> date("Y-m-d"),'id'=>$idMaison,'idPers'=>$_SESSION['user_id']));


		//suppression appart
		$response = $bdd->prepare("DELETE FROM `Appart` WHERE `IdAppart`=:id");
    	$response->execute(array('id'=>$id));



		//verification autre appart dans la maison
		$nbAppt = 0;
		$response = $bdd->prepare("SELECT * FROM `Appart` WHERE `IdMaison`=:id");
		$response->execute(array('id'=>$idMaison));
		while ($row = $response->fetch()){
      		$nbAppt=1;
    	}

    	//si pas d'autre appart
    	if($nbAppt==0){
    		//suppression maison
    		$response = $bdd->prepare("DELETE FROM `Maison` WHERE `IdMaison`=:id");
    		$response->execute(array('id'=>$idMaison));
    	}
    	header('Location: ../pages/tableauDeBord.php');
	}
?>