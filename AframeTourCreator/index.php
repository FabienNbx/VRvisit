<!DOCTYPE html>
<html lang="fr">
<head>
	 <meta charset="utf-8">																											<!--MODIFIER ALIGNEMENT COLONNES DANS TOUS (doc GRID à partir de offseting)-->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Aframe Tour Creator</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="tourCreator.css" />
</head>
<body>
	<div><h1>Voici la liste des photos de votre tour 360° :</h1></div>
	<section id="listeImg">
	<?php
		$tab=array();
		$tab[]="salon";
		$tab["salon"]="images/salon.jpg";
		$tab[]="salledebain";
		$tab["salledebain"]="images/salledebain.jpg";
		foreach($tab as $t => $url){
			echo "
			<div class="container-fluid">
				<p>$t</p>
				<img src="$url" alt="Désolé notre image a rencontré des problèmes">
			</div>			
			"		
		}
	?>
	</section>
	<footer>
	<div class="container-fluid">
		<button class="btn btn-primary">
			<img class="imgBtn" src="images/ajout.jpeg" alt="Désolé notre image a rencontré des problèmes">
		</button>

		<button class="btn btn-success">
			<img class="imgBtn" src="images/validation.png" alt="Désolé notre image a rencontré des problèmes">
		</button>
	</div>	
	</footer>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/java.js"></script>
</body>
</html>