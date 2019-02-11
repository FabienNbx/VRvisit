<html class="a-html"><head>
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
		</a-assets>		<a-entity id="A12" class="piece" sourceimage="uploads/A12.jpg" description="A12" visible="false" default posHud="0 -2 -1">		</a-entity>		<a-entity id="A18" class="piece" sourceimage="uploads/A18.jpg" description="A18" visible="false" posHud="0 -2 -1">		</a-entity>		<a-entity id="A19" class="piece" sourceimage="uploads/A19.jpg" description="A19" visible="false" posHud="0 -2 -1">		</a-entity>		<a-entity id="A21" class="piece" sourceimage="uploads/A21.jpg" description="A21" visible="false" posHud="0 -2 -1">		</a-entity>		<a-entity id="A22" class="piece" sourceimage="uploads/A22.jpg" description="A22" visible="false" posHud="0 -2 -1">		</a-entity>		<a-entity id="A23" class="piece" sourceimage="uploads/A23.jpg" description="A23" visible="false" posHud="0 -2 -1">		</a-entity>		<a-entity id="B10" class="piece" sourceimage="uploads/B10.jpg" description="B10" visible="false" posHud="0 -2 -1">		</a-entity>		<a-entity id="B12" class="piece" sourceimage="uploads/B12.jpg" description="B12" visible="false" posHud="0 -2 -1">		</a-entity>		<a-entity id="B14" class="piece" sourceimage="uploads/B14.jpg" description="B14" visible="false" posHud="0 -2 -1">		</a-entity>		<a-entity id="B17" class="piece" sourceimage="uploads/B17.jpg" description="B17" visible="false" posHud="0 -2 -1">		</a-entity>		<a-entity id="B18" class="piece" sourceimage="uploads/B18.jpg" description="B18" visible="false" posHud="0 -2 -1">		</a-entity>		<a-entity id="B19" class="piece" sourceimage="uploads/B19.jpg" description="B19" visible="false" posHud="0 -2 -1">		</a-entity>		<a-entity id="B20" class="piece" sourceimage="uploads/B20.jpg" description="B20" visible="false" posHud="0 -2 -1">		</a-entity>		<a-entity id="B21" class="piece" sourceimage="uploads/B21.jpg" description="B21" visible="false" posHud="0 -2 -1">		</a-entity>		<a-entity id="B22" class="piece" sourceimage="uploads/B22.jpg" description="B22" visible="false" posHud="0 -2 -1">		</a-entity>		<a-entity id="B23" class="piece" sourceimage="uploads/B23.jpg" description="B23" visible="false" posHud="0 -2 -1">		</a-entity>		<a-entity id="coinGauche" class="piece" sourceimage="uploads/coinGauche.jpg" description="coinGauche" visible="false" posHud="0 -2 -1">		</a-entity>		<a-entity id="couloirA12" class="piece" sourceimage="uploads/couloirA12.jpg" description="couloirA12" visible="false" posHud="0 -2 -1">		</a-entity>		<a-entity id="couloirA18A19" class="piece" sourceimage="uploads/couloirA18A19.jpg" description="couloirA18A19" visible="false" posHud="0 -2 -1">		</a-entity>		<a-entity id="couloirA21A22" class="piece" sourceimage="uploads/couloirA21A22.jpg" description="couloirA21A22" visible="false" posHud="0 -2 -1">		</a-entity>
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
