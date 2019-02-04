<!DOCTYPE html>
<html lang="fr">
<head>
	 <meta charset="utf-8">			
    <title>Aframe Tour Creator</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="css/accueil.css" />
    <script src="js/accueil.js"></script>
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
						$im = pathinfo($fichier);
						if(!isset($nomIm)){
							$nomIm=$im['filename'];
						}
						else{
							$nomIm=$nomIm.":".$im['filename'];
						}
					}
				}
				if($dossier = opendir('./uploads'))
				{
					while(false !== ($fichier = readdir($dossier)))
					{
						if($fichier != '.' && $fichier != '..' && $fichier != 'ajout.jpeg' && $fichier != 'validation.png')
						{
							echo "<a class=\"clickable\" onClick='sendData(this,\"pointsI.php?img=".basename($fichier)."&li=".$nomIm."\")'><img id=\"".basename($fichier)."\" class=\"photos rounded img-fluid\" src=\"./uploads/".basename($fichier)."\" alt=\"Désolé notre image a rencontré des problèmes\"></a>";
							
						}
					}
				}
			}
		?>
	</section>
	<form id="pointsForm" action="" method="POST">
		<?php 
			foreach ($_POST as $tableaux => $contenuTab) {
				foreach ($contenuTab as $piece => $contenu) {
					foreach ($contenu as $key) {
						echo "<input type='text' name='".$tableaux."[".$piece."][]' hidden value='".$key."'/>";
					}
				}
			}
		?>
	</form>
	<footer>
		<div class="d-flex justify-content-center">
			<a class="btn btn-danger clickable" onClick='<?php echo "sendData(this,\"default.php?li=".$nomIm."\")"?>' >Suivant</a>
		</div>	
	</footer>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/java.js"></script>
</body>
</html>