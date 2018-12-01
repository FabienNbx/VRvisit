var MapImg = new Map();

MapImg.set("salon","images/salon.jpg");
MapImg.set("entree","images/entree.jpg");
MapImg.set("salledebain","images/salledebain.jpg");

function afficherImages(key,value){
	alert("hi!");
	let div =document.createElement("div");
	div.setAttribute("class","container-fluid");
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

for (let [key,value] of MapImg.entries()) {
	alert("coucou");
	afficherImages(key,value);
}

