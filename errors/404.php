<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Erreur page introuvable</title>
	<link href="https://fonts.googleapis.com/css?family=Cabin:400,700" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Montserrat:900" rel="stylesheet">
	<link type="text/css" rel="stylesheet" href="/ils_etaient_neuf/errors/css/style.css" />
</head>
<body>
	<div id="notfound">
		<div class="notfound">
			<div class="notfound-404">
				<h3>Oops! La page est introuvable</h3>
				<h1><span>4</span><span>0</span><span>4</span></h1>
			</div>
			<h2>Nous sommes désolés, mais la page demandée est introuvable !</h2>
			<?php
				// Afficher l'URL de la page courante
				// Construire l'URL de redirection vers le répertoire spécifique
				$redirectUrl = "http://$_SERVER[HTTP_HOST]/ils_etaient_neuf/src/";
				$url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

				echo "<h2>Redirection vers la page d'accueil</h2>";
				echo "<button onclick=\"window.location.href='$redirectUrl'\">Page d'accueil</button>";
			?>
		</div>
	</div>
</body>
</html>
