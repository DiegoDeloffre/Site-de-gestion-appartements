<?php
include '../commonpart/sqlconnect.php';
if (isset($_POST['email'])) {
$mail = $_POST['email'];
$password = $_POST['password'];
$password2 = $_POST['password2'];
$password3 = $_POST['password3'];
$response = $bdd->prepare("SELECT `MotDePasse` FROM `personne` where Id_personne =:id");
$response->execute(array('id' => $_SESSION['user_id']));
while ($row = $response->fetch()) {
    $opassword=$row['MotDePasse'];
}
if (!password_verify($password. 'xkNiWnNFX6rOa3Zwdq2AVEl',$opassword)){
    echo '<script type="text/javascript">';
    echo 'window.location.href = "../pages/profil.php?error=Le%20mot%20de%20passe%20fournis%20n%27est%20pas%20le%20bon";';
    echo '</script>';
    exit();

}
if ($password2!=$password3){
    echo '<script type="text/javascript">';
    echo 'window.location.href = "../pages/profil.php?error=Les%20deux%20mots%20de%20passe%20ne%20correspondent%20pas";';
    echo '</script>';
    exit();
}

$nom = $_POST['Nom'];
$prenom = $_POST['Prenom'];
$naissance = $_POST['naissance'];
$telephone = $_POST['telephone'];
$gender = $_POST['gender'];

$hash = password_hash($password2 . 'xkNiWnNFX6rOa3Zwdq2AVEl', PASSWORD_DEFAULT);


  $response = $bdd->prepare("UPDATE `personne` SET  `AdresseMail`=:AdresseMail, `MotDePasse`=:MotDePasse, `DateNaissance`=:naissance, `Nom`=:nom, `Prenom`=:prenom, `Genre`=:gender, `Telephone`=:telephone WHERE `Id_personne`=:id");
  $response->execute(array('AdresseMail'=>$mail,
                            'MotDePasse'=>$hash,
                            'naissance'=>$naissance,
                            'nom'=>$nom,
                            'prenom'=>$prenom,
                            'gender'=>$gender,
                            'telephone'=>$telephone,
                            'id'=>$_SESSION['user_id']));
  $response = $bdd->prepare("SELECT * FROM `personne` WHERE `AdresseMail`=:mail");
  $response->execute(array('mail'=>$mail));
  while ($row = $response->fetch()) {
    if ($row['MotDePasse']==$hash) {
      $_SESSION['user_id'] = $row['Id_personne'];
      $_SESSION['mail'] = $row['AdresseMail'];
      $_SESSION['nom'] = $row['Nom'];
      $_SESSION['prenom'] = $row['Prenom'];
      $_SESSION['genre'] = $row['Genre'];
      $_SESSION['telephone'] = $row['Telephone'];
      $_SESSION['naissance'] = $row['DateNaissance'];
    }
  }

}
if (isset($_SESSION['user_id'])) {
header('Location: ../index.php');
}
else {
header('Location: ../pages/inscription.php');
}
?>
