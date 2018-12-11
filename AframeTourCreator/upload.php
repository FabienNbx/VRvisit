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
foreach ($_FILES as $key => $value) {
    echo "<p>COUCOU000".$key."</p>";
}
$c=count($_FILES["directoryToUpload"]["name"]);
echo"<p>COUCOU</p>";
for($i=0;$i<$c;$i++){
    echo"<p>COUCOU</p>";
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["directoryToUpload"]["name"][$i]); // nom sans extension
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    // extension de l'image
    if(isset($_POST["submit"])) {
        $check = getimagesize($_FILES["directoryToUpload"]["tmp_name"][$i]); //retourne false si ce n'est pas une image
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

    if ($uploadOk == 0) {
        echo "Fichier non upload !</br>";

    } else {
        echo"<p>COUCOU</p>";
        if (move_uploaded_file($_FILES["directoryToUpload"]["tmp_name"][$i], $target_file)) // réalise l'upload.
        {
            echo "Le fichier ". basename( $_FILES["directoryToUpload"]["name"][$i]). " a été upload avec SUCCES</br>";
        } else {
            echo "Erreur inconnue au bataillon</br>";
        }
    }
}
?>

<form action="accueil.php">
    <input type="submit" value="Terminer" />
</form>

</body>
</html>