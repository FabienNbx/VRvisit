<!DOCTYPE html>
<html lang="fr">
<head>
	 <meta charset="utf-8">			
    <title>Aframe Tour Creator</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="css/default.css" />
    <script src="js/accueil.js"></script>
</head>
<body class="bg-info">
	<div><h1>Choose wich place will be the start point</h1></div>
	<section id="listeImg" class="text-center">
		<p id="err">You must choose a start point !</p>
		<?php
			if($dossier = opendir('./uploads')){
				while(false !== ($fichier = readdir($dossier)))
				{
					$ext=strtolower(pathinfo($fichier)['extension']);
					if($fichier != '.' && $fichier != '..' && ($ext=="png" || $ext=="jpg" || $ext=="jpeg"))
					{
						echo "<figure class=\"photos\">
						<a class=\"clickable\" onClick='choiceDef(this,\"".pathinfo($fichier)['filename']."\")'><img id=\"".basename($fichier)."\" class=\"rounded img-fluid\" src=\"./uploads/".basename($fichier)."\" alt=\"Désolé notre image a rencontré des problèmes\"></a><figcaption><strong>".pathinfo($fichier)['filename']."</strong></figcaption>
						</figure>";
						
					}
				}
			}
		?>
	</section>
	<form id="pointsForm" action="" method="POST">
	</form>
	<footer>
	<div class="d-flex justify-content-center">
		<a class="btn btn-danger clickable" href="accueil.php?new=<?php echo $_GET['new']; ?>" >Back</a>
		<p class="btn btn-danger clickable" onClick='<?php echo "sendData(this,\"save.php\")"?>' >Create</p>
	</div>	
	</footer>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/java.js"></script>
</body>
</html>