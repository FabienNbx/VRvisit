<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="utf-8">																	
	<title>Aframe Tour Creator</title>
	<script src="js/latotale.js"></script> 
    <script src="js/360tour.js"></script> 
</head>
<body class="bg-info">
<a-scene>
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
				</a-entity>
			</script>
		</a-assets>


		<?php
			$img=filter_var($_GET['img'],FILTER_SANITIZE_STRING);
			$nomI=substr($img,0,strlen($img)-4);
			$source="uploads/".$img;
		?>
		<a-sky id="background"></a-sky>	
		<a-entity default id="<?php echo $nomI;?>" class="piece" sourceimage="<?php echo $source;?>" description="<?php echo $nomI;?>" visible='false'></a-entity>
		
		<a-entity id="cameraRotation">
			<a-entity id="hud" geometry="primitive: plane; width: 2; height: 1" material="color: #202020" position="0 -2 -1"
				text="align: center; wrapCount: 20"
				look-at="#camera"
				>
			</a-entity>
			<a-entity id="retour" geometry="primitive: plane; width: 2; height: 1" material="color: #202020" position="0 -2 1"
				text="align: center; wrapCount: 15; value: p = ajouter Point     r = supprimer Point s = sauvegarder"
				look-at="#camera"
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
			</a-entity>
		</a-entity>
	</a-scene>
</body>
</html>