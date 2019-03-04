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
	<div><h1>Choisissez quelles cartes doivent être supprimées :</h1></div>
	<section id="listeImg" class="text-center">
		<?php
			$nomIm = $_REQUEST['nomIm'];
			if($dossier = opendir('./maps')){
				while(false !== ($fichier = readdir($dossier)))
				{
					if($fichier != '.' && $fichier != '..' && $fichier != 'ajout.jpeg' && $fichier != 'validation.png')
					{
						echo "<a class=\"clickable\" onClick='choiceDef(this,\"".pathinfo($fichier)['filename']."\")'><img id=\"".basename($fichier)."\" class=\"photosDefault rounded img-fluid\" src=\"./maps/".basename($fichier)."\" alt=\"Désolé notre image a rencontré des problèmes\"></a>";
						
					}
				}
			}
		?>
	</section>
	<form id="pointsForm" action="" method="POST">
	</form>
	<footer>
	<div class="d-flex justify-content-center">
		<a class="btn btn-danger clickable" onClick='<?php echo "sendData(this,\"supprimerM.php?li="+$nomIm+")"?>' >Suivant</a>
	</div>	
	</footer>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/java.js"></script>
</body>
</html>