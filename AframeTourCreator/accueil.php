<!DOCTYPE html>
<html lang="fr">
<head>
	 <meta charset="utf-8">																						
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Aframe Tour Creator</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="css/accueil.css" />
</head>
<body class="bg-info">
	<div><h1>Voici la liste des photos de votre tour 360° :</h1></div>
	<section id="listeImg" class="text-center">
		<?php
			if($dossier = opendir('./uploads')){
				while(false !== ($fichier = readdir($dossier)))
				{
					if($fichier != '.' && $fichier != '..' && $fichier != 'ajout.jpeg' && $fichier != 'validation.png')
					{
						echo "<img class=\"photos rounded img-fluid\" src=\"./uploads/".basename($fichier)."\" alt=\"Désolé notre image a rencontré des problèmes\">";
						
					}
				}
			}
		?>
	</section>
	<footer>
	<div class="d-flex justify-content-center">
		<button class="btn btn-danger">Créer</button>
	</div>	
	</footer>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/java.js"></script>
</body>
</html>

