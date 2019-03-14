<?php
$doc = new DomDocument;
$doc->validateOnParse = true;
if(!$doc->load('download/save.xml'))
    header("Location: erreur.php");
$visit = $doc->getElementsByTagName("visit")[0];

$supps = $_REQUEST['supp'];
foreach ($supps as $value) {
	$visit->removeChild($doc->getElementById($value));
}


if($dossier = opendir('./uploads')){
	while(false !== ($fichier = readdir($dossier)))
	{
		$fic=pathinfo($fichier);
		$ext=strtolower($fic['extension']);
		if($fichier != '.' && $fichier != '..' && ($ext=="png" || $ext=="jpg" || $ext=="jpeg"))
		{
			if(in_array($fic['filename'],$supps)){
				unlink("uploads/".$fic['basename']);
			}
		}
	}
}

$doc->save("download/save.xml");

header("Location: accueil.php?new=".filter_var($_GET['new']));