<!DOCTYPE html>
<html lang="fr">
<head>
	 <meta charset="utf-8">			
    <title>Aframe Tour Creator</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="css/accueil.css" />
<!--     <script src="js/accueil.js"></script>
 --></head>
<body class="bg-info">
	<div><h1>Voici la liste des photos de votre tour 360° :</h1></div>
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
				$tabImgs=explode(":",$nomIm);
				$cpt=0;
				if($dossier = opendir('./uploads'))
				{
					while(false !== ($fichier = readdir($dossier)))
					{
						$fic=pathinfo($fichier);
						$ext=strtolower($fic['extension']);
						if($fichier != '.' && $fichier != '..' && ($ext=="png" || $ext=="jpg" || $ext=="jpeg"))
						{
							echo "
							<figure class=\"photos\">
							<a href='pointsI.php?img=".$fic['basename']."&li=".$nomIm."\")'><img id=\"".$fic['basename']."\" class=\"rounded img-fluid\" src=\"./uploads/".$fic['basename']."\" alt=\"Désolé notre image a rencontré des problèmes\"></a>
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
	<?php 
		if(isset($_POST['nomPiece'])){
			$dom = new DomDocument();
			$dom->load('download/save.xml');
			/*if(!$dom->load('download/save.xml')){
				header('Location: erreur.php');
			}*/
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
				}
			}

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
				}
			}


			$dom->save("download/save.xml");


		}
		else{
			//require "erreur.php";
		}

	?>
	<footer class="d-flex justify-content-center">
		<a class="btn btn-success" href="ajouterMap.php?new=<?php echo $_GET['new']; ?>&li=<?php echo $nomIm; ?>" >Ajouter une map</a>
 		<a class="btn btn-primary" href="images.php?new=<?php echo $_GET['new']; ?>&ajout=true" >Ajouter d'autres images</a>
		<a class="btn btn-danger" href='default.php' >Suivant</a>		
 	</footer>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/java.js"></script>
</body>
</html>