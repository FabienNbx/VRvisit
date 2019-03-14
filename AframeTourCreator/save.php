<?php

$listImgs = [];

if($dossier = opendir('./uploads')){
	while(false !== ($fichier = readdir($dossier)))
	{
		$fic=pathinfo($fichier);
		$ext=strtolower($fic['extension']);
		if($fichier != '.' && $fichier != '..' && ($ext=="png" || $ext=="jpg" || $ext=="jpeg"))
		{
			$listImgs[]=$fic;
		}
	}
}

$listMaps = [];

if($dossier = opendir('./maps')){
	while(false !== ($fichier = readdir($dossier)))
	{
		$fic=pathinfo($fichier);
		$ext=strtolower($fic['extension']);
		if($fichier != '.' && $fichier != '..' && ($ext=="png" || $ext=="jpg" || $ext=="jpeg"))
		{
			$listMaps[]=$fic;
		}
	}
}



$dom = new DomDocument();
if(!$dom->load('download/save.xml'))
	header('Location: erreur.php');
$visit = $dom->getElementsByTagName("visit")->item(0);
$pieces = $visit->getElementsByTagName("piece");
$maps = $visit->getElementsByTagName("map");
foreach ($pieces as $piece) {
	$nomP = $piece->getAttribute("xml:id");
	$pointsPos[$nomP] = [];
	$pointsTarget[$nomP] = [];
	$pointsRot[$nomP] = [];
	$panns[$nomP] = [];
	$pannsText[$nomP] = [];
	$positions = $piece->getElementsByTagName("positions")->item(0)->getElementsByTagName("value");
	$targets = $piece->getElementsByTagName("targets")->item(0)->getElementsByTagName("value");
	$rotations = $piece->getElementsByTagName("rotations")->item(0)->getElementsByTagName("value");
	$pannsList = $piece->getElementsByTagName("panns")->item(0)->getElementsByTagName("value");

	foreach ($positions as $value) {
		$pointsPos[$nomP][] = $value->nodeValue;
	}
	foreach ($targets as $value) {
		$pointsTarget[$nomP][] = $value->nodeValue;
	}
	foreach ($rotations as $value) {
		$pointsRot[$nomP][] = $value->nodeValue;
	}
	foreach ($pannsList as $value) {
		$panns[$nomP][] = $value->nodeValue;
		$pannsText[$nomP][] = $value->getAttribute("text");
	}

}

foreach ($maps as $map) {
	$nomM = $map->getAttribute("xml:id");
	$pointsPos[$nomM] = [];
	$pointsTarget[$nomM] = [];
	$positions = $map->getElementsByTagName("positions")->item(0)->getElementsByTagName("value");
	$targets = $map->getElementsByTagName("targets")->item(0)->getElementsByTagName("value");


	foreach ($positions as $value) {
		$pointsPos[$nomM][] = $value->nodeValue;
	}
	foreach ($targets as $value) {
		$pointsTarget[$nomM][] = $value->nodeValue;
	}

}

if(isset($_POST['default']))
	$def = $_POST['default'];
else
	$def = $listImgs[0]['filename'];

if(isset($_POST['defaultMap']))
	$defMap = $_POST['defaultMap'];
else
	$defMap = $listMaps[0]['filename'];


$file = 'download/index.html';

$current = '<html class="a-html"><head>
	<meta charset="utf-8">
	<title>Visite</title>
    <script src="latotale.js"></script>
    <script src="360tour.js"></script>   
</head>
<body class="a-body">
	<a-scene class="fullscreen" inspector="" keyboard-shortcuts="" screenshot="" vr-mode-ui="">
		<a-assets>
			<script id="template" type="text/html">
				<a-entity 
				template="src: #templateArrow"
				rotation="${childrotation}"
				material="color: #5a92ae"
				move="on: click; target: ${target}"
				animation__scale="property: scale; from: 1 1 1; to: 1.25 1.25 2; loop: true; dur: 1250; dir: alternate; startEvents: mouseenter; pauseEvents: mouseleave"
				animation__scaleReturn="property: scale; to: 1 1 1; dur: 500; easing: easeOutElastic; startEvents: mouseleave"
				>
				</a-entity>
			</script>
			<script id="templateArrow" type="text/html">
				<a-entity scale="0.5 0.5 0.5""
					>
					<a-entity
						geometry="primitive: cylinder; radius: 0.5; height: 2"
						material="transparent: true; opacity: 0.6; color: white"
						rotation="90 0 0"
					>
					</a-entity>
					<a-entity
						geometry="primitive: cone; height: 2"
						material="transparent: true; opacity: 0.75; color: white"
						position="0 0 -2"
						rotation="-90 0 0"
					>
					</a-entity>
				</a-entity>
			</script>
			<script id="templateMap" type="text/html">
				<a-entity 
				geometry="primitive: plane; height: 1; width: 1" 
				material="color: #202020"
				move="on: click; target: ${target}"
				look-at="#camera"
				text="align: center; wrapCount: 10; value: ${target}"
			    animation__scale="property: scale; from: 1 1 1; to: 1.5 1.5 1; dur: 750; dir: alternate; easing: easeInOutElastic; startEvents: mouseenter; pauseEvents: mouseleave"animation__scaleReturn="property: scale; to: 1 1 1; dur: 500; easing: easeOutElastic; startEvents: mouseleave"
				>
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
			<script id="templateHud" type="text/html">
					<a-entity 
					geometry="primitive: plane; width: 2; height: 1" material="color: #202020"
					text="align: center; wrapCount: 20; value: ${text}"
					look-at="#camera"
					>
					</a-entity>
				</script>
		</a-assets>'."\r";

foreach ($listImgs as $img) {
	$current .= "\t\t".'<a-entity id="'.$img["filename"].'" class="piece" sourceimage="imgs/'.$img['basename'].'" description="'.$img["filename"].'" visible="false" ';

	if($img['filename']==$def)
		$current .= 'default';
	$current .= '>';
	foreach ($pointsPos as $key => $value) {
		if($key===$img['filename']){
			foreach ($value as $num => $pos) {
				$current .="\t\t\t".'<a-entity template="src:#template" data-target="'.$pointsTarget[$key][$num].'" position="'.$pos.'" data-childrotation ="'.$pointsRot[$key][$num].'"></a-entity>'."\r";
			}
		}
	}
	foreach ($panns as $key => $value) {
		if($key===$img['filename']){
			foreach ($value as $num => $pos) {
				$current .="\t\t\t".'<a-entity class="hud'.$key.'" template="src:#templateHud" position="'.$pos.'" data-text="'.$pannsText[$key][$num].'"></a-entity>'."\r";
			}
		}
	}
			

	$current .= "\t\t".'</a-entity>'."\r";
}




foreach ($listMaps as $map) {
	$current .= "\t\t".'<a-entity id="'.$map["filename"].'" class="piece map" sourceimage="imgs/'.$map['basename'].'" visible="false" ';

	if($map['filename']==$defMap)
		$current .= 'defaultmap';
	$current .= '>';
	foreach ($pointsPos as $key => $value) {
		if($key===$map['filename']){
			foreach ($value as $num => $pos) {
				$current .="\t\t\t".'<a-entity template="src:#templateMap" data-target="'.$pointsTarget[$key][$num].'" position="'.$pos.'"></a-entity>'."\r";
			}
		}
	}
			

	$current .= "\t\t".'</a-entity>'."\r";
}



$current .= '

		<a-entity id="mapButton" geometry="primitive: plane; width: 1; height: 1" material="src: imgs/map_icon.png" position="0 -2 0" text="align: center; wrapCount: 20" look-at="#camera" animation__scale="property: scale; from: 1 1 1; to: 1.5 1.5 1; dur: 750; dir: alternate; easing: easeInOutElastic; startEvents: mouseenter; pauseEvents: mouseleave" animation__scalereturn="property: scale; to: 1 1 1; dur: 500; easing: easeOutElastic; startEvents: mouseleave" movetomap="on: click">
		</a-entity>

		<a-entity id="cameraRotation">
			<a-entity id="camera" camera="" look-controls="">
				<a-cursor class="cursor active" scale="2 2 2" color="black" event-set__1="_event: mouseenter; color: springgreen" event-set__2="_event: mouseleave; color: black" fuse-timeout="2500" animation__scale="property: scale; from: 2 2 2; to: 0.1 0.1 0.1; dur: 2500; easing: easeInCubic; startEvents: fusing; pauseEvents: mouseleave" animation__scalereturn="property: scale; to: 2 2 2; dur: 500; easing: easeOutElastic; startEvents: mouseleave"></a-cursor>
			</a-entity>
		</a-entity>

		<a-entity class="cursor" laser-controls="hand: right" daydream-controls="" gearvr-controls="" oculus-touch-controls="" vive-controls="" windows-motion-controls="">
        </a-entity>
		<a-sky id="background"></a-sky>
	</a-scene>

</body></html>
';

file_put_contents($file, $current);





$c=count($listImgs);
for($i=0;$i<$c;$i++){
    $target_dir = "download/imgs/";
    $target_file = $target_dir . $listImgs[$i]['basename'];
    if (copy("uploads/".$listImgs[$i]['basename'], $target_file)) 
    {
        echo "SUCCES</br>";
    } else {
        echo "Erreur inconnue au bataillon</br>";
    }
}

$c=count($listMaps);
for($i=0;$i<$c;$i++){
    $target_dir = "download/imgs/";
    $target_file = $target_dir . $listMaps[$i]['basename'];
    if (copy("maps/".$listMaps[$i]['basename'], $target_file)) 
    {
        echo "SUCCES</br>";
    } else {
        echo "Erreur inconnue au bataillon</br>";
    }
}

if (copy("map_icon.png", "download/imgs/map_icon.png") )
{
    echo "SUCCES</br>";
} else {
    echo "Erreur inconnue au bataillon</br>";
}

if(file_exists('visite.zip'))
	unlink('visite.zip');

$archive_name = "visite.zip";
$archive_folder = "download";

$zip = new ZipArchive; 
if ($zip -> open($archive_name, ZipArchive::CREATE) === TRUE) 
{ 
    $dir = preg_replace('/[\/]{2,}/', '/', $archive_folder."/"); 
    var_dump($dir);
    $dirs = array($dir); 
    var_dump($dirs);

    while (count($dirs)) 
    { 
        $dir = current($dirs); 
        $zip -> addEmptyDir($dir); 
        
        $dh = opendir($dir); 
        while($file = readdir($dh)) 
        { 
            if ($file != '.' && $file != '..') 
            { 
                if (is_file($dir.$file)) {
                    $zip -> addFile($dir.$file, $dir.$file); 
                }
                elseif (is_dir($dir.$file)) {
                    $dirs[] = $dir.$file."/";
                }
            } 
        } 
        closedir($dh); 
        array_shift($dirs); 
        var_dump($zip);
    } 
    
    $zip -> close(); 



    unlink('download/index.html');
    unlink('download/save.xml');
    $c=count($listImgs);
	for($i=0;$i<$c;$i++){
	    if (unlink("download/imgs/".$listImgs[$i]['basename']))
	    {
	        echo "SUCCES</br>";
	    } else {
	        echo "Erreur inconnue au bataillon</br>";
	    }
	    if (unlink("uploads/".$listImgs[$i]['basename']))
	    {
	        echo "SUCCES</br>";
	    } else {
	        echo "Erreur inconnue au bataillon</br>";
	    }
	}
	$c=count($listMaps);
	for($i=0;$i<$c;$i++){
	    if (unlink("download/imgs/".$listMaps[$i]['basename']))
	    {
	        echo "SUCCES</br>";
	    } else {
	        echo "Erreur inconnue au bataillon</br>";
	    }
	    if (unlink("maps/".$listMaps[$i]['basename']))
	    {
	        echo "SUCCES</br>";
	    } else {
	        echo "Erreur inconnue au bataillon</br>";
	    }
	}
	
	header('Location: confirmation.php');
} 
else 
{ 
    echo 'Error, can\'t create a zip file!'; 
} 