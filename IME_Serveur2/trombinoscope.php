<?php
session_start();
$_SESSION['methode']=1;
$bdd = new PDO('mysql:host=localhost;dbname=BorneAccueil;charset=utf8', 'root', '');
$couleur  = $_POST['couleur'];
$reponse = $bdd->prepare('SELECT * FROM enfant where Groupe = :couleur');
$reponse->execute(array('couleur' => $couleur  ));
// On affiche chaque entrée une à une
echo '<!DOCTYPE html>
<html>
	<head>
		<title>Groupe couleur </title>
		<link rel="stylesheet" href="stylesheet_serveur.css" />

	</head>
	<body>
		<h1>Trombinoscope</h1>
	';
echo '<div class="trombinoscope">';
while ($donnees = $reponse->fetch())
{
   //echo 'Nom : '.$donnees['Nom'].'   cheminImages : '.$donnees['CheminPhotoProfil'] .'<br>'  ;
   echo '
   <a href="affichage_planning.php?&nom='.$donnees['Nom'].'">
     <div>
	<figure>
	<img src="photo_profil/'.$donnees['CheminPhotoProfil'].'" alt="" width="140" height="140">
	<figcaption>'.$donnees['Nom'].'</figcaption>
	</figure>

	</div>
   </a>
        ';

}


echo '</div>';

?>
