var conf = 0;

function download(){
	conf = 1;
}

function home(){
	if(conf==0){
		var rep = window.confirm("Visit not downloaded, you will lose everything.");
		if(rep)
			window.location = "index.php";
	}
	else
		window.location = "index.php";
}