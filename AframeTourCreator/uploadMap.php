<!DOCTYPE html>
<html lang="fr">
<head>
     <meta charset="utf-8">                                                                                     
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Aframe Tour Creator</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="css/tourCreator.css" />
</head>
<body>
<?php
$nomIm = filter_var($_REQUEST['li'],FILTER_SANITIZE_STRING);
if(strcmp($_FILES["filesUpload"]["name"][0], "")!=0){
    $c=count($_FILES["filesUpload"]["name"]);
    for($i=0;$i<$c;$i++){
        $target_dir = "maps/";
        $target_file = $target_dir . basename($_FILES["filesUpload"]["name"][$i]); // nom sans extension
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        // extension de l'image
        if(isset($_POST["submit"])) {
            $check = getimagesize($_FILES["filesUpload"]["tmp_name"][$i]); //retourne false si ce n'est pas une image
            if($check !== false) {
                $uploadOk = 1;
            } else {
                echo "Only photos are accepted !!</br>";
                $uploadOk = 0;
            }
        }

        if (file_exists($target_file)) {
            echo "Photo still exist !</br>";
            $uploadOk = 0;
        } 

           if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" ) {
            echo "Only jpg, jpeg and png format are accepted</br>";
            $uploadOk = 0;
        }
        
        $tabImgs=explode(":",$nomIm);
        if(in_array(pathinfo($target_file)['filename'], $tabImgs)){
            echo "This map is a room !</br>";
            $uploadOk = 0;
        }

        if ($uploadOk == 0) {
            echo "Fichier non upload !</br>";

        } else {
            if (move_uploaded_file($_FILES["filesUpload"]["tmp_name"][$i], $target_file)) // réalise l'upload.
            {
                echo "File ". basename( $_FILES["filesUpload"]["name"][$i]). " uploaded with success</br>";

            } else {
                echo "Unknown Error</br>";
            }
        }
    }
    
    $dom = new DomDocument();
    $dom->preserveWhiteSpace = false;
    $dom->formatOutput = true;
    if(!$dom->load("download/save.xml"))
        header('Location: erreur.php');
    $visit = $dom->getElementsByTagName("visit")->item(0);
    if($dossier = opendir('./maps')){
        while(false !== ($fichier = readdir($dossier)))
        {
            $fic=pathinfo($fichier);
            $ext=strtolower($fic['extension']);
            if($fichier != '.' && $fichier != '..' && ($ext=="png" || $ext=="jpg" || $ext=="jpeg"))
            {
                $test=1;
                $maps = $dom->getElementsByTagName("map");
                foreach($maps as $map){
                    $t = $map->getAttribute("xml:id");
                    if($t==$fic['filename']){
                        $test=0;
                        break;
                    }
                }
                if($test==1){
                    $map = $dom->createElement("map");
                    $positions = $dom->createElement("positions");
                    $targets = $dom->createElement("targets");
                    $map->setAttribute("xml:id",$fic['filename']);
                    $map->appendChild($positions);
                    $map->appendChild($targets);
                    $visit->appendChild($map);
                }
            }
        }
    }
    $dom->save('download/save.xml');
    echo "<form action=\"accueilMap.php?new=".$_GET['new']."&li=".$nomIm."\" method=\"post\"><input class=\"btn btn-success\" type=\"submit\" value=\"Next\" /></form>";
}
else{
    echo "<p>You must select a map...</p>";
}
echo "
      <form class=\"double\" action=\"ajouterMap.php?new=".$_GET['new']."&li=".$nomIm."\" method=\"post\">
      <input class=\"btn btn-primary\" type=\"submit\" value=\"Return\" />
      </form>";
?>

</body>
</html>