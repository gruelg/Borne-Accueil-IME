<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <link rel="stylesheet" href="stylesheet.css" />
        <title></title>
    </head>

    <body>

<?php
//lecture d'un fichier ligne par ligne
session_start();

$fic=fopen("StreamVideo/tabnom.csv", "r");
$i=0 ;//Compteur de ligne
$comparaison = 0;
while(!feof($fic))
{
$ligne= fgets($fic,1024);
echo "<br>ligne numéro ".$i." : " . $ligne . "";
$tab[$i]=$ligne;
$i++;

}
echo '<br><br>';

//conmpte la longeure du tableau
$max = count($tab);
$comparaison = 0;
$comparaisonMax = 0 ;
$nom = "";
//croise le tableau avec lui-meme
//pour avoir le nom le + detecte
for($i=0;$i<$max-1;$i++)
{
  for($y=0;$y<$max;$y++)
  {
    //tab[0] vaut par defaut " "
    //aucun visage detectee
    if($tab[$i]==$tab[$y])
    {
      $comparaison++;
    }
  }
  //le nombre de * ou tab[0] n'est pas tenu en compte
  if($comparaison > $comparaisonMax && $tab[$i]!=$tab[0])
  {
    $comparaisonMax = $comparaison;
    $nom = $tab[$i];
  }

  $comparaison = 0;
}

if($comparaisonMax>=6   )
{
    $_SESSION['nom'] = $nom;

    header('location: http://127.0.0.1/IME_Serveur2/affichage_planning.php?&nom='.$nom.'');



}
//si le meme nom est apparu - de 6 fois
if($comparaisonMax< 6)
{
    $_SESSION['statueReco'] = 0 ;
    $_SESSION['raisonEchec'] = 1 ;
    header('location: Accueil.php');
}
//fermeture du fichier

fclose($fic);
