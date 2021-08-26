<?php
  session_start();
  try {
    $bdd = new PDO('mysql:host=localhost;dbname=bdd_projetbdd;charset=utf8', 'root', '');
  } catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
  }
  if (isset($_SESSION['user_id'])){
    $connected = true;
  }
  else {
    $connected = false;
  }
?>
