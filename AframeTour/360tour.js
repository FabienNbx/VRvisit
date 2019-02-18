$ = (el) => document.querySelector(el);
$$ = (el) => document.querySelectorAll(el);

var mapPosPoints = new Map();
var mapRotPoints = new Map();

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

document.addEventListener('keypress', (event) => {
  const Touche = event.key;
  if(Touche=='s'){
  	if(confirm("sauvegarder?")){
  		sauvegarder();
  	}
  }
});

document.addEventListener('keypress', (event) => {
  const Touche = event.key;
  if(Touche=='p'){
  	var dist = 5;
  	var angle = ($("#camera").getAttribute("rotation").y+$("#cameraRotation").getAttribute("rotation").y) * Math.PI / 180;
  	var xPos = -dist*Math.sin(angle);
  	var zPos = -dist*Math.cos(angle);
  	var angleX = ($("#camera").getAttribute("rotation").x+$("#cameraRotation").getAttribute("rotation").x) * Math.PI / 180;
  	var yPos = dist*Math.tan(angleX);
  	ajouterPointInteret(`${xPos} ${yPos} ${zPos}`, `0 ${angle*(180/Math.PI)} 0`);
  }
});

document.addEventListener('keypress', (event) => {
  const Touche = event.key;
  if(Touche=='r'){
  	var el = $(".cursor.active").components.raycaster.intersectedEls[0];
  	if(el !== undefined){
  		if(el.getAttribute("id")!="map"){
	  		if(confirm("supprimer?")){
	  			supprimer(el);
	  		}
	  	}
	  }
  }
});

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
				if(targetElement.getAttribute('description') == null){
					$("#hud").setAttribute('visible', 'false');
				}
				else{
					$("#hud").setAttribute('visible', 'true');
					$("#hud").setAttribute('text','value', targetElement.getAttribute('description'));
				}
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
				$("#hud").setAttribute('visible', 'false');
				
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
				$("#hud").setAttribute('visible', 'false');
				$("#layoutMapCircle").setAttribute('visible', 'true');

				$(".cursor.active").setAttribute('raycaster', `objects: #${map},#layoutMapCircle`);
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
		$("#hud").setAttribute('text','value', el.getAttribute('description'));
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


function ajouterPointInteret(pos, rot){
	var currentPlace = $(".piece[current]");
	var point = document.createElement("a-entity");
	point.setAttribute("template", "src: #template");
	if(($(".map[current]")!=null)){
		point.setAttribute("template", "src: #templateMap");
	}
	var target = window.prompt("Vers ou?", "lieu");
	if(target == currentPlace.getAttribute("id")){
		alert("impossible de mettre un point là ou on est déjà");
		return;
	}
	if($(`.piece[id=${target}]`) === null){
		alert("piece inexistante");
		return;
	}
	point.setAttribute("data-target", target);
	point.setAttribute("position", pos);
	point.setAttribute("data-childrotation", rot);
	currentPlace.appendChild(point);
	var lieuPresent = mapPosPoints.get(point.parentNode.getAttribute("id"));
	if(lieuPresent === undefined){
		mapPosPoints.set(point.parentNode.getAttribute("id"), new Map());
		lieuPresent = mapPosPoints.get(point.parentNode.getAttribute("id"));
	}
	var lieuPresentRot = mapRotPoints.get(point.parentNode.getAttribute("id"));
	if(lieuPresentRot === undefined){
		mapRotPoints.set(point.parentNode.getAttribute("id"), new Map());
		lieuPresentRot = mapRotPoints.get(point.parentNode.getAttribute("id"));
	}
	lieuDest = lieuPresent.get(point.getAttribute("data-target"));
	if(lieuDest === undefined){
		lieuPresent.set(point.getAttribute("data-target"), pos);
	}

	lieuDest = lieuPresentRot.get(point.getAttribute("data-target"));
	if(lieuDest === undefined){
		lieuPresentRot.set(point.getAttribute("data-target"), rot);
	}
}

function supprimer(el){
	var lieuPresent = mapPosPoints.get(el.parentNode.parentNode.getAttribute("id"));
	if(lieuPresent !== undefined){
		lieuPresent.delete(el.parentNode.getAttribute("data-target"));
	}
	var lieuPresentRot = mapRotPoints.get(el.parentNode.parentNode.getAttribute("id"));
	if(lieuPresentRot !== undefined){
		lieuPresentRot.delete(el.parentNode.getAttribute("data-target"));
	}
	el.parentNode.parentNode.removeChild(el.parentNode);
}

function sauvegarder(){
	var docSave = document;

	docSave.querySelector("a-scene").setAttribute("debug", "");

	var imgs = docSave.querySelectorAll("img");
	imgs.forEach(function(el){
		el.parentNode.removeChild(el);
	});

	var divs = docSave.querySelectorAll("div");
	divs.forEach(function(el){
		el.parentNode.removeChild(el);
	});

	docSave.querySelector("canvas").parentNode.removeChild(docSave.querySelector("canvas"));

	var templateAEnlever = docSave.querySelectorAll(".piece:not(.map) a-entity[template]");
	templateAEnlever.forEach(function(el){
		el.setAttribute("template", "src: #template");
		el.removeChild(el.firstChild);
	});

	templateAEnlever = docSave.querySelectorAll(".map a-entity[template]");
	templateAEnlever.forEach(function(el){
		el.setAttribute("template", "src: #templateMap");
		el.removeChild(el.firstChild);
	});

	docSave.querySelector("a-scene").removeChild(docSave.querySelector("#layoutMapCircle"));

	docSave.querySelector("a-scene").removeChild(docSave.querySelector("a-sky"));
	var sky = docSave.createElement("a-sky");
	sky.setAttribute("id", "background");
	docSave.querySelector("a-scene").appendChild(sky);


	docSave.querySelector("a-cursor").removeAttribute("material");
	docSave.querySelector("a-cursor").removeAttribute("raycaster");
	docSave.querySelector("a-cursor").removeAttribute("geometry");
	docSave.querySelector("a-cursor").removeAttribute("position");
	docSave.querySelector("a-cursor").removeAttribute("cursor");

	docSave.querySelector("#camera").removeAttribute("position");
	docSave.querySelector("#camera").removeAttribute("rotation");
	docSave.querySelector("#cameraRotation").removeAttribute("rotation");
	try{
		docSave.querySelector("#camera").removeChild(docSave.querySelector("#labelMap"));
	}
	catch(e){}

 
	var metas = docSave.querySelectorAll("meta[aframe-injected]");
	metas.forEach(function(el){
		el.parentNode.removeChild(el);
	});

	var lights = docSave.querySelectorAll("[light][aframe-injected]");
	lights.forEach(function(el){
		el.parentNode.removeChild(el);
	});

	var styles = docSave.querySelectorAll("style");
	styles.forEach(function(el){
		el.parentNode.removeChild(el);
	});

	mapPosPoints.forEach(function(value, key, map){
		value.forEach(function(value2, key2, map2){
			docSave.querySelector(`#${key} > a-entity[data-target=${key2}]`).setAttribute("position",value2);
		});
	});

	mapRotPoints.forEach(function(value, key, map){
		value.forEach(function(value2, key2, map2){
			docSave.querySelector(`#${key} > a-entity[data-target=${key2}]`).setAttribute("data-childrotation",value2);
		});
	});

	var pieces = docSave.querySelectorAll(".piece");
	pieces.forEach(function(el){
		el.setAttribute("visible", "false");
	});

	docSave.querySelector("a-cursor").setAttribute("color", "black");
	docSave.querySelector("a-cursor").setAttribute("fuse-timeout", 2500);
	docSave.querySelector("a-entity.cursor").removeAttribute("raycaster");

	docSave.querySelector("[current]").removeAttribute("current");

	docSave.querySelector("a-scene").removeAttribute("debug");



	var element = document.createElement('a');
  	element.setAttribute('href', 'data:text/html;charset=utf-8,' + encodeURIComponent(docSave.documentElement.outerHTML));
  	element.setAttribute('download', "page.html");
  	element.style.display = 'none';
 	document.body.appendChild(element);
 	element.click();
 	document.body.removeChild(element);
}