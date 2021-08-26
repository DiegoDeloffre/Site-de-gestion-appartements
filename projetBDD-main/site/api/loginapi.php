<?php
include '../commonpart/sqlconnect.php';
if (isset($_SESSION['user_id'])) {
  header('Location: ../index.php');
}
else {
  if (isset($_POST['email']) and isset($_POST['password'])) {
    $mail = $_POST['email'];
    $password = $_POST['password'];
    $response = $bdd->prepare("SELECT * FROM `personne` WHERE `AdresseMail`=:mail");
    $response->execute(array('mail'=>$mail));
    while ($row = $response->fetch()) {
      if (password_verify($password . 'xkNiWnNFX6rOa3Zwdq2AVEl',$row['MotDePasse'])) {
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
    header('Location: ../pages/login.php');
  }
}
 ?>
