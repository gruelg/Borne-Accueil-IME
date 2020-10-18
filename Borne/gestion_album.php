<!DOCTYPE html>
<html>
	<head>
		<title>gestion de l'album</title>
		<link rel="stylesheet" href="" />
	</head>
	<body>
		<table>
			<thead>
				<tr>
					<th> </th>
					<th>Noms prenoms </th>
					<th>Photos </th>
				</tr>
			</thead>

<?php
$nb_fichier =0;
if($dossier = opendir('./Album'))
{
  while(false !== ($fichier = readdir($dossier)))
  {
    if($fichier != '.'&& $fichier != '..' && $fichier != 'Ajout_eleve.php' )
    {
      $nb_fichier++;
      $tabNomEleves[$nb_fichier]= $fichier ;
    }
	}
}
$tabphoto;
echo '
	<form action="ajout_album.php" method="POST">
		<tbody>';
foreach ($tabNomEleves as $key => $value)
{
  echo '
		<tr>
			<td><input type="radio" id="'.$value.' " name="nom" value="'.$value.'"></td>
			<td><label for="'.$value.'">'.$value.'</label></td>' ;
  		$tabphoto[$key] = nbphoto('/'.$value.'/');
  echo '<td>  '.$tabphoto[$key].' </td>
	<td>

	</tr>';
}

echo '</tbody></table>';
echo '
		<input type=submit name="submit" value="Ajouter des photos">
	</form>
	<form action="miseaJourAlbum.php" method="POST">
		<input type=submit name="submit" value="Mettre a jour le tableau">
	</form>


	';

function nbphoto($chemin)
{
  $nb_fichier =0;
  if($dossier = opendir('./Album/'.$chemin))
  {
    while(false !== ($fichier = readdir($dossier)))
    {
	//les fichier suivant sont ignorÃ©s dans le compte de fichiers
      if($fichier != '.' && $fichier != '..' )
      {
        $nb_fichier++;
      }

  }
  return $nb_fichier;
  }
  }
?>
