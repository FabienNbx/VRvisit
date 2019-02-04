var defBool = 0;

var inputDef = document.createElement("input");
inputDef.setAttribute("type", "text");
inputDef.setAttribute("name", "default");
inputDef.setAttribute("hidden", "");

function sendData(el,target){
	var form = document.getElementById('pointsForm');
	form.setAttribute("action", target);
	form.submit();
}

function choiceDef(el,img){
	var formP = document.getElementById('pointsForm');
	if(defBool==1){
		document.getElementById("def").setAttribute("id","");
		formP.removeChild(inputDef);
	}
	else
		defBool=1;
	el.setAttribute("id","def");
    inputDef.setAttribute("value", img);
    formP.appendChild(inputDef);
}