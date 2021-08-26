<?php
include "../commonpart/sqlconnect.php";
function check_in_range($start_date, $end_date, $date_from_user)
{
  // Convert to timestamp
  $start_ts = strtotime($start_date);
  $end_ts = strtotime($end_date);
  $user_ts = strtotime($date_from_user);

  // Check that user date is between start & end
  return (($user_ts >= $start_ts) && ($user_ts <= $end_ts));
}
function smaller($dict) {
    $smaller_name = '';
    $smaller_value = 9999999999999999999999999999;
    foreach ($dict as $name => $value) {
        if ($value<=$smaller_value) {
            $smaller_value = $value;
            $smaller_name = $name;
        }
    }
    return $smaller_name;
}
if (isset($_SESSION['user_id'])){
    $mens = 0;
    $womens = 0;
    $others = 0;
    $nb_age = array('18-24' => 0,
                    '24-45' => 0,
                    '45-65' => 0,
                    '+65' => 0);
    $conso_age = array('18-24' => array('somme'=>0, 'nb_appareil'=>0),
                    '24-45' => array('somme'=>0, 'nb_appareil'=>0),
                    '45-65' => array('somme'=>0, 'nb_appareil'=>0),
                    '+65' => array('somme'=>0, 'nb_appareil'=>0));
    $conso_ville = array();
    $response1 = $bdd->prepare("SELECT `Id_personne`, `Genre`, `DateNaissance` FROM `personne`");
    $response1->execute();
    while ($row1 = $response1->fetch()) {
        if ($row1['Genre'] == 'm') {
            $mens+=1;
        }
        else if ($row1['Genre'] == 'f') {
            $womens+=1;
        }
        elseif ($row1['Genre'] == 'o') {
            $others+=1;
        }
        $date = DateTime::createFromFormat('Y-m-d', $row1['DateNaissance']);
        $year = date_format($date, 'Y');
        $age = date('Y') - $year;
        if ($age<=24 && $age>=18) {
            $nb_age['18-24']+=1;
        }
        elseif ($age>24 && $age<=45) {
            $nb_age['24-45']+=1;
        }
        elseif ($age>45 && $age<=65) {
            $nb_age['45-65']+=1;
        }
        elseif ($age>65) {
            $nb_age['+65']+=1;
        }
        $response2 = $bdd->prepare("SELECT `IdAppart`, `DebutLocation`, `FinLocation` FROM `louer` WHERE `Id_personne`=:Id_personne");
        $response2->execute(array('Id_personne'=>$row1['Id_personne']));
        while ($row2 = $response2->fetch()) {
            $response3 = $bdd->prepare("SELECT `IdAppareil` FROM `contenirappareil` WHERE `IdAppart`=:idappart");
            $response3->execute(array('idappart'=>$row2['IdAppart']));
            while ($row3 = $response3->fetch()) {
                $response4 = $bdd->prepare("SELECT `ConsoParHeure`, `IdRessource` FROM `consommer` WHERE `IdAppareil`=:idappareil");
                $response4->execute(array('idappareil'=>$row3['IdAppareil']));
                $consommer = $response4->fetch();
                $response5 = $bdd->prepare("SELECT `Libelle` FROM `ressources` WHERE `IdRessource`=:idressource");
                $response5->execute(array('idressource'=>$consommer['IdRessource']));
                $ressource = $response5->fetch()['Libelle'];
                $response6 = $bdd->prepare("SELECT `DebutAllumage`, `FinAllumage` FROM `allumer` WHERE `IdAppareil`=:idappareil");
                $response6->execute(array('idappareil'=>$row3['IdAppareil']));
                while ($row6 = $response6->fetch()) {
                    if ($ressource == "Electricité" and (is_null($row2['FinLocation']) or (check_in_range($row2['DebutLocation'], $row2['FinLocation'], $row6['DebutAllumage']) and check_in_range($row2['DebutLocation'], $row2['FinLocation'], $row6['FinAllumage'])))) {
                        $conso_appareil = (DateTime::createFromFormat('Y-m-d H:i:s', $row6['FinAllumage'])->diff(DateTime::createFromFormat('Y-m-d H:i:s', $row6['DebutAllumage']))->s) * $consommer['ConsoParHeure'];
                        if ($age<=24 && $age>=18) {
                            $conso_age['18-24']['somme']+=$conso_appareil;
                            $conso_age['18-24']['nb_appareil']+=1;
                        }
                        elseif ($age>24 && $age<=45) {
                            $conso_age['24-45']['somme']+=$conso_appareil;
                            $conso_age['24-45']['nb_appareil']+=1;
                        }
                        elseif ($age>45 && $age<=65) {
                            $conso_age['45-65']['somme']+=$conso_appareil;
                            $conso_age['45-65']['nb_appareil']+=1;
                        }
                        elseif ($age>65) {
                            $conso_age['+65']['somme']+=$conso_appareil;
                            $conso_age['+65']['nb_appareil']+=1;
                        }

                        $response7 = $bdd->prepare("SELECT `IdMaison` FROM `appart` WHERE `IdAppart`=:idappart");
                        $response7->execute(array('idappart'=>$row2['IdAppart']));
                        while ($row7 = $response7->fetch()) {
                            $response8 = $bdd->prepare("SELECT `IdVille` FROM `maison` WHERE `IdMaison`=:idmaison");
                            $response8->execute(array('idmaison'=>$row7['IdMaison']));
                            while ($row8 = $response8->fetch()) {
                                $response9 = $bdd->prepare("SELECT `NomVille` FROM `ville` WHERE `IdVille`=:idville");
                                $response9->execute(array('idville'=>$row8['IdVille']));
                                $ville = $response9->fetch()['NomVille'];
                            }
                        }
                        if (array_key_exists($ville, $conso_ville)) {
                            $conso_ville[$ville]['somme'] += $conso_appareil;
                            $conso_ville[$ville]['nb_appareil'] += 1;
                        }
                        else {
                            $conso_ville[$ville] = array('somme'=>$conso_appareil, 'nb_appareil'=>1);
                        }
                    }
                }
            }
        }
    }
    $moyenne_ville = array();
    foreach ($conso_ville as $key => $value) {
        $moyenne_ville[$key] = $value['somme']/$value['nb_appareil'];
    }
    $response10 = $bdd->prepare("SELECT `ValeurCritConsoParJour`, `ValeurIdealeConsoParJour` FROM `ressources` WHERE `IdRessource`=1;");
    $response10->execute();
    $row10 = $response10->fetch();
    $crit = $row10['ValeurCritConsoParJour'];
    $ideal = $row10['ValeurIdealeConsoParJour'];
    if ($conso_age['18-24']['nb_appareil']!=0){$moyenne1 = $conso_age['18-24']['somme']/$conso_age['18-24']['nb_appareil'];} else {$moyenne1 = 0;}
    if ($conso_age['24-45']['nb_appareil']!=0){$moyenne2 = $conso_age['24-45']['somme']/$conso_age['24-45']['nb_appareil'];} else {$moyenne2 = 0;}
    if ($conso_age['45-65']['nb_appareil']!=0){$moyenne3 = $conso_age['45-65']['somme']/$conso_age['45-65']['nb_appareil'];} else {$moyenne3 = 0;}
    if ($conso_age['+65']['nb_appareil']!=0){$moyenne4 = $conso_age['+65']['somme']/$conso_age['+65']['nb_appareil'];} else {$moyenne4 = 0;}
}
else {
    header('Location: ../index.php');
}
?>




<!DOCTYPE html>
<html lang="fr" dir="ltr">
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="/site/css/stats.css" />
        <link rel="stylesheet" href="/site/css/navbar.css" />
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
        <link rel="icon" type="image/png" href="img/favicon.png" />
        <title></title>
    </head>
    <body>
        <?php include "../navbar.php"; ?>
        <div class="container-fluid">
            <div class="container">
                <h1>Statistiques</h1>

                <table>
                  <thead>
                      <tr>
                          <th colspan="1">HOMMES</th>
                          <th colspan="1">FEMMES</th>
                          <th colspan="1">AUTRES</th>
                      </tr>
                  </thead>
                  <tbody>
                      <tr>
                          <td><?php echo $mens; ?></td>
                          <td><?php echo $womens; ?></td>
                          <td><?php echo $others; ?></td>
                      </tr>
                  </tbody>
                </table>

                <table>
                  <thead>
                      <tr>
                          <th colspan="1"></th>
                          <th colspan="1">18-24</th>
                          <th colspan="1">24-45</th>
                          <th colspan="1">45-65</th>
                          <th colspan="1">+65</th>
                      </tr>
                  </thead>
                  <tbody>
                      <tr>
                          <td>Nombre d'utilisateurs</td>
                          <td><?php echo $nb_age['18-24']; ?></td>
                          <td><?php echo $nb_age['24-45']; ?></td>
                          <td><?php echo $nb_age['45-65']; ?></td>
                          <td><?php echo $nb_age['+65']; ?></td>
                      </tr>
                      <tr>
                          <td>Consommation moyenne</td>
                          <td <?php if ($moyenne1 >= $crit) { echo 'style="background-color: red;"'; } else if ($moyenne1<=$ideal) { echo 'style="background-color: green;"'; } ?>><?php echo $moyenne1; ?></td>
                          <td <?php if ($moyenne2 >= $crit) { echo 'style="background-color: red;"'; } else if ($moyenne2<=$ideal) { echo 'style="background-color: green;"'; } ?>><?php echo $moyenne2; ?></td>
                          <td <?php if ($moyenne3 >= $crit) { echo 'style="background-color: red;"'; } else if ($moyenne3<=$ideal) { echo 'style="background-color: green;"'; } ?>><?php echo $moyenne3; ?></td>
                          <td <?php if ($moyenne4 >= $crit) { echo 'style="background-color: red;"'; } else if ($moyenne4<=$ideal) { echo 'style="background-color: green;"'; } ?>><?php echo $moyenne4; ?></td>
                      </tr>
                  </tbody>
                </table>
                <h3 style=" padding: 10px 10px 10px 10px; margin: 0;">Ville qui consome le moins : <span style="color: #22844e;"><?php echo smaller($moyenne_ville); ?></span></h3>
            </div>
        </div>
    </body>
</html>
