<?php

$dom = new DomDocument();
<<<<<<< HEAD
$dom->preserveWhiteSpace = false;
$dom->formatOutput = true;
$visit = $dom->createElement("visit");


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
			$piece = $dom->createElement("piece");
			$positions = $dom->createElement("positions");
			$targets = $dom->createElement("targets");
			$panns = $dom->createElement("panns");
			$piece->setAttribute("xml:id",$fic['filename']);
			//$piece->setIdAttribute("name", true);
			$piece->appendChild($positions);
			$piece->appendChild($targets);
			$piece->appendChild($panns);
			$visit->appendChild($piece);

		}
	}
}
$dom->appendChild($visit);
$dom->save('save.xml');
=======
$dom->save('save.xml');

>>>>>>> 8bf5d2ded82a132b6010906dcebb201012c38e03
header('Location: accueil.php');
?>