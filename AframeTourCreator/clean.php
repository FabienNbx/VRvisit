<?php 

$listImgs = [];

if($dossier = opendir('./uploads')){
	while(false !== ($fichier = readdir($dossier)))
	{
		$fic=pathinfo($fichier);
		$ext=strtolower($fic['extension']);
		if($fichier != '.' && $fichier != '..' && ($ext=="png" || $ext=="jpg" || $ext=="jpeg"))
		{
			$listImgs[]=$fic;
		}
	}
}

$listMaps = [];

if($dossier = opendir('./maps')){
	while(false !== ($fichier = readdir($dossier)))
	{
		$fic=pathinfo($fichier);
		$ext=strtolower($fic['extension']);
		if($fichier != '.' && $fichier != '..' && ($ext=="png" || $ext=="jpg" || $ext=="jpeg"))
		{
			$listMaps[]=$fic;
		}
	}
}

if(file_exists('download/save.xml'))
	unlink('download/save.xml');
$c=count($listImgs);
for($i=0;$i<$c;$i++){
    if (unlink("uploads/".$listImgs[$i]['basename']))
    {
        echo "SUCCES</br>";
    } else {
        echo "Erreur inconnue au bataillon</br>";
    }
}
$c=count($listMaps);
for($i=0;$i<$c;$i++){
    if (unlink("maps/".$listMaps[$i]['basename']))
    {
        echo "SUCCES</br>";
    } else {
        echo "Erreur inconnue au bataillon</br>";
    }
}

header("Location: index.php");