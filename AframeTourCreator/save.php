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



$dom = new DomDocument();
$dom->load('download/save.xml');
$visit = $dom->getElementsByTagName("visit")->item(0);
$pieces = $visit->getElementsByTagName("piece");
foreach ($pieces as $piece) {
	$nomP = $piece->getAttribute("xml:id");
	$pointsPos[$nomP] = [];
	$pointsTarget[$nomP] = [];
	$panns[$nomP] = [];
	$pannsText[$nomP] = [];
	$positions = $piece->getElementsByTagName("positions")->item(0)->getElementsByTagName("value");
	$targets = $piece->getElementsByTagName("targets")->item(0)->getElementsByTagName("value");
	$pannsList = $piece->getElementsByTagName("panns")->item(0)->getElementsByTagName("value");

	foreach ($positions as $value) {
		$pointsPos[$nomP][] = $value->nodeValue;
	}
	foreach ($targets as $value) {
		$pointsTarget[$nomP][] = $value->nodeValue;
	}
	foreach ($pannsList as $value) {
		$panns[$nomP][] = $value->nodeValue;
		$pannsText[$nomP][] = $value->getAttribute("text");
	}

}

if(isset($_POST['default']))
	$def = $_POST['default'];
else
	$def = $listImgs[0];


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
		</a-assets>'."\r";

foreach ($listImgs as $img) {
	$current .= "\t\t".'<a-entity id="'.$img["filename"].'" class="piece" sourceimage="imgs/'.$img['basename'].'" description="'.$img["filename"].'" visible="false" ';

	if($img['filename']==$def)
		$current .= 'default';
	$current .= '>';
	foreach ($pointsPos as $key => $value) {
		if($key===$img['filename']){
			foreach ($value as $num => $pos) {
				$current .="\t\t\t".'<a-entity template="src:#template" data-target="'.$pointsTarget[$key][$num].'" position="'.$pos.'"></a-entity>'."\r";
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

$current .= '
		<a-entity id="cameraRotation">
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





$c=count($listImgs);
for($i=0;$i<$c;$i++){
    $target_dir = "download/imgs/";
    $target_file = $target_dir . $listImgs[$i]['basename']; // nom sans extension
    if (copy("uploads/".$listImgs[$i]['basename'], $target_file)) // réalise l'upload.
    {
        echo "SUCCES</br>";
    } else {
        echo "Erreur inconnue au bataillon</br>";
    }
}



$archive_name = "visite.zip"; // name of zip file
$archive_folder = "download"; // the folder which you archivate

$zip = new ZipArchive; 
if ($zip -> open($archive_name, ZipArchive::CREATE) === TRUE) 
{ 
    $dir = preg_replace('/[\/]{2,}/', '/', $archive_folder."/"); 
    var_dump($dir);
    $dirs = array($dir); 
    echo "COUCOU<br/><br/>";
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
        echo "COUZIP<br/><br/>";
        var_dump($zip);
    } 
    
    $zip -> close(); 



    unlink('download/index.html');
    unlink('download/save.xml');
    $c=count($listImgs);
	for($i=0;$i<$c;$i++){
	    if (unlink("download/imgs/".$listImgs[$i]['basename'])) // réalise l'upload.
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