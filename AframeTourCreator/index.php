<!DOCTYPE html>
<html lang="fr">
<head>
	 <meta charset="utf-8">																						
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Aframe Tour Creator</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="css/tourCreator.css" />
    <script type="text/javascript" src="js/gestionImages.js"></script>
</head>
<body>
	<form action="upload.php" method="post" enctype="multipart/form-data">
    Répertoire contenant toutes les images :
    <input type="file" webkitdirectory  name="directoryToUpload[]" id="directoryToUpload">
    <input type="submit" value="Upload Images" name="submit">
</form>
</body>
</html>

