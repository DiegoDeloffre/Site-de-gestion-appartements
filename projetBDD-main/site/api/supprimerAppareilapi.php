<?php
	include '../commonpart/sqlconnect.php';

	$idAppart = $_POST['voirAppart'];
	//if(isset($_POST['supprimerAppareil'])){
		$id = $_POST['supprimerAppareil']; //idAppareil
		
		//supprimer dans consommer
		$response = $bdd->prepare("DELETE FROM `Consommer` WHERE `IdAppareil`=:id");
    	$response->execute(array('id'=>$id));

		//supprimer dans emettre
		$response = $bdd->prepare("DELETE FROM `Emettre` WHERE `IdAppareil`=:id");
    	$response->execute(array('id'=>$id));
		
		//supprimer dans allumer
		$response = $bdd->prepare("DELETE FROM `Allumer` WHERE `IdAppareil`=:id");
    	$response->execute(array('id'=>$id));
		

		//supprimer dans appareil
		$response = $bdd->prepare("DELETE FROM `Appareil` WHERE `IdAppareil`=:id");
    	$response->execute(array('id'=>$id));
    //}
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
        <input type="hidden" name="voirAppart" value="<?php echo $idAppart;?>">
        <div class="boutonVoir">
        	<button class="voir" type="submit" name="confirmer">Confirmer la suppression</button>
        </div>
        
    </form>

</body>
</html>
    	