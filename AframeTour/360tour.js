$ = (el) => document.querySelector(el);

function elementInWithTarget(place, target){
	var elements = document.querySelectorAll(`#${place} [data-target="${target}"]`);
	return elements[0];
}

document.addEventListener('keypress', (event) => {
  const Touche = event.key;
  if(Touche=='p'){
  	var dist = 5;
  	var angle = ($("#camera").getAttribute("rotation").y+$("#cameraRotation").getAttribute("rotation").y) * Math.PI / 180;
  	console.log(angle);
  	var xPos = -dist*Math.sin(angle);
  	var zPos = -dist*Math.cos(angle);
  	ajouterPointInteret(`${xPos} 0 ${zPos}`);
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
				
				
				targetElement.setAttribute("current", '');
				targetElement.setAttribute('visible', 'true');
				el.parentNode.parentNode.removeAttribute("current");
				el.parentNode.parentNode.setAttribute('visible','false');
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
		el.setAttribute("current", '');
		$("#cursor").setAttribute('raycaster', `objects: #${el.id}`);
	}
});

AFRAME.registerComponent('description', {
	schema: {type: 'string'}
	}
);


function ajouterPointInteret(pos){
	var currentPlace = $(".piece[current]");
	console.log(currentPlace.getAttribute("id"));
	var point = document.createElement("a-entity");
	point.setAttribute("template", "src: #template");
	point.setAttribute("data-target", window.prompt("Vers ou?", "lieu"));
	point.setAttribute("position", pos);
	currentPlace.appendChild(point);
	point.setAttribute("look-at", "#camera");
	point.removeAttribute("look-at");
}