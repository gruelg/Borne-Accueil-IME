<?php
$bdd = new PDO('mysql:host=localhost;dbname=BorneAccueil;charset=utf8', 'root', '');

echo '<!DOCTYPE html>
<html>
	<head>
		<title>Groupe couleur </title>
		<link rel="stylesheet" href="stylesheet_serveur.css" />

	</head>
	<body>
		<h1>Groupes couleur</h1>
	';


	$reponse = $bdd->query('SELECT DISTINCT Groupe FROM enfant');

	// On affiche chaque entrée une à une
	echo '<div class="groupe_couleur">';
	while ($donnees = $reponse->fetch())
	{
		echo '
		<div>
		<form action="trombinoscope.php" method="POST">
			<input type="text" name="couleur" value="'.$donnees['Groupe'] .'" hidden>
			<input name="nom" type="image" src="Couleurs/'.$donnees['Groupe'] .'.jpg" alt="Submit" width="120" height="120">'.$donnees['Groupe'] .'
		</form>
		</div>
			';
}
echo '</div>';
