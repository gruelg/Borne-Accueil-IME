<?php
echo '<!DOCTYPE html>
<html>
	<head>
		<title>Planning </title>
		<link rel="stylesheet" href="stylesheet_serveur.css" '.echo time(); '. media="all"/>
		<meta http-equiv="refresh" content="15;url=http://192.168.1.22/Borne/Accueil.php">


	</head>
	<body>

	';
session_start();
echo $_SESSION['methode'];
$nom = $_GET['nom'];
echo '	<h1>Bonjour '.$nom.'</h1>';
$bdd = new PDO('mysql:host=localhost;dbname=BorneAccueil;charset=utf8', 'root', '');
//recupere le nbre d'activité a afficher pour l'enfant
$nbActivites = $bdd->prepare('select VueTemporellePlanning from enfant where Nom = :nom');
$nbActivites->execute(array('nom' => $nom  ));
$nbActivites = $nbActivites->fetch();

$temps = 8;
$heure = (date("g")+2 ).'h'.date("i");
echo '<div class="heure"><h1> '.$heure.'</h1></div>';
$jour = jourFr();
if($nbActivites['VueTemporellePlanning']==2)
{
	$emploiDuTemps = $bdd->prepare('SELECT enfant.CheminPhotoProfil,activites.CheminPicto,enfant.VueTemporellePlanning ,activites.Nom, planning.Debut FROM enfant,activites,planning where
	enfant.Nom = :nom and enfant.idEnfant = planning.Enfant_idEnfant and planning.Activites_idActivites = activites.idActivites and planning.Debut >= :debut ORDER BY planning.Debut ASC ');
	$emploiDuTemps->execute(array('nom' => $nom,'debut' => $heure ));
}
else
{
	$emploiDuTemps = $bdd->prepare('SELECT enfant.CheminPhotoProfil,activites.CheminPicto,enfant.VueTemporellePlanning ,activites.Nom, planning.Debut FROM enfant,activites,planning where
	enfant.Nom = :nom and enfant.idEnfant = planning.Enfant_idEnfant and planning.Activites_idActivites = activites.idActivites ORDER BY planning.Debut ASC ');
	$emploiDuTemps->execute(array('nom' => $nom));
}



// On affiche chaque entrée une à une
$photo = $bdd->prepare('select CheminPhotoProfil from enfant where Nom = :nom');
$photo->execute(array('nom' => $nom  ));

$photo = $photo->fetch();
echo' <div class="photo_profil">
	<figure>
	<img src="photo_profil/'.$photo['CheminPhotoProfil'].'" alt="photo Profil" width="120" height="120">
      	<figcaption>Photo de profil</figcaption>
	</figure>
       </div>';



$i=0;
echo '<div class="titre_planning"><h1>Planning</h1></div>';
echo '<div class="planning">';

while (($donnees = $emploiDuTemps->fetch()) && $i < $nbActivites['VueTemporellePlanning'] )
{

  echo $donnees['Debut'].'h
		<div>
	   <figure>
	   	<img src="Pictogrammes/'.$donnees['CheminPicto'].'" alt="pictogramme" width="100" height="100">
	   	<figcaption>'.$donnees['Nom'].'</figcaption>
		 </figure>

	 </div>';
  //echo $donnees['CheminPicto'] ;
  //echo date("l");
  //echo date("G")+2;
  //echo date("i");


  $i++;

}
echo '</div>';



function jourFr()
{
  $jour = date("l");
  switch ($jour) {
    case 'Monday':
       $jour = "lundi";
      break;
    case "Tuesday":
      $jour= "mardi";
      break;
    case "Wednesday":
      $jour = "Mercredi";
      break;
    case "Thursday":
      $jour = "Jeudi";
      break;
    case "Friday":
      $jour = "Vendredi";
      break;
      case "Saturday":
        $jour = "Samedi";
        break;
      case "Sunday":
        $jour = "Dimanche";
        break;

  }
  return $jour ;
}
?>
