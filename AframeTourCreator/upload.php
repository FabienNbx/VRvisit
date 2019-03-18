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
if(strcmp(filter_var($_GET['new'],FILTER_SANITIZE_STRING),"false")==0 || isset($_GET['ajout'])){
    $doc = new DomDocument;
    $doc->validateOnParse = true;
    $doc->preserveWhiteSpace = false;
    $doc->formatOutput = true;
    if(!$doc->load('download/save.xml'))
        header("Location: erreur.php");
    $visit=$doc->getElementsByTagName("visit")[0];
}
if(strcmp($_FILES["filesUpload"]["name"][0], "")!=0){
    $c=count($_FILES["filesUpload"]["name"]);
    for($i=0;$i<$c;$i++){
        $target_dir = "uploads/";
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

        if(strcmp(filter_var($_GET['new'],FILTER_SANITIZE_STRING),"false")==0 && !isset($_GET['ajout'])){
            $test = 1;
            $pieces = $doc->getElementsByTagName("piece");
            foreach($pieces as $piece){
                $t = $piece->getAttribute("xml:id");
                if($t==pathinfo($target_file)['filename']){
                    $test=0;
                    break;
                }
            }
            if($test==1){
                $piece = $doc->createElement("piece");
                $positions = $doc->createElement("positions");
                $targets = $doc->createElement("targets");
                $rotations = $doc->createElement("rotations");
                $panns = $doc->createElement("panns");
                $piece->setAttribute("xml:id",pathinfo($target_file)['filename']);
                $piece->appendChild($positions);
                $piece->appendChild($targets);
                $piece->appendChild($rotations);
                $piece->appendChild($panns);
                $visit->appendChild($piece);
                echo "Photo add to xml<br/>"; 
            }
        }

        if ($uploadOk == 0) {
            echo "File not uploaded !</br>";

        }

        else {
            if (move_uploaded_file($_FILES["filesUpload"]["tmp_name"][$i], $target_file)) // réalise l'upload.
            {
                echo "File ". basename( $_FILES["filesUpload"]["name"][$i]). " uploaded successfully</br>";
                if(isset($_GET['ajout'])){
                    $piece = $doc->createElement("piece");
                    $positions = $doc->createElement("positions");
                    $targets = $doc->createElement("targets");
                    $rotations = $doc->createElement("rotations");
                    $panns = $doc->createElement("panns");
                    $piece->setAttribute("xml:id",pathinfo($target_file)['filename']);
                    $piece->appendChild($positions);
                    $piece->appendChild($targets);
                    $piece->appendChild($rotations);
                    $piece->appendChild($panns);
                    $visit->appendChild($piece);
                }
            }
            else {
                echo "Unknown error ...</br>";
            }
        }
    }
    if(!isset($_GET['ajout'])){
        if(strcmp(filter_var($_GET['new'],FILTER_SANITIZE_STRING),"false")==0){
            $tab=array();
            $pieces = $doc->getElementsByTagName("piece");
            foreach($pieces as $piece){
                $t = $piece->getAttribute("xml:id");
                array_push($tab, $t);
            }
            if($dossier = opendir('./uploads'))
            {
                while(false !== ($fichier = readdir($dossier)))
                {
                    $fic=pathinfo($fichier);
                    $ext=strtolower($fic['extension']);
                    $nom=$fic['filename'];
                    if($fichier != '.' && $fichier != '..' && ($ext=="png" || $ext=="jpg" || $ext=="jpeg"))
                    {
                        if (($key = array_search($nom, $tab)) !== false) {
                            unset($tab[$key]);
                        }
                    }
                }
            }
            $test=1;
            if(!empty($tab)){
                echo "Impossible to continue, missing images ...<br/>
                    The following images are missing:<br/>";
                foreach ($tab as $key => $value) {
                    echo $value."<br/>";
                }

                $test=0;
            }
            if ($test==1){
                $doc->save('download/save.xml');
                echo "<form method=\"post\" action=\"accueil.php?new=".$_GET['new']."\">
                <input class=\"btn btn-success\" type=\"submit\" value=\"Next\" />
                </form>";
            }
        }
        else{
            echo "<form method=\"post\" action=\"createXML.php?new=".$_GET['new']."\">
            <input class=\"btn btn-primary\" type=\"submit\" value=\"Next\" />
            </form>";
        }
    }
    else{
        $doc->save('download/save.xml');
        echo "<form method=\"post\" action=\"accueil.php?new=".$_GET['new']."\">
            <input class=\"btn btn-success\" type=\"submit\" value=\"Next\" />
            </form>";
    }
}
else{
    echo "<p>Il faut sélectionner au minimum une image ...</p>";
}
echo "<form class=\"double\" action=\"images.php?new=".$_GET['new']."\" method=\"post\">
      <input class=\"btn btn-primary\" type=\"submit\" value=\"Back\" />
      </form>";
?>

</body>
</html>