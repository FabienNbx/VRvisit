<?php

$dom = new DomDocument();
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
			$rotations = $dom->createElement("rotations");
			$panns = $dom->createElement("panns");
			$piece->setAttribute("xml:id",$fic['filename']);
			//$piece->setIdAttribute("name", true);
			$piece->appendChild($positions);
			$piece->appendChild($targets);
			$piece->appendChild($rotations);
			$piece->appendChild($panns);
			$visit->appendChild($piece);

		}
	}
}
else{
	header("Location: erreur.php");
}
$dom->appendChild($visit);
$dom->save('download/save.xml');
header('Location: accueil.php?new=true');
?>