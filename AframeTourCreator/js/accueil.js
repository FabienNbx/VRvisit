function sendData(el,target){
	var form = document.getElementById('pointsForm');
	form.setAttribute("action", target);
	form.submit();
}