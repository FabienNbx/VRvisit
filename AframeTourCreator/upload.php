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
/*$fichier = 'download/save.xml';
$xml = simplexml_load_file($fichier);*/
$doc = new DomDocument;
// Nous devons valider notre document avant de nous référer à l'ID
$doc->validateOnParse = true;
$doc->load('download/save.xml');
//print_r($xml);
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
                echo "Seules les images sont acceptées !!</br>";
                $uploadOk = 0;
            }
        }

        if (file_exists($target_file)) {
            echo "L'image existe déjà !</br>";
            $uploadOk = 0;
        } 

        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" ) {
            echo "Seuls les formats jpg, jpeg et png sont acceptés</br>";
            $uploadOk = 0;
        }
        if(strcmp(filter_var($_GET['new'],FILTER_SANITIZE_STRING),"false")==0){
            $pieces = $doc->getElementsByTagName("piece");
            foreach($pieces as $piece){
                $t = $piece->getAttribute("xml:id");
                if($t==pathinfo($target_file)['filename']){
                    echo "L'image existe déjà dans le projet existant</br>";
                    $uploadOk = 0;
                }
            }
        }

        if ($uploadOk == 0) {
            echo "Fichier non upload !</br>";

        } else {
            if (move_uploaded_file($_FILES["filesUpload"]["tmp_name"][$i], $target_file)) // réalise l'upload.
            {
                echo "Le fichier ". basename( $_FILES["filesUpload"]["name"][$i]). " a été upload avec SUCCES</br>";
            } else {
                echo "Erreur inconnue au bataillon</br>";
            }
        }
    }
    
    echo "<form action=\"";
    if($_GET['new']=='true') echo "createXML.php";
    else if($_GET['new']=='false') echo "existant.php";
    echo "\">
          <input type=\"submit\" value=\"Suivant\" />
          </form>";
}
else{
    echo "<p>Il faut sélectionner au minimum une image ...</p>";
    echo "<form action=\"images.php?new=".$_GET['new']."\" method=\"post\">
          <input type=\"submit\" value=\"Retour\" />
          </form>";
}
?>

</body>
</html>