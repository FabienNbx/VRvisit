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
<body onload="load()">
<?php
var_dump($_FILES);
if(strcmp($_FILES["fileUpload"]["name"], "")!=0){
    $target_dir = "uploads/";
    $target_file = $target_dir . $_FILES["fileUpload"]["name"];
    $parseOK = 1;
    $imageFileType = strtolower(pathinfo($_FILES["fileUpload"]["name"],PATHINFO_EXTENSION));
    if($imageFileType != "php" && $imageFileType != "html") {
        echo "Seuls les fichiers php et html sont acceptés</br>";
        $parseOK = 0;
    }

    if ($parseOK == 0) {
        echo "Fichier incorrect !</br>";
    } else {
        if (move_uploaded_file($_FILES["fileUpload"]["tmp_name"], $target_file)) // réalise l'upload.
        {
            echo "Importation du fichier effectué</br>";
            //$s = file_get_contents("index.html");
            //var_dump($s);


/*          $ch = curl_init("http://buzut.fr/extraire-des-informations-du-dom-en-php/");
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
            $raw = curl_exec($ch);
            curl_close($ch);*/

            /*$html = new DOMDocument();
            $html->loadHTMLFile("index.html");
            /*$xpath = new DOMXPath($html);
            $domExemple = $xpath->query("//body");
            $domExemple = $html->getElementsByTagName('a-sky');
            $i = 0;
            echo "COUCOU";
            foreach ($domExemple as $exemple) {
                var_dump($exemple);
                echo $exemple->getAttribute('id');
                //$result[$i++] = $exemple->nodeValue;
                //echo $exemple->nodeValue;
            }*/
        } else {
            echo "Erreur inconnue au bataillon</br>";
        }
    }
    echo "<form action=\"accueil.php\">
          <input type=\"submit\" value=\"Terminer\" />
          </form>";
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