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
    <script src="js/gestionPIs.js"></script>
</head>

<body class="a-body">
		<a-scene >
			<a-assets>
				<script id="template" type="text/html">
					<a-entity 
					geometry="primitive: octahedron; radius: 0.5" 
					material="color: #5a92ae"
					move="on: click; target: ${target}"
					animation__scale="property: scale; from: 1 1 1; to: 1.5 2.5 1.5; loop: true; dur: 1250; dir: alternate; easing: easeInOutElastic; startEvents: mouseenter; pauseEvents: mouseleave"
					animation__rotation="property: rotation; from: 0 0 0; to: 180 360 0; loop: true; dur: 2500; easing: easeInOutElastic; startEvents: mouseenter; pauseEvents: mouseleave"animation__scaleReturn="property: scale; to: 1 1 1; dur: 500; easing: easeOutElastic; startEvents: mouseleave"
					animation__rotationReturn="property: rotation; to: 0 0 0; dur: 1000; easing: easeOutElastic; startEvents: mouseleave"
					>
						<a-text 
						value="--> ${target}\n\n\n"
						width="18"
						align="center"
						baseline="center"
						color="red"
						look-at="#camera"
						>
							
						</a-text>
					</a-entity>
				</script>
				<script id="templateUpdate" type="text/html">
					<a-entity 
					geometry="primitive: octahedron; radius: 0.5" 
					material="color: #5a92ae"
					move="on: click; target: ${target}"
					animation__scale="property: scale; from: 1 1 1; to: 1.5 2.5 1.5; loop: true; dur: 1250; dir: alternate; easing: easeInOutElastic; startEvents: mouseenter; pauseEvents: mouseleave"
					animation__rotation="property: rotation; from: 0 0 0; to: 180 360 0; loop: true; dur: 2500; easing: easeInOutElastic; startEvents: mouseenter; pauseEvents: mouseleave"animation__scaleReturn="property: scale; to: 1 1 1; dur: 500; easing: easeOutElastic; startEvents: mouseleave"
					animation__rotationReturn="property: rotation; to: 0 0 0; dur: 1000; easing: easeOutElastic; startEvents: mouseleave"
					>
					</a-entity>
				</script>
				<script id="templateHud" type="text/html">
					<a-entity 
					geometry="primitive: plane; width: 2; height: 1" material="color: #202020"
					text="align: center; wrapCount: 20; value: ${text}"
					look-at="#camera"
					>
					</a-entity>
				</script>
			</a-assets>

			<?php 
			
				$img=filter_var($_REQUEST['img'],FILTER_SANITIZE_STRING);
				$im = pathinfo($img);
				$l=filter_var($_REQUEST['li'],FILTER_SANITIZE_STRING);
				?>	

			<script> var listImgs = '<?php echo $l; ?>'; var idHud = '<?php echo "hud".$im['filename'].""; ?>'; </script>

			<?php
				echo "
						<a-sky id=\"background\"></a-sky>
						<a-entity id=\"".$im['filename']."\" class=\"imsky\" sourceimage=\"uploads/".$img."\" description=\"".$im['filename']."\" visible=\"false\" default=\"\">
				  		</a-entity>";
			?>

			<a-entity id="cameraRotation">
			<a-entity id="hudDef" class=<?php echo "\"hud".$im['filename']."\"";?> template="src: #templateHud" position="0 -2 -1" data-text=<?php echo $im['filename']; ?>
				>
			</a-entity>
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
				text="color : red; align: center; wrapCount: 20; value : - a : ajouter balise\n- r : supprimer balise\n- p : modifier panneau\n- s : sauvegarder"
				>
			</a-entity>
			</a-entity>
			</a-entity>
		</a-scene>
		<form id="pointsForm" action="accueil.php" method="POST">
			<?php 
				/*foreach ($_POST as $tableaux => $contenuTab) {
					foreach ($contenuTab as $piece => $contenu) {
						foreach ($contenu as $key) {
							echo "<input type='text' name='".$tableaux."[".$piece."][]' hidden value='".$key."'/>";
						}
					}
				}*/
				$dom = new DomDocument();
				$dom->load('download/save.xml');
				//$visit = $dom->getElementsByTagName("visit")->item(0);
				$piece = $dom->getElementById($im['filename']);
				echo "<input type='text' name='nomPiece' hidden value='".$im['filename']."'/>";
				$positions = $piece->getElementsByTagName("positions")->item(0)->getElementsByTagName("value");
				$targets = $piece->getElementsByTagName("targets")->item(0)->getElementsByTagName("value");
				$panns = $piece->getElementsByTagName("panns")->item(0)->getElementsByTagName("value");

				$nbP = $positions->count();
				for($i = 0;$i<$nbP;$i++){
					$pos = $positions->item($i)->nodeValue;
					$tar = $targets->item($i)->nodeValue;
					echo "<input type='text' name='pointsPos[".$im['filename']."][]' hidden value='".$pos."'/>";
					echo "<input type='text' name='pointsTarget[".$im['filename']."][]' hidden value='".$tar."'/>";

					echo "<script>ajouterPointInteretDebut('".$pos."','".$tar."')</script>";
				}

				foreach ($panns as $key) {
					echo "<input type='text' name='listPanns[".$im['filename']."][]' hidden value='".$key->nodeValue."'/>";
					echo "<input type='text' name='listTextPanns[".$im['filename']."][]' hidden value='".$key->getAttribute("text")."'/>";

					echo "<script>placerPannDebut('".$key->nodeValue."','".$key->getAttribute('text')."')</script>";
				}

			?>
		</form>
<!--     <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/java.js"></script> -->
</body>
</html>

