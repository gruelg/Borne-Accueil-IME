<!DOCTYPE html>
<html>
	<head>
		<title>Page démarrage</title>
			<link rel="stylesheet" href="stylesheet_Borne.css" />
	</head>
	<body>

    <?php
			session_start();
			$_SESSION['nom'] = 'vide';
	    $_SESSION['statueReco']= 1 ;
    ?>
		<div class="Menu_demarrage">
		  <form action="Accueil.php" method="POST">
      		<div class="boutton_demarrage"><input type=submit name="submit" value="Mode planning"></div>
    	</form>

      <form action="gestion_album.php" method="POST">
    		<div class="boutton_demarrage"><input type=submit name="submit" value="gestion album"></div>
	    </form>
	</div>
	</body>
</html>
