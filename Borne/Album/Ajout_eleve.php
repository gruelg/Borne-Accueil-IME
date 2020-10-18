<?php

session_start();
$_SESSION['Nom'] = $_POST['nom'];

mkdir($_SESSION['Nom'], 0777, true);
echo '<meta http-equiv="refresh" content="0.5;url=http://127.0.0.1/Borne/gestion_album.php">';

 ?>
