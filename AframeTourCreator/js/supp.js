var defBool = 0;

function sendData(el,target){
	var form = document.getElementById('pointsForm');
	form.setAttribute("action", target);
	form.submit();
}

function choiceDef(el,img){
	var formP = document.getElementById('pointsForm');
	var c = el.getAttribute('class');
	if(c=="clickable"){
		el.setAttribute('class',"clickable add");
		var input = document.createElement("input");
		input.setAttribute("type", "text");
		input.setAttribute("name", "supp[]");
		input.setAttribute("hidden", "");
		input.setAttribute("value", img);
    	formP.appendChild(input);
	}
	else{
		el.setAttribute('class',"clickable");
		var inputs = formP.getElementsByTagName('input');
		var index = -1;
		for (var i = inputs.length - 1; i >= 0; i--) {
			var v = inputs[i].getAttribute('value');
		  	if(v==img)
		  		index = i;
		}
		if(index!=-1){
			formP.removeChild(inputs[index]);
		}
	}
}