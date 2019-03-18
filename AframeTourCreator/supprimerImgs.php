<!DOCTYPE html>
<html lang="fr">
<head>
	 <meta charset="utf-8">			
    <title>Aframe Tour Creator</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="css/supp.css" />
    <script src="js/supp.js"></script>
</head>
<body class="bg-info">
	<div><h1>Choose which photos will be deleted :</h1></div>
	<section id="listeImg" class="text-center">
		<?php
			if($dossier = opendir('./uploads')){
				while(false !== ($fichier = readdir($dossier)))
				{
					$ext=strtolower(pathinfo($fichier)['extension']);
					if($fichier != '.' && $fichier != '..' && ($ext=="png" || $ext=="jpg" || $ext=="jpeg"))
					{
						echo "<a class=\"clickable\" onClick='choiceDef(this,\"".pathinfo($fichier)['filename']."\")'><img id=\"".basename($fichier)."\" class=\"photosDefault rounded img-fluid\" src=\"./uploads/".basename($fichier)."\" alt=\"Désolé notre image a rencontré des problèmes\"></a>";
						
					}
				}
			}
		?>
	</section>
	<form id="pointsForm" action="" method="POST">
	</form>
	<footer>
	<div class="d-flex justify-content-center">
		<a class="btn btn-danger clickable" onClick='<?php echo "sendData(this,\"supprimerI.php?new=".filter_var($_GET['new'])."\")"?>' >Next</a>
	</div>	
	</footer>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/java.js"></script>
</body>
</html>