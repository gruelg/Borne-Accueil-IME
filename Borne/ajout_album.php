<!DOCTYPE html>
<html>
	<head>
		<title>Ajout album</title>
		<link rel="stylesheet" href="" />

	</head>
	<body>

<?php
session_start();
$_SESSION['Nom'] = $_POST['nom'];

$monfichier = fopen('StreamVideo/Bool_reco.txt', 'r+');

fseek($monfichier, 0);
fputs($monfichier, 1);
//le "1" dans le fichier sert a determiner si la reco est utilisée ou non
//ici non
fputs($monfichier, " ");
//ajout d'un espace et du nom de la personne ou seront enregistrée les photos
fputs($monfichier, $_SESSION['Nom']);
//rajoute un grand espace afin d'ecraser le reste de noms et prenoms plus grand que l'actuel
fputs($monfichier, "                         " );
//fermeture du fichier
fclose($monfichier);
echo '
	<a href="http://127.0.0.1:5000/ajout_album">
		<img src="images/reconnaissance_faciale.jpg" alt="Reconnaissance faciale" width="" height="">
	</a>
';
?>
	<div="explication" ><p>l'accés à la camera doit se faire manuellement </p></div>
