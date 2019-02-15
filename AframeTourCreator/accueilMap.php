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
			if($dossier = opendir('./maps')){
				while(false !== ($fichier = readdir($dossier)))
				{
					$fic=pathinfo($fichier);
					$ext=strtolower($fic['extension']);
					if($fichier != '.' && $fichier != '..' && ($ext=="png" || $ext=="jpg" || $ext=="jpeg"))
					{
						if(!isset($nomIm)){
							$nomIm=$fic['filename'];
						}
						else{
							$nomIm=$nomIm.":".$fic['filename'];
						}
					}
				}
				$tabImgs=explode(":",$nomIm);
				$cpt=0;
				if($dossier = opendir('./maps'))
				{
					while(false !== ($fichier = readdir($dossier)))
					{
						$fic=pathinfo($fichier);
						$ext=strtolower($fic['extension']);
						if($fichier != '.' && $fichier != '..' && ($ext=="png" || $ext=="jpg" || $ext=="jpeg"))
						{
							echo "
							<figure class=\"photos\">
							<a class=\"clickable\" href=ajoutPointsMaps.php?img=".$fic['basename']."&li=".filter_var($_REQUEST['li'],FILTER_SANITIZE_STRING)."\"><img id=\"".$fic['basename']."\" class=\"rounded img-fluid\" src=\"./uploads/".$fic['basename']."\" alt=\"Désolé notre image a rencontré des problèmes\"></a>
							<figcaption><strong>".$tabImgs[$cpt]."</strong></figcaption>
							</figure>
							";
							$cpt+=1;
							
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