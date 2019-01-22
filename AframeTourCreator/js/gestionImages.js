/*function AucuneImage(){
	let p = document.createElement("p");
	p.setAttribute("id","noImg")
	let txt = document.createTextNode("Il n'y a pas d'image pour le moment ...");
	let sec = document.getElementById("listeImg");
	p.appendChild(txt);
	sec.appendChild(p);
}*/

function afficherImage(key,value){
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

function test(){
	alert(tab);
}

function ajoutDossier(){
    document.getElementById("Ajout").preventDefault(); 
    document.getElementById("Ajout").dataTransfer.files[0]; 
	let dos = prompt("Dossier contenant les images :");
	let dirReader = dos.createReader();
    dirReader.readEntries(function(entries) {
        entries.forEach(function(entry) {
        	let nom = entry.name();
        	let url = dos + nom;
        	ajoutImage(nom,url);
      })});
}

function ajoutImage(nom, url){
	if(typeof(MapImg) == 'undefined'){
		MapImg = new Map();
	}
	MapImg.set(nom,url);
	afficherImage(nom,url);		
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


