<?php

//$bdd = new PDO('mysql:host=192.168.1.1;dbname=BorneAccueil;charset=utf8', 'Admin', 'Admin89!');
$dsn = 'mysql:dbname=BorneAccueil;host=192.168.1.1';
$user = 'pi';
$password = 'Admin89!';

try {
    $bdd = new PDO($dsn, $user, $password);
} catch (PDOException $e) {
    echo 'Connexion échouée : ' . $e->getMessage();
}


echo '<!DOCTYPE html>
<html>
	<head>
		<title>Groupe couleur </title>
		<link rel="stylesheet" href="" />

	</head>
	<body>
		<h1>Groupes couleur</h1>
	';


	$reponse = $bdd->query('SELECT DISTINCT Nom FROM enfant');

  while ($donnees = $reponse->fetch())
  {
  if (file_exists('./Album/'.$donnees['Nom']))
  {
      echo 'Le fichier '.$donnees['Nom'].' existe.<br>';
  }
  else
  {
      mkdir('./Album/'.$donnees['Nom'], 0777, true);
      echo $donnees['Nom'];
  }

}
header('Location: gestion_album.php');
