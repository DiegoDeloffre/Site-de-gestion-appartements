<ul class="ul-navbar">
 <li class="navbar logo">
     <a href="/site/index.php">
         <img class="logo-navbar" src="/site/img/logo.png" alt="logo">
     </a>
 </li>
 <li class="navbar dropdown">
    <a href="/site/pages/tableauDeBord.php" class="dropbtn">Tableau de bords</a>
    <div class="dropdown-content">
      <a href="/site/pages/stats.php">Statistiques</a>
    </div>
  </li>
 <li class="navbar"><a href="/site/pages/conseils.php">Conseils</a></li>

 <?php if ($connected) {?>
   <li class="navbar login"><a href="/site/api/logoutapi.php">Déconnexion</a></li>
   <li class="navbar-profil">
       <a href="/site/pages/profil.php">
           <img class="profil" src="/site/img/profil.png" alt="logo" >
       </a>
   </li>
 <?php } else { ?>
   <li class="navbar login"><a href="/site/pages/login.php">Connexion</a></li>
 <?php } ?>
</ul>
