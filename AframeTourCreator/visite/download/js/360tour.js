$ = (el) => document.querySelector(el);
$$ = (el) => document.querySelectorAll(el);

var mapPosPoints = new Map();
var mapRotPoints = new Map();

var hudDefON = false;

window.onload = function(){
	var layout = document.createElement("a-entity");
	layout.setAttribute("id", "layoutMapCircle");
	layout.setAttribute("visible", "false");
	layout.setAttribute("layout", "type", "circle");
	layout.setAttribute("position", "0 -9 0");
	layout.setAttribute("rotation", "90 0 0");
	layout.setAttribute("layout", "radius", "8");
	$("#mapButton").parentNode.appendChild(layout);
	var maps = $$(".map");
	var nbMaps = maps.lenght;
	maps.forEach(function(el, index){
		var entityToAdd = document.createElement("a-entity");
		entityToAdd.setAttribute("template", "src: #templateMapIcon");
		entityToAdd.setAttribute("data-target", el.getAttribute("id"));
		layout.appendChild(entityToAdd);
	});

	$('a-scene').addEventListener('enter-vr',()=>{
	    if(AFRAME.utils.device.checkHeadsetConnected()) {
	        switchToController();
	    } else {
	        switchToGaze();
	    }
	});

	$('a-scene').addEventListener('exit-vr',switchToGaze);
}



function switchToController(){
	var cursorGaze = $("a-cursor.cursor");
	var cursorController = $("a-entity.cursor");
	cursorGaze.setAttribute("visible", "false");
	cursorGaze.setAttribute("class", "cursor");
	cursorController.setAttribute("class", "cursor active");
	cursorController.setAttribute("visible", "true");
	cursorController.setAttribute("raycaster", cursorGaze.getAttribute("raycaster"));
	cursorGaze.removeAttribute("raycaster");
}

function switchToGaze(){
	var cursorGaze = $("a-cursor.cursor");
	var cursorController = $("a-entity.cursor");
	cursorController.setAttribute("visible", "false");
	cursorController.setAttribute("class", "cursor");
	cursorGaze.setAttribute("class", "cursor active");
	cursorGaze.setAttribute("visible", "true");
	cursorGaze.setAttribute("raycaster", cursorGaze.getAttribute("raycaster"));
	cursorController.removeAttribute("raycaster");
}


function elementInWithTarget(place, target){
	return $$(`#${place} [data-target="${target}"]`)[0];
}

AFRAME.registerComponent('display-label', {
	schema: { type: 'string' },

	init: function(){
		var el=this.el;
		var data=this.data;
		el.addEventListener("mouseenter", function(){
			var label = document.createElement("a-entity");
			label.setAttribute("id", "labelMap");
			label.setAttribute("geometry", "primitive: plane; height: 0.5; width: 0.5");
			label.setAttribute("material", "color: #202020");
			label.setAttribute("text", `align: center; wrapCount: 10; value: ${data}`);
			label.setAttribute("position", "0 0.35 -1");
			$("#camera").appendChild(label);
		});

		el.addEventListener("mouseleave", function(){
			$("#camera").removeChild($("#labelMap"));
		});

	}
});

function loadImageOf(point){
	var image=$(`#${point.getAttribute("data-target")}Img`);
	if(image.nodeName!="IMG"){
		var source=image.innerHTML;
		var parentImage=image.parentNode;
		parentImage.removeChild(image);
		image=document.createElement("img");
		image.setAttribute("id", `${point.getAttribute("data-target")}Img`);
		image.setAttribute("crossorigin", "anonymous");
		image.setAttribute("src", source);
		parentImage.appendChild(image);
	}
}

function priorityLoadImageOf(point){
	return new Promise(resolve => {
		var image=$(`#${point.getAttribute("data-target")}Img`);
		if(image.nodeName!="IMG"){
			var source=image.innerHTML;
			var parentImage=image.parentNode;
			parentImage.removeChild(image);
			image=document.createElement("img");
			image.setAttribute("id", `${point.getAttribute("data-target")}Img`);
			image.setAttribute("crossorigin", "anonymous");
			image.setAttribute("src", source);
			parentImage.appendChild(image);
		}
		image.addEventListener("load", function(){
			resolve("loaded");
		});
	});
}

AFRAME.registerComponent('move', {
	schema: {
		on: {type: 'string'},
		target: {type: 'string'}
	},

	init: function(){
		var data=this.data;
		var el=this.el;
		var targetElement=$(`#${data.target}`);
		var targetWorldPos = new THREE.Vector3();
		el.addEventListener(data.on, function(){
				var originPlaceName = $(".piece[current]").getAttribute("id");
				var points=$$(`#${data.target}>a-entity`);
				var pointsArray = [];
				var pieceActuelle = document.createElement("a-entity");
				pieceActuelle.setAttribute("data-target", data.target);
				pointsArray.push(pieceActuelle);
				points.forEach(function(el){
					pointsArray.push(el);
				});
				pointsArray.forEach(async function(point, index){
					if(index==0){
						await priorityLoadImageOf(point);
					}
					else{
						loadImageOf(point);
					}
				});
								
				$("#background").setAttribute('src', `#${data.target}Img`);

				var elementToHaveInTheBack=elementInWithTarget(data.target, originPlaceName);
				if (typeof elementToHaveInTheBack !== 'undefined') {
					targetWorldPos.setFromMatrixPosition(elementToHaveInTheBack.object3D.matrixWorld);
					$("#cameraRotation").setAttribute("rotation", `0 ${Math.atan2(targetWorldPos.x, targetWorldPos.z)*(180/Math.PI)-$("#camera").getAttribute("rotation").y} 0`);
				}
				
				$(`#${originPlaceName}`).setAttribute('visible','false');				
				$(`#${originPlaceName}`).removeAttribute("current");
				targetElement.setAttribute('visible', 'true');
				targetElement.setAttribute("current","");
				HudVerif(targetElement.getAttribute('id'));
				$("#layoutMapCircle").setAttribute('visible', 'false');
				$(".cursor.active").setAttribute('raycaster', `objects: #${data.target},#mapButton`);				
			}
		);
	}
});

AFRAME.registerComponent('movetothismap', {
	schema: {
		on: {type: 'string'},
		target: {type: 'string'}
	},

	init: function(){
		var data=this.data;
		var el=this.el;
		el.addEventListener(data.on, function(){
				var image=$(`#${data.target}Img`);
				if(image.nodeName!="IMG"){
					var source=image.innerHTML;
					var parentImage=image.parentNode;
					parentImage.removeChild(image);
					image=document.createElement("img");
					image.setAttribute("id", `${data.target}Img`);
					image.setAttribute("crossorigin", "anonymous");
					image.setAttribute("src", source);
					parentImage.appendChild(image);
				}
				$("#background").setAttribute('src', `#${data.target}Img`);				
				$$(`#${data.target} a-entity a-entity`).forEach(function(el){
					el.setAttribute("material", "color", "#202020");
				});
				$(`.piece[current]`).setAttribute('visible','false');				
				$(`.piece[current]`).removeAttribute("current");
				$(`#${data.target}`).setAttribute('visible', 'true');
				$(`#${data.target}`).setAttribute("current","");
				//$("#hud").setAttribute('visible', 'false');
				
				$(".cursor.active").setAttribute('raycaster', `objects: #${data.target},#layoutMapCircle`);
			}
		);
	}
});

AFRAME.registerComponent('movetomap', {
	schema: {
		on: {type: 'string'}
	},

	init: function(){
		var data=this.data;
		var el=this.el;
		var targetWorldPos = new THREE.Vector3();
		el.addEventListener(data.on, function(){
				var originPlaceName = $(".piece[current]").getAttribute("id");
				var map = $(`.map a-entity[data-target=${originPlaceName}]`);
				if(map == null){
					map = $(".map[defaultmap]").getAttribute("id");
					if(map == null) return;
					$$(`#${map} a-entity a-entity`).forEach(function(el){
						el.setAttribute("material", "color", "#202020");
					});
				}
				else{
					map=map.parentNode.getAttribute("id");
					$$(`#${map} a-entity a-entity`).forEach(function(el){
						el.setAttribute("material", "color", "#202020");
					});
					$(`#${map} a-entity[data-target=${originPlaceName}] a-entity`).setAttribute("material", "color", "red");
					var elementToFace=$(`#${map} a-entity[data-target=${originPlaceName}] a-entity`);
					targetWorldPos.setFromMatrixPosition(elementToFace.object3D.matrixWorld);
					$("#cameraRotation").setAttribute("rotation", `0 ${Math.atan2(targetWorldPos.x, targetWorldPos.z)*(180/Math.PI)-$("#camera").getAttribute("rotation").y+180} 0`);
				}
				var image=$(`#${map}Img`);
				if(image.nodeName!="IMG"){
					var source=image.innerHTML;
					var parentImage=image.parentNode;
					parentImage.removeChild(image);
					image=document.createElement("img");
					image.setAttribute("id", `${map}Img`);
					image.setAttribute("crossorigin", "anonymous");
					image.setAttribute("src", source);
					parentImage.appendChild(image);
				}
				$("#background").setAttribute('src', `#${map}Img`);				

				$(`#${originPlaceName}`).setAttribute('visible','false');				
				$(`#${originPlaceName}`).removeAttribute("current");
				$(`#${map}`).setAttribute('visible', 'true');
				$(`#${map}`).setAttribute("current","");
				//$("#hud").setAttribute('visible', 'false');
				$("#layoutMapCircle").setAttribute('visible', 'true');

				$(".cursor.active").setAttribute('raycaster', `objects: #${map},#layoutMapCircle`);
				if(hudDefON){
					$("#cameraRotation").removeChild($(`#hudDef`));
					hudDefON = false;
				}
			}
		);
	}
});

AFRAME.registerComponent('default', {
	schema: {
	},

	init: function(){
		var el = this.el;
		var image=$(`#${el.id}Img`);
		var source=image.innerHTML;
		var parentImage=image.parentNode;
		parentImage.removeChild(image);
		image=document.createElement("img");
		image.setAttribute("id", `${el.id}Img`);
		image.setAttribute("crossorigin", "anonymous");
		image.setAttribute("src", source);
		parentImage.appendChild(image);
		$("#background").setAttribute('src', `#${el.id}Img`);
		//$("#hud").setAttribute('text','value', el.getAttribute('description'));
		HudVerif(el.id);
		el.setAttribute('visible', 'true');
		el.setAttribute("current","");
		$(".cursor.active").setAttribute('raycaster', `objects: #${el.id},#mapButton`);
	}
});


AFRAME.registerComponent('sourceimage', {
	schema: {type: 'string'},

	init: function(){
		var div = document.createElement("div");
		div.setAttribute("id", this.el.getAttribute("id")+"Img");
		div.innerHTML=this.data;
		$("a-assets").appendChild(div);
	}
});

function HudVerif(id){
	var huds = $$(`.hud${id}`);
	if(!hudDefON && huds.length==0){
		var hudDef = document.createElement("a-entity");
		hudDef.setAttribute("id","hudDef");
		hudDef.setAttribute("template","src: #templateHud");
		hudDef.setAttribute("position","0 -2 -1");
		hudDef.setAttribute("data-text",$(`#${id}`).getAttribute("description"));
		$("#cameraRotation").appendChild(hudDef);
		hudDefON = true;
	}
	else if(hudDefON && huds.length!=0){
		$("#cameraRotation").removeChild($(`#hudDef`));
		hudDefON = false;
	}
	else if(hudDefON && huds.length==0){
		$("#cameraRotation").removeChild($(`#hudDef`));
		var hudDef = document.createElement("a-entity");
		hudDef.setAttribute("id","hudDef");
		hudDef.setAttribute("template","src: #templateHud");
		hudDef.setAttribute("position","0 -2 -1");
		hudDef.setAttribute("data-text",$(`#${id}`).getAttribute("description"));
		$("#cameraRotation").appendChild(hudDef);
	}
}
