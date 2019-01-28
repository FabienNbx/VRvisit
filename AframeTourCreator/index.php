<!DOCTYPE html>
<html lang="fr">
<head>
	 <meta charset="utf-8">																						
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Aframe Tour Creator</title>
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/bootstrap-reboot.css" rel="stylesheet">
    <link href="css/bootstrap-theme.css" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="css/tourCreator.css" />
    <script type="text/javascript" src="js/gestionImages.js"></script>
</head>
<body>
    <header>
        <img src="images/utils/fondecran.png">
    </header>
    <section>
        <h2 class="text-center">Ajouter les photos</h2>
    	<form action="upload.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <h4>Répertoire contenant toutes les images :</h4>
                <input type="file" class="form-control-file" multiple name="filesUpload[]"><br/>
                <input class="btn btn-success" type="submit" value="Upload" name="submit">
            </div>
        </form>
    </section>
</body>
</html>

