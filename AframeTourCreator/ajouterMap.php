<!DOCTYPE html>
<html lang="fr">
<head>
	 <meta charset="utf-8">			
    <title>Aframe Tour Creator</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="css/ajouterMap.css" />
    <script src="js/accueil.js"></script>
</head>
<body class="bg-info">
	<?php 
        if(isset($_REQUEST['li']))
    	    $nomIm=filter_var($_REQUEST['li'],FILTER_SANITIZE_STRING); 
        else
            header('Location: erreur.php');
	?>

	<header>
       <img src="images/utils/map.png">
    </header>

    <section>
        <h2 class="text-center">Ajouter la(les) map(s)</h2>
    	<form action="uploadMap.php?new=<?php echo $_GET['new']; ?>&li=<?php echo $nomIm;?>" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <h4>Map(s) :</h4>
                <input type="file" class="form-control-file" multiple name="filesUpload[]"><br/>
                <input class="btn btn-success" type="submit" value="Upload" name="submit">
            </div>
        </form>
    </section>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/java.js"></script>
</body>
</html>