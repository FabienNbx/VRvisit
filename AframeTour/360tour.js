$ = (el) => document.querySelector(el);
$$ = (el) => document.querySelectorAll(el);

var mapPosPoints = new Map();

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
  	ajouterPointInteret(`${xPos} 0 ${zPos}`);
  }
});

document.addEventListener('keypress', (event) => {
  const Touche = event.key;
  if(Touche=='r'){
  	var el = $("#cursor").components.raycaster.intersectedEls[0];
  	if(el !== undefined){
	  	if(confirm("supprimer?")){
	  		supprimer(el);
	  	}
	  }
  }
});

AFRAME.registerComponent('move', {
	schema: {
		on: {type: 'string'},
		target: {type: 'string'}
	},

	init: function(){
		var data=this.data;
		var el=this.el;
		var originPlaceName = el.parentNode.parentNode.getAttribute('id');
		var targetElement=$(`#${data.target}`);
		var targetWorldPos = new THREE.Vector3();
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

				var elementToHaveInTheBack=elementInWithTarget(data.target, originPlaceName);
				if (typeof elementToHaveInTheBack !== 'undefined') {
					targetWorldPos.setFromMatrixPosition(elementToHaveInTheBack.object3D.matrixWorld);
					$("#cameraRotation").setAttribute("rotation", `0 ${Math.atan2(targetWorldPos.x, targetWorldPos.z)*(180/Math.PI)-$("#camera").getAttribute("rotation").y} 0`);
				}
				
				
				targetElement.setAttribute('visible', 'true');
				targetElement.setAttribute("current","");
				el.parentNode.parentNode.setAttribute('visible','false');				
				el.parentNode.parentNode.removeAttribute("current");
				$("#hud").setAttribute('text','value', targetElement.getAttribute('description'));
				$("#cursor").setAttribute('raycaster', `objects: #${data.target}`);
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
		$("#cursor").setAttribute('raycaster', `objects: #${el.id}`);
	}
});

AFRAME.registerComponent('description', {
	schema: {type: 'string'}
	}
);

AFRAME.registerComponent('sourceimage', {
	schema: {type: 'string'},

	init: function(){
		var div = document.createElement("div");
		div.setAttribute("id", this.el.getAttribute("id")+"Img");
		div.innerHTML=this.data;
		$("a-assets").appendChild(div);
	}
});


function ajouterPointInteret(pos){
	var currentPlace = $(".piece[current]");
	var point = document.createElement("a-entity");
	point.setAttribute("template", "src: #template");
	point.setAttribute("data-target", window.prompt("Vers ou?", "lieu"));
	point.setAttribute("position", pos);
	currentPlace.appendChild(point);
	var lieuPresent = mapPosPoints.get(point.parentNode.getAttribute("id"));
	if(lieuPresent === undefined){
		mapPosPoints.set(point.parentNode.getAttribute("id"), new Map());
		lieuPresent = mapPosPoints.get(point.parentNode.getAttribute("id"));
	}
	lieuDest = lieuPresent.get(point.getAttribute("data-target"));
	if(lieuDest === undefined){
		lieuPresent.set(point.getAttribute("data-target"), pos);
	}
}

function supprimer(el){
	var lieuPresent = mapPosPoints.get(el.parentNode.parentNode.getAttribute("id"));
	if(lieuPresent !== undefined){
		lieuPresent.delete(el.parentNode.getAttribute("data-target"));
	}
	el.parentNode.parentNode.removeChild(el.parentNode);
}

function sauvegarder(){
	var docSave = document;

	var imgs = docSave.querySelectorAll("img");
	imgs.forEach(function(el){
		el.parentNode.removeChild(el);
	});

	var divs = docSave.querySelectorAll("div");
	divs.forEach(function(el){
		el.parentNode.removeChild(el);
	});

	docSave.querySelector("canvas").parentNode.removeChild(docSave.querySelector("canvas"));

	var templateAEnlever = docSave.querySelectorAll("[template]");
	templateAEnlever.forEach(function(el){
		el.removeAttribute("template");
	});

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


	docSave.querySelector("a-scene").setAttribute("debug", "");
	mapPosPoints.forEach(function(value, key, map){
		value.forEach(function(value2, key2, map2){
			docSave.querySelector(`#${key} > a-entity[data-target=${key2}]`).setAttribute("position",value2);
		});
	});
	docSave.querySelector("a-scene").removeAttribute("debug", "");

	var pieces = docSave.querySelectorAll(".piece");
	pieces.forEach(function(el){
		el.setAttribute("visible", "false");
	});

	var element = document.createElement('a');
  	element.setAttribute('href', 'data:text/html;charset=utf-8,' + encodeURIComponent(docSave.documentElement.outerHTML));
  	element.setAttribute('download', "page.html");
  	element.style.display = 'none';
 	document.body.appendChild(element);
 	element.click();
 	document.body.removeChild(element);
}