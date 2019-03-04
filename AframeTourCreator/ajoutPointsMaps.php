<!DOCTYPE html>
<html lang="fr">
<head>
	 <meta charset="utf-8">																						
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Aframe Tour Creator</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="css/accueil.css" />
    <script src="js/latotale.js"></script>
    <script src="js/gestionMap.js"></script>
</head>

<body class="a-body">
		<a-scene >
			<a-assets>
				<script id="template" type="text/html">
					<a-entity 
						geometry="primitive: plane; height: 1; width: 1" 
						material="color: #202020"
						move="on: click; target: ${target}"
						look-at="#camera"
						text="align: center; wrapCount: 10; value: ${target}"
					    animation__scale="property: scale; from: 1 1 1; to: 1.5 1.5 1; dur: 750; dir: alternate; easing: easeInOutElastic; startEvents: mouseenter; pauseEvents: mouseleave"animation__scaleReturn="property: scale; to: 1 1 1; dur: 500; easing: easeOutElastic; startEvents: mouseleave"
						>
						</a-entity>
					</a-entity>
				</script>
				<script id="templateMapIcon" type="text/html">
					<a-entity
						display-label="${target}"
						geometry="primitive: sphere; radius: 0.5" 
						material="color: #202020"
						position="0 0 -3"
						animation__scale="property: scale; from: 1 1 1; to: 1.5 1.5 1.5; dur: 750; dir: alternate; easing: easeInOutElastic; startEvents: mouseenter; pauseEvents: mouseleave"
						animation__scaleReturn="property: scale; to: 1 1 1; dur: 500; easing: easeOutElastic; startEvents: mouseleave"
					>
					</a-entity>
					<a-entity
						display-label="${target}"
						geometry="primitive: sphere; radius: 1"
						material="color: #5a92ae"
						movetothismap="on: click; target: ${target}"
						animation__scale="property: scale; from: 1 1 1; to: 1.5 1.5 1.5; dur: 750; dir: alternate; easing: easeInOutElastic; startEvents: mouseenter; pauseEvents: mouseleave"
						animation__scaleReturn="property: scale; to: 1 1 1; dur: 500; easing: easeOutElastic; startEvents: mouseleave"
					>
					</a-entity>
				</script>
			</a-assets>

			<?php 
				if(!isset($_REQUEST['img']) || !isset($_REQUEST['li']))
					header('Location: erreur.php');
				$img=filter_var($_REQUEST['img'],FILTER_SANITIZE_STRING);
				$im = pathinfo($img);
				$l=filter_var($_REQUEST['li'],FILTER_SANITIZE_STRING);
				?>				
					<script> var listImgs = '<?php echo $l; ?>'; </script>
					<?php			
				echo "
						<a-sky id=\"background\"></a-sky>
						<a-entity id=\"".$im['filename']."\" class=\"imsky\" sourceimage=\"maps/".$img."\" description=\"".$im['filename']."\" visible=\"false\" default=\"\">
				  		</a-entity>";
			?>

			<a-entity id="cameraRotation">
			<a-entity id="camera" camera look-controls>
				<a-cursor id="cursor"
						scale="2 2 2"
						color="black"
					  	event-set__1="_event: mouseenter; color: springgreen"
					  	event-set__2="_event: mouseleave; color: black"
					  	fuse-timeout=2500
					  	animation__scale="property: scale; from: 2 2 2; to: 0.1 0.1 0.1; dur: 2500; easing: easeInCubic; startEvents: fusing; pauseEvents: mouseleave"
					  	animation__scaleReturn="property: scale; to: 2 2 2; dur: 500; easing: easeOutElastic; startEvents: mouseleave"
				></a-cursor>
				<a-entity geometry="primitive: plane; width: 2; height: 1" material="color: #202020; opacity : 0.7" position="0 2.9 -4"
				text="color : red; align: center; wrapCount: 20; value : - a : ajouter balise\n- r : supprimer balise\n- s : sauvegarder"
				>
			</a-entity>
			</a-entity>
			</a-entity>
		</a-scene>
		<form id="pointsForm" action="accueilMap.php?li=<?php echo $l; ?>" method="POST">
			<?php 
				$dom = new DomDocument();
				if(!$dom->load('download/save.xml'))
					header("Location: erreur.php");
				$map = $dom->getElementById($im['filename']);
				echo "<input type='text' name='nomMap' hidden value='".$im['filename']."'/>";
				$positions = $map->getElementsByTagName("positions")->item(0)->getElementsByTagName("value");
				$targets = $map->getElementsByTagName("targets")->item(0)->getElementsByTagName("value");

				$nbP = $positions->count();
				for($i = 0;$i<$nbP;$i++){
					$pos = $positions->item($i)->nodeValue;
					$tar = $targets->item($i)->nodeValue;
					echo "<input type='text' name='pointsPos[".$im['filename']."][]' hidden value='".$pos."'/>";
					echo "<input type='text' name='pointsTarget[".$im['filename']."][]' hidden value='".$tar."'/>";

					echo "<script>ajouterPointInteretDebut('".$pos."','".$tar."')</script>";
				}

			?>
		</form>
</body>
</html>

