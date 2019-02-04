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

$file = 'people.php';
// Ouvre un fichier pour lire un contenu existant
// Ajoute une personne
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
		</a-assets>';

foreach ($listImgs as $img) {
	$current .= '<a-entity id="'.$img.'" class="piece" sourceimage="uploads/'.$img.'.jpg" description="'.$img.'" visible="false" posHud="';
	if(count($panns)==0){
		$current .= '0 -2 -1">';
	}
	else{
		$current .= $panns[$img][0].'">';
	}
	foreach ($pointsPos as $key => $value) {
		if($key===$img){
			foreach ($value as $num => $pos) {
				$current .='<a-entity template="src:#template" data-target="'.$pointsTarget[$key][$num].'" position="'.$pos.'"></a-entity>';
			}
		}
	}
			

	$current .= '</a-entity>';
}

		/*<a-entity id="A12" class="piece" sourceimage="img/A12.jpg" description="A12" visible="false">
			<a-entity template="src:#template" data-target="couloirA12" position="-4.973415047748672 0 -0.5149201518945191"></a-entity>
		</a-entity>

		<a-entity id="A18" class="piece" sourceimage="img/A18.jpg" description="A18" visible="false">
			<a-entity template="src:#template" data-target="couloirA18A19" position="4.953264773084386 0 -0.6820323216104087"></a-entity>
		</a-entity>

		<a-entity id="A19" class="piece" sourceimage="img/A19.jpg" description="A19" visible="false">
			<a-entity template="src:#template" data-target="couloirA18A19" position="4.342174223193994 0 2.4790165419838646"></a-entity>
		</a-entity>

		<a-entity id="A21" class="piece" sourceimage="img/A21.jpg" description="A21" visible="false">
			<a-entity template="src:#template" data-target="couloirA21A22" position="4.5854942940861765 0 -1.9932992948634476"></a-entity>
		</a-entity>

		<a-entity id="A22" class="piece" sourceimage="img/A22.jpg" description="A22" visible="false">
			<a-entity template="src:#template" data-target="couloirA21A22" position="-4.998317249557235 0 -0.1297099563587658"></a-entity>
		</a-entity>

		<a-entity id="A23" class="piece" sourceimage="img/A23.jpg" description="A23" visible="false">
			<a-entity template="src:#template" data-target="gaucheA" position="3.6435764362191287 0 3.4240839290865392"></a-entity>
			<a-entity template="src:#template" data-target="couloirA23" position="-3.000219246475007 0 3.9998355557548786"></a-entity>
		</a-entity>

		<a-entity id="B10" class="piece" sourceimage="img/B10.jpg" description="B10" visible="false">
		<a-entity template="src:#template" data-target="milieuB" position="3.194811745347082 0 -3.8461900514395193"></a-entity></a-entity>

		<a-entity id="B12" class="piece" sourceimage="img/B12.jpg" description="B12" visible="false">
		<a-entity template="src:#template" data-target="couloirB12" position="-4.696259346952221 0 -1.7161433932407584"></a-entity></a-entity>

		<a-entity id="B14" class="piece" sourceimage="img/B14.jpg" description="B14" visible="false">
		<a-entity template="src:#template" data-target="couloirB14B17" position="3.199791815011352 0 3.8420479357481163"></a-entity></a-entity>
		<a-entity id="B17" class="piece" sourceimage="img/B17.jpg" description="B17" visible="false">
		<a-entity template="src:#template" data-target="couloirB14B17" position="4.057900015014891 0 2.921206508985996"></a-entity></a-entity>
		<a-entity id="B18" class="piece" sourceimage="img/B18.jpg" description="B18" visible="false">
		<a-entity template="src:#template" data-target="couloirB18B19" position="3.603638279763209 0 3.4660916243840494"></a-entity></a-entity>
		<a-entity id="B19" class="piece" sourceimage="img/B19.jpg" description="B19" visible="false">
		<a-entity template="src:#template" data-target="couloirB18B19" position="3.666451133949437 0 -3.3995788095528674"></a-entity></a-entity>
		<a-entity id="B20" class="piece" sourceimage="img/B20.jpg" description="B20" visible="false">
		<a-entity template="src:#template" data-target="couloirB20B21B22B23" position="-4.348129486871544 0 -2.4685562512120733"></a-entity></a-entity>
		<a-entity id="B21" class="piece" sourceimage="img/B21.jpg" description="B21" visible="false">
		<a-entity template="src:#template" data-target="couloirB20B21B22B23" position="3.575794526730412 0 3.4948095087722346"></a-entity></a-entity>
		<a-entity id="B22" class="piece" sourceimage="img/B22.jpg" description="B22" visible="false">
		<a-entity template="src:#template" data-target="couloirB20B21B22B23" position="3.3908100369643996 0 3.6745621906863257"></a-entity></a-entity>
		<a-entity id="B23" class="piece" sourceimage="img/B23.jpg" description="B23" visible="false">
		<a-entity template="src:#template" data-target="couloirB20B21B22B23" position="3.3534868291777564 0 -3.7086555632103826"></a-entity><a-entity template="src:#template" data-target="gaucheB" position="-4.241724804093863 0 -2.647219425422623"></a-entity></a-entity>
		<a-entity id="coinGauche" class="piece" sourceimage="img/coinGauche.jpg" description="coinGauche" visible="false">
		<a-entity template="src:#template" data-target="croisementChemin" position="0.8261933352763493 0 4.931268049167977"></a-entity><a-entity template="src:#template" data-target="exterieurGauche" position="4.950236573091552 0 -0.7036745486564121"></a-entity></a-entity>
		<a-entity id="couloirA12" class="piece" sourceimage="img/couloirA12.jpg" description="couloirA12" visible="false">
		<a-entity template="src:#template" data-target="milieuA" position="-0.745358347297792 0 -4.9441319697307335"></a-entity><a-entity template="src:#template" data-target="A12" position="-4.996230457595245 0 0.19411649748954868"></a-entity><a-entity template="src:#template" data-target="couloirA18A19" position="0.7651288595805817 0 4.941110991288996"></a-entity></a-entity>
		<a-entity id="couloirA18A19" class="piece" sourceimage="img/couloirA18A19.jpg" description="couloirA18A19" visible="false">
		<a-entity template="src:#template" data-target="A19" position="4.321179058823566 0 2.5154346625552977"></a-entity><a-entity template="src:#template" data-target="couloirA12" position="-0.3798174221425795 0 -4.9855530010057025"></a-entity><a-entity template="src:#template" data-target="A18" position="-4.732217801541089 0 -1.6143465175660479"></a-entity><a-entity template="src:#template" data-target="couloirA21A22" position="0.3199648754333023 0 4.989751745176202"></a-entity></a-entity>
		<a-entity id="couloirA21A22" class="piece" sourceimage="img/couloirA21A22.jpg" description="couloirA21A22" visible="false">
		<a-entity template="src:#template" data-target="couloirA18A19" position="-0.12220822129173096 0 -4.998506291948496"></a-entity><a-entity template="src:#template" data-target="A22" position="-4.186822606640318 0 -2.7332245536226205"></a-entity><a-entity template="src:#template" data-target="A21" position="4.288685039830703 0 2.570443663870562"></a-entity><a-entity template="src:#template" data-target="couloirA23" position="0.1142471806744799 0 4.998694587760682"></a-entity></a-entity>


		<a-entity id="couloirA23" class="piece" sourceimage="img/couloirA23.jpg" description="couloirA23" visible="false">
			<a-entity template="src:#template" data-target="couloirA21A22" position="0.24564395222888413 0 -4.993962259442233"></a-entity>
			<a-entity template="src:#template" data-target="A23" position="4.979921653960852 0 -0.4476386046933617"></a-entity>
			<a-entity template="src:#template" data-target="gaucheA" position="-0.03777924820947126 0 4.99985727080331"></a-entity>
		</a-entity>


		<a-entity id="couloirB12" class="piece" sourceimage="img/couloirB12.jpg" description="couloirB12" visible="false">
		<a-entity template="src:#template" data-target="couloirB14B17" position="4.7688736647353025 0 -1.5026123817518893"></a-entity><a-entity template="src:#template" data-target="secretariat" position="-1.412714921894047 0 -4.796273193788892"></a-entity><a-entity template="src:#template" data-target="milieuB" position="-4.75607229145967 0 1.5426523776954946"></a-entity><a-entity template="src:#template" data-target="B12" position="1.182934076207837 0 4.858051767050894"></a-entity></a-entity>
		<a-entity id="couloirB14B17" class="piece" sourceimage="img/couloirB14B17.jpg" description="couloirB14B17" visible="false">
		<a-entity template="src:#template" data-target="couloirB18B19" position="-4.895060088062428 0 1.0190126271338593"></a-entity><a-entity template="src:#template" data-target="B17" position="2.4515442137259176 0 4.357743793311737"></a-entity><a-entity template="src:#template" data-target="B14" position="0.5347183362809496 0 -4.971325406855292"></a-entity><a-entity template="src:#template" data-target="couloirB12" position="4.910353497119708 0 -0.9425648695576603"></a-entity></a-entity>
		<a-entity id="couloirB18B19" class="piece" sourceimage="img/couloirB18B19.jpg" description="couloirB18B19" visible="false">
		<a-entity template="src:#template" data-target="couloirB20B21B22B23" position="-0.5510984224639535 0 -4.969536248862437"></a-entity><a-entity template="src:#template" data-target="B19" position="-4.945079862288456 0 -0.7390434057544809"></a-entity><a-entity template="src:#template" data-target="B18" position="4.60519768201587 0 -1.9473454520335254"></a-entity><a-entity template="src:#template" data-target="couloirB14B17" position="0.45160410739196233 0 4.979563608408543"></a-entity></a-entity>
		<a-entity id="couloirB20B21B22B23" class="piece" sourceimage="img/couloirB20B21B22B23.jpg" description="couloirB20B21B22B23" visible="false">
		<a-entity template="src:#template" data-target="gaucheB" position="0.9071681374629815 0 4.917015961980594"></a-entity><a-entity template="src:#template" data-target="B23" position="3.9365816054690947 0 3.082746383256716"></a-entity><a-entity template="src:#template" data-target="B21" position="4.975196348512237 0 -0.4974146095064984"></a-entity><a-entity template="src:#template" data-target="B20" position="-4.028485543480428 0 -2.9616387737145127"></a-entity><a-entity template="src:#template" data-target="B22" position="-3.9681158486220616 0 3.042048094937754"></a-entity><a-entity template="src:#template" data-target="couloirB18B19" position="-1.0151142369385735 0 -4.8958700029682785"></a-entity></a-entity>
		<a-entity id="croisementChemin" class="piece" sourceimage="img/croisementChemin.jpg" description="croisementChemin" visible="false">
		<a-entity template="src:#template" data-target="exterieurMilieu" position="-0.10591861246653525 0 4.998877998864661"></a-entity><a-entity template="src:#template" data-target="coinGauche" position="0.23787344458228343 0 -4.994338417084145"></a-entity></a-entity>
		<a-entity id="escalierGaucheA" class="piece" sourceimage="img/escalierGaucheA.jpg" description="escalierGaucheA" visible="false">
		<a-entity template="src:#template" data-target="gaucheA" position="0.9637467372527411 0 -4.906240131346477"></a-entity><a-entity template="src:#template" data-target="escalierGaucheB" position="-4.4918332563515575 0 -2.1962317721802864"></a-entity></a-entity>
		<a-entity id="escalierGaucheB" class="piece" sourceimage="img/escalierGaucheB.jpg" description="escalierGaucheB" visible="false">
		<a-entity template="src:#template" data-target="escalierGaucheA" position="4.374304518843096 0 -2.4218711725500333"></a-entity><a-entity template="src:#template" data-target="gaucheB" position="0.4316822932454825 0 4.9813301835652615"></a-entity></a-entity>
		<a-entity id="escalierMilieuA" class="piece" sourceimage="img/escalierMilieuA.jpg" description="escalierMilieuA" visible="false">
		<a-entity template="src:#template" data-target="escalierMilieuB" position="-4.907431793175593 0 -0.9576602713537762"></a-entity><a-entity template="src:#template" data-target="milieuA" position="0.21956205460978903 0 -4.995176924211547"></a-entity></a-entity>
		<a-entity id="escalierMilieuB" class="piece" sourceimage="img/escalierMilieuB.jpg" description="escalierMilieuB" visible="false">
		<a-entity template="src:#template" data-target="milieuB" position="-4.627462635714172 0 1.8938293363102296"></a-entity><a-entity template="src:#template" data-target="escalierMilieuA" position="3.196801884451016 0 3.8445360853515775"></a-entity></a-entity>
		<a-entity id="exterieurGauche" class="piece" sourceimage="img/exterieurGauche.jpg" description="exterieurGauche" visible="false">
		<a-entity template="src:#template" data-target="coinGauche" position="-1.266064728230469 0 4.837052832451875"></a-entity><a-entity template="src:#template" data-target="gaucheA" position="4.865125447081354 0 1.1534965904420587"></a-entity></a-entity>
		<a-entity id="exterieurMilieu" class="piece" sourceimage="img/exterieurMilieu.jpg" description="exterieurMilieu" visible="false" default="">
		<a-entity template="src:#template" data-target="milieuA" position="-4.980644418963418 0 0.4395238012310131"></a-entity><a-entity template="src:#template" data-target="croisementChemin" position="0.6542288652765074 0 4.957013676785552"></a-entity></a-entity>
		<a-entity id="gaucheA" class="piece" sourceimage="img/gaucheA.jpg" description="gaucheA" visible="false">
		<a-entity template="src:#template" data-target="couloirA23" position="1.5369265047791916 0 4.757925694975408"></a-entity><a-entity template="src:#template" data-target="A23" position="-4.375290696427358 0 2.42008911442455"></a-entity><a-entity template="src:#template" data-target="exterieurGauche" position="-1.8733310371120016 0 -4.635798833576892"></a-entity><a-entity template="src:#template" data-target="escalierGaucheA" position="4.792884562057514 0 -1.4241690822338318"></a-entity></a-entity>
		<a-entity id="gaucheB" class="piece" sourceimage="img/gaucheB.jpg" description="gaucheB" visible="false">
		<a-entity template="src:#template" data-target="escalierGaucheB" position="0.3853603388278232 0 -4.9851276221636"></a-entity><a-entity template="src:#template" data-target="couloirB20B21B22B23" position="4.9170992466143195 0 0.9067166034351065"></a-entity><a-entity template="src:#template" data-target="B23" position="2.346262391794905 0 4.415320236273792"></a-entity></a-entity>
		<a-entity id="milieuA" class="piece" sourceimage="img/milieuA.jpg" description="milieuA" visible="false">
		<a-entity template="src:#template" data-target="exterieurMilieu" position="4.907716145508349 0 -0.9562019844764333"></a-entity><a-entity template="src:#template" data-target="couloirA12" position="0.6384359617635665 0 4.959072445803452"></a-entity><a-entity template="src:#template" data-target="escalierMilieuA" position="4.599914257257469 0 1.9597930569015365"></a-entity></a-entity>
		<a-entity id="milieuB" class="piece" sourceimage="img/milieuB.jpg" description="milieuB" visible="false">
		<a-entity template="src:#template" data-target="couloirB12" position="3.9793528663096414 0 3.0273339368813024"></a-entity><a-entity template="src:#template" data-target="B10" position="-4.9578451740080585 0 -0.647897546348959"></a-entity><a-entity template="src:#template" data-target="escalierMilieuB" position="2.7765730907348676 0 -4.158201759391555"></a-entity></a-entity>
		<a-entity id="secretariat" class="piece" sourceimage="img/secretariat.jpg" description="secretariat" visible="false">
		<a-entity template="src:#template" data-target="couloirB12" position="3.5133693744682057 0 -3.557560349249031"></a-entity></a-entity>*/

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