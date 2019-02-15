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
			$dom->preserveWhiteSpace = false;
			$dom->formatOutput = true;
			$dom->load('save.xml');
			$nomP = $_POST['nomPiece'];
			$piece = $dom->getElementById($nomP);

			if(isset($_POST['pointsPos'])){
				$newPositions = $_POST['pointsPos'][$nomP];
				$newTargets = $_POST['pointsTarget'][$nomP];
			}
			else{
				$newPositions = [];
				$newTargets = [];
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


			$dom->save("save.xml");


		}

	?>
	<footer>
		<div class="d-flex justify-content-center">
			<a class="btn btn-danger clickable" onClick='<?php echo "sendData(this,\"default.php?li=".$nomIm."\")"?>' >Suivant</a>
		</div>
		<div class="d-flex justify-content-center">
			<a class="btn btn-success clickable" onClick='<?php echo "sendData(this,\"ajouterMap.php?li=".$nomIm."\")"?>' >Ajouter une map</a>
		</div>		
	</footer>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/java.js"></script>
</body>
</html>