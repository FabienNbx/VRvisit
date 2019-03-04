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
    <header>
        <img src="images/utils/fondecran.png">
    </header>
    <section>
        <h2 class="text-center">Récupération de l'ancien tour</h2>
    	<form action="uploadExist.php?new=<?php echo filter_var($_GET['new'],FILTER_SANITIZE_STRING);?>" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <h4>Fichier xml du tour :</h4>
                <input type="file" class="form-control-file" name="fileUpload"><br/>
                <input class="btn btn-success" type="submit" value="Upload" name="submit">
            </div>
        </form>
    </section>
</body>
</html>