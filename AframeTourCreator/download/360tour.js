$ = (el) => document.querySelector(el);
$$ = (el) => document.querySelectorAll(el);

var mapPosPoints = new Map();

var hudDefON = false;
var hudDef = document.createElement("a-entity");
hudDef.setAttribute("id","hudDef");
hudDef.setAttribute("template","src: #templateHud");
hudDef.setAttribute("position","0 -2 -1");
hudDef.setAttribute("data-text","");
/*window.onload = function(){
	var layout = document.createElement("a-entity");
	layout.setAttribute("id", "layoutMapCircle");
	//layout.setAttribute("visible", "false");
	layout.setAttribute("layout", "type", "circle");
	layout.setAttribute("position", "0 -9 0");
	layout.setAttribute("rotation", "90 0 0");
	layout.setAttribute("layout", "radius", "8");
	var maps = $$(".map");
	maps.forEach(function(el){
		var entityToAdd = document.createElement("a-entity");
		entityToAdd.setAttribute("template", "src: #templateMapIcon");
		entityToAdd.setAttribute("data-target", el.getAttribute("id"));
		layout.appendChild(entityToAdd);
	});
	$("#mapButton").parentNode.appendChild(layout);

}*/

function elementInWithTarget(place, target){
	return $$(`#${place} [data-target="${target}"]`)[0];
}

AFRAME.registerComponent('move', {
	schema: {
		on: {type: 'string'},
		target: {type: 'string'}
	},

	init: function(){
		var data=this.data;
		var el=this.el;
		//var originPlaceName = $(".piece[current]").getAttribute("id");
		var targetElement=$(`#${data.target}`);
		var targetWorldPos = new THREE.Vector3();
		el.addEventListener(data.on, function(){
			var originPlaceName = $(".piece[current]").getAttribute("id");
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
			
			$(`#${originPlaceName}`).setAttribute('visible','false');	
			$(`#${originPlaceName}`).removeAttribute("current");
			targetElement.setAttribute('visible', 'true');
			targetElement.setAttribute("current","");
			/*if(targetElement.getAttribute('description') == null){
				$("#hud").setAttribute('visible', 'false');
			}
			else{
				$("#hud").setAttribute('visible', 'true');
				$("#hud").setAttribute('text','value', targetElement.getAttribute('description'));
				$("#hud").setAttribute('position',targetElement.getAttribute('posHud'));
			}*/
			HudVerif(data.target);
			$("#cursor").setAttribute('raycaster', `objects: #${data.target},#mapButton`);				
		});
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

				$(`.piece[current]`).setAttribute('visible','false');				
				$(`.piece[current]`).removeAttribute("current");
				$(`#${data.target}`).setAttribute('visible', 'true');
				$(`#${data.target}`).setAttribute("current","");
				//$("#hud").setAttribute('visible', 'false');
				
				$("#cursor").setAttribute('raycaster', `objects: #${data.target},#layoutMapCircle`);
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
				//$("#hud").setAttribute('visible', 'false');
				
				$("#cursor").setAttribute('raycaster', `objects: #${map},#layoutMapCircle`);
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
		/*$("#hud").setAttribute('text','value', el.getAttribute('description'));
		$("#hud").setAttribute('position',el.getAttribute('posHud'));*/
		HudVerif(el.id);
		el.setAttribute('visible', 'true');
		el.setAttribute("current","");
		$("#cursor").setAttribute('raycaster', `objects: #${el.id},#mapButton`);
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

function HudVerif(id){
	var huds = $("#"+id).getElementsByClassName("hud"+id);
	if(!hudDefON && huds.length==0){
		hudDef.setAttribute("data-text",$("#"+id).getAttribute("description"));
		$("#cameraRotation").appendChild(hudDef);
		hudDefON = true;
	}
	else if(hudDefON && huds.length!=0){
		$("#cameraRotation").removeChild(hudDef);
		hudDefON = false;
	}
}
