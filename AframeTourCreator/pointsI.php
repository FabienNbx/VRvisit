<!DOCTYPE html>
<html lang="fr">
<head>
	 <meta charset="utf-8">																						
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Aframe Tour Creator</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="css/accueil.css" />
</head>
<body class="bg-info">
	<div><h1>Image : </h1></div>
	<section id="listeImg" class="text-center">
		<?php 
			$img=filter_var($_GET['img'],FILTER_SANITIZE_STRING);
			echo "<h3>".$img."</h3>";
			echo "<img class='photoSeule' src='uploads/".$img."'></img>";
		?>
	</section>
	<footer>

	</footer>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/java.js"></script>
</body>
</html>

