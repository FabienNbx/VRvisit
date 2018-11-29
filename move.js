AFRAME.registerComponent('move', {
	schema: {
		on: {type: 'string'},
		target: {type: 'string'}
	},

	init: function(){
		var data=this.data;
		var el=this.el;
		var target=document.querySelector(`#${data.target}`)
		el.addEventListener(data.on, function(){
				//if img existe charger image
				//else creer img avec id asset item et source innerHTML
				document.querySelector("#background").setAttribute('src', `#${data.target}Img`);
				target.setAttribute('visible', 'true');
				el.parentNode.setAttribute('visible','false');
				document.querySelector("#hud").setAttribute('value', target.getAttribute('description'));
				document.querySelector("#cursor").setAttribute('raycaster', `objects: #${data.target}`);
			}
		);
	}
});

AFRAME.registerComponent('default', {
	schema: {
	},

	init: function(){
		var el = this.el;
		document.querySelector("#background").setAttribute('src', `#${el.id}Img`);
		document.querySelector("#hud").setAttribute('value', el.getAttribute('description'));
		el.setAttribute('visible', 'true');
		document.querySelector("#cursor").setAttribute('raycaster', `objects: #${el.id}`);
	}
});

AFRAME.registerComponent('description', {
	schema: {type: 'string'}
	}
);

function clickSky(){
	alert("click");
}