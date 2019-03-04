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
<body >
<?php
if(strcmp($_FILES["fileUpload"]["name"], "")!=0){
    $target_dir = "download/";
    $target_file = $target_dir . $_FILES["fileUpload"]["name"];
    $parseOK = 1;
    $imageFileType = strtolower(pathinfo($_FILES["fileUpload"]["name"],PATHINFO_EXTENSION));
    if($imageFileType != "xml") {
        echo "Seuls les fichiers xml sont acceptés</br>";
        $parseOK = 0;
    }
    if ($parseOK == 0) {
        echo "Fichier incorrect !</br>";
    }
    else {
      if (move_uploaded_file($_FILES["fileUpload"]["tmp_name"], $target_file)) // réalise l'upload.
        {
            echo "Importation du fichier effectué</br>";
        } 
        else {
            echo "Erreur inconnue au bataillon</br>";
        }
    }
    if($parseOK==1){
        echo "<form action=\"images.php?new=false\" method=\"post\">
          <input type=\"submit\" value=\"Terminer\" />
          </form>";
    }
    else{
        echo "<form action=\"existant.php\">
          <input type=\"submit\" value=\"Retour\" />
          </form>";
    }
}
else{
    echo "<p>Il faut sélectionner un fichier ...</p>";
    echo "<form action=\"existant.php\">
          <input type=\"submit\" value=\"Retour\" />
          </form>";
}
?>

</body>
</html>