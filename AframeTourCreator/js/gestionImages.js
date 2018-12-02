function AucuneImage(){
	let p = document.createElement("p");
	p.setAttribute("id","noImg")
	let txt = document.createTextNode("Il n'y a pas d'image pour le moment ...");
	let sec = document.getElementById("listeImg");
	p.appendChild(txt);
	sec.appendChild(p);
}

function afficherImages(key,value){
	let div =document.createElement("div");
	div.setAttribute("class","container-fluid divImg");
	div.setAttribute("id",key);
	let p = document.createElement("p");
	let img = document.createElement("img");
	img.setAttribute("src",value);
	img.setAttribute("alt","Désolé notre image a rencontré des problèmes");
	let txt = document.createTextNode(key);
	let sec = document.getElementById("listeImg");
	p.appendChild(txt);
	div.appendChild(p);
	div.appendChild(img);
	sec.appendChild(div);
}

function ajoutImage(){
	if(typeof(MapImg) == 'undefined'){
		MapImg = new Map();
	}
	var nom = prompt("Entrez le nom du lieu correspondant à votre image :");
	var url = prompt("Entrez l'url de l'image :");
	MapImg.set(nom,url);
	if(document.getElementById("noImg")!=null){
		let pnoImg = document.getElementById("noImg");
		let sec = document.getElementById("listeImg");
		sec.removeChild(pnoImg);
	}
	afficherImages(nom,url);		
}

function suppImage(){
	let nom = prompt("Nom de l'image à supprimer");
	if(document.getElementById(nom)==null){
		alert("Nom incorrect !");
		return;
	}
	let divtosupp = document.getElementById(nom);
	let sec = document.getElementById("listeImg");
	MapImg.delete(divtosupp)
	sec.removeChild(divtosupp);
	var x =document.getElementsByClassName("divImg");
	alert(x);
	if(document.getElementsByClassName("divImg")==null){
		alert("coucou");
		AucuneImage();
	}
}



if (typeof(MapImg) == 'undefined' || MapImg.size==0){
	AucuneImage();
}
else if(MapImg.size==0){
	AucuneImage();
}
else {
	for (let [key,value] of MapImg.entries()) {
	afficherImages(key,value);
	}
}

