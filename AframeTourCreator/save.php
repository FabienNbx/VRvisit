<?php

$listImgs = explode(':',$_GET['li']);
if(isset($_POST['pointsPos']))
	$pointsPos = $_POST['pointsPos'];
else
	$pointsPos = [];

if(isset($_POST['pointsTarget']))
	$pointsTarget = $_POST['pointsTarget'];
else
	$pointsTarget = [];

if(isset($_POST['listPanns']))
	$panns = $_POST['listPanns'];
else
	$panns = [];

if(isset($_POST['default']))
	$def = $_POST['default'];
else
	$def = $listImgs[0];


$file = 'people.php';

$current = '<html class="a-html"><head>
	<meta charset="utf-8">
	<title>Visite</title>
    <script src="latotale.js"></script>
    <script src="360tour.js"></script>   
</head>
<body class="a-body">
	<a-scene class="fullscreen" inspector="" keyboard-shortcuts="" screenshot="" vr-mode-ui="" debug="true">
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
		</a-assets>'."\r";

foreach ($listImgs as $img) {
	$current .= "\t\t".'<a-entity id="'.$img.'" class="piece" sourceimage="uploads/'.$img.'.jpg" description="'.$img.'" visible="false" ';
	if($img==$def){
		$current .= 'default posHud="';
	}
	else{
		$current .= 'posHud="';
	}

	if(!isset($panns[$img])){
		$current .= '0 -2 -1">'."\r";
	}
	else{
		$current .= $panns[$img][0].'">'."\r";
	}
	foreach ($pointsPos as $key => $value) {
		if($key===$img){
			foreach ($value as $num => $pos) {
				$current .="\t\t\t".'<a-entity template="src:#template" data-target="'.$pointsTarget[$key][$num].'" position="'.$pos.'"></a-entity>'."\r";
			}
		}
	}
			

	$current .= "\t\t".'</a-entity>'."\r";
}

$current .= '
		<a-entity id="cameraRotation">
			<a-entity id="hud" geometry="primitive: plane; width: 2; height: 1" material="color: #202020" position="0 -2 -1" text="align: center; wrapCount: 20" look-at="#camera">
			</a-entity>
			<a-entity id="camera" camera="" look-controls="">
				<a-cursor id="cursor" scale="2 2 2" color="black" event-set__1="_event: mouseenter; color: springgreen" event-set__2="_event: mouseleave; color: black" fuse-timeout="2500" animation__scale="property: scale; from: 2 2 2; to: 0.1 0.1 0.1; dur: 2500; easing: easeInCubic; startEvents: fusing; pauseEvents: mouseleave" animation__scalereturn="property: scale; to: 2 2 2; dur: 500; easing: easeOutElastic; startEvents: mouseleave"></a-cursor>
			</a-entity>
		</a-entity>
		<a-sky id="background"></a-sky>
	</a-scene>

</body></html>
';
// Écrit le résultat dans le fichier
file_put_contents($file, $current);
header('Location: confirmation.php');