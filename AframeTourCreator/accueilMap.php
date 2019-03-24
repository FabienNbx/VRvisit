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
	<div><h1>Here is the list of maps of your 360 ° tour:</h1></div>
	<section id="listeImg" class="text-center">
		<?php
		$li = filter_var($_REQUEST['li'],FILTER_SANITIZE_STRING);
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
				if(!isset($nomIm))
					header('Location: ajouterMap.php?new='.$_GET['new'].'&li='.$_GET['li']);
				$tabImgs=explode(":",$nomIm);
				$cpt=0;
				rewinddir();
				while(false !== ($fichier = readdir($dossier)))
				{
					$fic=pathinfo($fichier);
					$ext=strtolower($fic['extension']);
					if($fichier != '.' && $fichier != '..' && ($ext=="png" || $ext=="jpg" || $ext=="jpeg"))
					{

						echo "
							<figure class=\"photos\">
							<a class=\"clickable\" href=ajoutPointsMaps.php?new=".$_GET['new']."&img=".$fic['basename']."&li=".$li."><img id=\"".$fic['basename']."\" class=\"rounded img-fluid\" src=\"./maps/".$fic['basename']."\" alt=\"Désolé notre image a rencontré des problèmes\"></a>
							<figcaption><strong>".$tabImgs[$cpt]."</strong></figcaption>
							</figure>
							";
							$cpt+=1;
							
					}
				}
			}
			else{
				header("Location: erreur.php");
			}
		?>
	</section>
	<?php
		if(isset($_POST['nomMap'])){
			$dom = new DomDocument();
			$dom->preserveWhiteSpace = false;
			$dom->formatOutput = true;
			if(!$dom->load('download/save.xml'))
					header("Location: erreur.php");
			/*if(!$dom->load('download/save.xml')){
				header('Location: erreur.php');
			}*/
			$nomM = $_POST['nomMap'];
			$map = $dom->getElementById($nomM);

			if(isset($_POST['pointsPos'])){
				$newPositions = $_POST['pointsPos'][$nomM];
				$newTargets = $_POST['pointsTarget'][$nomM];
			}
			else{
				$newPositions = [];
				$newTargets = [];
			}


			$posTag = $map->getElementsByTagName("positions")->item(0);
			$positions = $posTag->getElementsByTagName("value");
			$targetTag = $map->getElementsByTagName("targets")->item(0);
			$targets = $targetTag->getElementsByTagName("value");
			$nbP = $positions->count();
			$key = -1;
			foreach ($newPositions as $key => $value) {
				if($key < $nbP){
					if($value != $positions->item($key)->nodeValue){
						$point = $dom->createElement("value");
						$point->setAttribute("num",$key);
						$point->nodeValue = $value;
						$posTag->replaceChild($point,$positions->item($key));
						$tar = $dom->createElement("value");
						$tar->setAttribute("num",$key);
						$tar->nodeValue = $newTargets[$key];
						$targetTag->replaceChild($tar,$targets->item($key));
					}
				}
				else{
					$point = $dom->createElement("value");
					$point->setAttribute("num",$key);
					$point->nodeValue = $value;
					$posTag->appendChild($point);
					$tar = $dom->createElement("value");
					$tar->setAttribute("num",$key);
					$tar->nodeValue = $newTargets[$key];
					$targetTag->appendChild($tar);
				}
			}
			if($key<$nbP-1){
				for($i=$key+1;$i<$nbP;$i++){
					$posTag->removeChild($positions->item($i));
					$targetTag->removeChild($targets->item($i));
					$nbP--;
					$i--;
				}
			}

			$dom->save("download/save.xml");


		}
	?>

	<footer>
		<div class="d-flex justify-content-center">
			<a class="btn btn-success" href="ajouterMap.php?new=<?php echo $_GET['new']; ?>&li=<?php echo $_GET['li']; ?>">Add more maps</a>
			<a class="btn btn-secondary" href="supprimerMaps.php?new=<?php echo $_GET['new']; ?>&li=<?php echo $li; ?>">Delete maps</a>
			<a class="btn btn-primary" href="accueil.php?new=<?php echo $_GET['new']; ?>">Go to photos</a>
			<a class="btn btn-danger clickable" href="default.php?new=<?php echo $_GET['new']; ?>">Next</a>
		</div>	
	</footer>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/java.js"></script>
</body>
</html>