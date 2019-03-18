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
        echo "Only xml files are accepted</br>";
        $parseOK = 0;
    }
    if ($parseOK == 0) {
        echo "Incorrect file !</br>";
    }
    else {
      if (move_uploaded_file($_FILES["fileUpload"]["tmp_name"], $target_file)) // réalise l'upload.
        {
            echo "Import completed</br>";
        } 
        else {
            echo "Unknown error</br>";
        }
    }
    if($parseOK==1){
        echo "<form action=\"images.php?new=false\" method=\"post\">
          <input class=\"btn btn-success\" type=\"submit\" value=\"End\" />
          </form>";
    }
}
else{
    echo "<p>You must select a file</p>";
}
echo "<form class=\"double\" action=\"existant.php\">
      <input class=\"btn btn-primary\" type=\"submit\" value=\"Return\" />
      </form>";
?>

</body>
</html>