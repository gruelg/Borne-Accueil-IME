<!DOCTYPE html>
<html>
	<head>
		<title>Page accueil</title>
		<link rel="stylesheet" href="stylesheet_Borne.css" />
		<meta http-equiv="refresh" content="1;url=http://127.0.0.1/Borne/Accueil.php">


	</head>
	<body>
	<div class="Menu_Accueil">
		  <div>
			<a href="http://127.0.0.1/IME_Serveur/groupe_couleur.php">
				<img src="images/groupe_couleur.jpg" alt="Groupe Couleur" width="200" height="200">
			</a>
			</div>
			<div>
			<a href="http://127.0.0.1:5000/Reconnaissance_Faciale">
				<img src="images/reconnaissance_faciale.jpg" alt="Reconnaissance faciale"  width="200" height="200">
			</a></div>

	</div>

<?php
session_start();
//codes d'erreur pour la reconnaissance faciale
switch($_SESSION['statueReco'])
{
	case 0:
		echo 'Reconnaissance Faciale Impossible ';
		break;
}

//le contenu du fichier Bool_reco est
$monfichier = fopen('StreamVideo/Bool_reco.txt', 'r+');
//place le curseur au debut du fichier
fseek($monfichier, 0);
//le contenu du fichier Bool_reco est remplace par des espaces
fputs($monfichier, "                  ");
//sinon la reconnaissance est impossible
//voir le fichier main.py dans le dossier Stream
fclose($monfichier);
//fermeture du fichier
?>


	</body>
</html>
