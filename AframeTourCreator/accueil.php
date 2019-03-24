<!DOCTYPE html>
<html lang="fr">
<head>
	 <meta charset="utf-8">			
    <title>Aframe Tour Creator</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="css/accueil.css" />
</head>
<body class="bg-info">
	<header>
		<a href="clean.php"><img class="logo" src="fondecran.png"></a>
	</header>
	<div><h1>List of your 360° tour's photos :</h1></div>
	<section id="listeImg" class="text-center">
		<?php
			if($dossier = opendir('./uploads')){
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
					header("Location: erreur.php");
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
						<a href='pointsI.php?new=".filter_var($_GET['new'])."&img=".$fic['basename']."&li=".$nomIm."'><img id=\"".$fic['basename']."\" class=\"rounded img-fluid\" src=\"./uploads/".$fic['basename']."\" alt=\"Désolé notre image a rencontré des problèmes\"></a>
						<figcaption><strong>".$tabImgs[$cpt]."</strong></figcaption>
						</figure>
						";
						$cpt+=1;
						
					}
				}
			}
			else{
				header('Location: erreur.php');
			}
			$nbMaps = 0;
			if($dossier = opendir('./maps')){
				while(false !== ($fichier = readdir($dossier)))
				{
					$fic=pathinfo($fichier);
					$ext=strtolower($fic['extension']);
					if($fichier != '.' && $fichier != '..' && ($ext=="png" || $ext=="jpg" || $ext=="jpeg"))
					{
						$nbMaps++;
					}
				}
			}
			else{
				header('Location: erreur.php');
			}
		?>
	</section>
	<?php 
		if(isset($_POST['nomPiece'])){
			$dom = new DomDocument();
			$dom->preserveWhiteSpace = false;
			$dom->formatOutput = true;
			$dom->load('download/save.xml');
			$nomP = $_POST['nomPiece'];
			$piece = $dom->getElementById($nomP);

			if(isset($_POST['pointsPos'])){
				$newPositions = $_POST['pointsPos'][$nomP];
				$newTargets = $_POST['pointsTarget'][$nomP];
				$newRotations = $_POST['pointsRot'][$nomP];
			}
			else{
				$newPositions = [];
				$newTargets = [];
				$newRotations = [];
			}
			if(isset($_POST['listPanns'])){
				$newPanns = $_POST['listPanns'][$nomP];
				$newTexts = $_POST['listTextPanns'][$nomP];
			}
			else{
				$newPanns = [];
				$newTexts = [];
			}


			$posTag = $piece->getElementsByTagName("positions")->item(0);
			$positions = $posTag->getElementsByTagName("value");
			$targetTag = $piece->getElementsByTagName("targets")->item(0);
			$targets = $targetTag->getElementsByTagName("value");
			$rotationTag = $piece->getElementsByTagName("rotations")->item(0);
			$rotations = $rotationTag->getElementsByTagName("value");
			$pannTag = $piece->getElementsByTagName("panns")->item(0);
			$panns = $pannTag->getElementsByTagName("value");
			$nbP = $positions->count();
			$key=-1;
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
						$rot = $dom->createElement("value");
						$rot->setAttribute("num",$key);
						$rot->nodeValue = $newRotations[$key];
						$rotationTag->replaceChild($rot,$rotations->item($key));
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
					$rot = $dom->createElement("value");
					$rot->setAttribute("num",$key);
					$rot->nodeValue = $newRotations[$key];
					$rotationTag->appendChild($rot);
				}
			}
			if($key<$nbP-1){
				for($i=$key+1;$i<$nbP;$i++){
					$posTag->removeChild($positions->item($i));
					$targetTag->removeChild($targets->item($i));
					$rotationTag->removeChild($rotations->item($i));
					$nbP--;
					$i--;
				}
			}
			
			$key = -1;
			$nbP = $panns->count();
			foreach ($newPanns as $key => $value) {
				if($key < $nbP){
					if($value != $panns->item($key)->nodeValue){
						$pann = $dom->createElement("value");
						$pann->setAttribute("text",$newTexts[$key]);
						$pann->nodeValue = $value;
						$pannTag->replaceChild($pann,$panns->item($key));
					}
				}
				else{
					$pann = $dom->createElement("value");
					$pann->setAttribute("text",$newTexts[$key]);
					$pann->nodeValue = $value;
					$pannTag->appendChild($pann);
				}
			}
			if($key<$nbP-1){
				for($i=$key+1;$i<$nbP;$i++){
					$pannTag->removeChild($panns->item($i));
					$nbP--;
					$i--;
				}
			}


			$dom->save("download/save.xml");


		}


	?>
	<footer>
		<div class="d-flex justify-content-center">
			<a class="btn btn-success" href="accueilMap.php?new=<?php echo $_GET['new']; ?>&li=<?php echo $nomIm; ?>" >
			See maps</a>
			<a class="btn btn-primary" href="images.php?new=<?php echo $_GET['new']; ?>&ajout=true" >
			Add images</a>
			<a class="btn btn-secondary" href="supprimerImgs.php?new=<?php echo $_GET['new']; ?>&li=<?php echo $nomIm; ?>" >
			Delete images</a>
			<?php
			$dom = new DomDocument();
			$dom->preserveWhiteSpace = false;
			$dom->formatOutput = true;
			$dom->load('download/save.xml');
			$maps = $dom->getElementsByTagName("map");
			if(count($maps)==$nbMaps)
				echo "<a class=\"btn btn-danger\" href='default.php?new=".$_GET['new']."'>Next</a>";
			?>
		</div>	
	</footer>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/java.js"></script>
</body>
</html>