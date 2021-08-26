<?php
include '../commonpart/sqlconnect.php';
if (isset($_SESSION['user_id'])) {
  header('Location: ../index.php');
}
else {
  if (isset($_POST['email'])) {
    $mail = $_POST['email'];
    $password = $_POST['password'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $naissance = $_POST['naissance'];
    $telephone = $_POST['telephone'];
    $gender = $_POST['gender'];
    $hash = password_hash($password . 'xkNiWnNFX6rOa3Zwdq2AVEl', PASSWORD_DEFAULT);

    $response = $bdd->prepare("SELECT `Id_personne` FROM `personne` WHERE `AdresseMail`=:mail");
    $response->execute(array('mail'=>$mail));
    $exist = 0;
    while ($row = $response->fetch()) {
      $exist = 1;
    }

    if ($exist != 1) {
      $response = $bdd->prepare("INSERT INTO `personne` (`Id_personne`, `AdresseMail`, `MotDePasse`, `DateNaissance`, `Nom`, `Prenom`, `Genre`, `Telephone`) VALUES (NULL, :mail, :password, :naissance, :nom, :prenom, :gender, :telephone)");
      $response->execute(array('mail'=>$mail,
                                'password'=>$hash,
                                'naissance'=>$naissance,
                                'nom'=>$nom,
                                'prenom'=>$prenom,
                                'gender'=>$gender,
                                'telephone'=>$telephone));
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
  }
  if (isset($_SESSION['user_id'])) {
    header('Location: ../index.php');
  }
  else {
    header('Location: ../pages/inscription.php');
  }
}
?>
