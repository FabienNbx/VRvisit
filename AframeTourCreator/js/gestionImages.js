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



// if (typeof(MapImg) == 'undefined' || MapImg.size==0){
// 	AucuneImage();
// }
// else if(MapImg.size==0){
// 	AucuneImage();
// }
// else {
// 	for (let [key,value] of MapImg.entries()) {
// 	afficherImages(key,value);
// 	}
// }



// <!DOCTYPE html>

// <!-- This is the shortest Image Uploader ever :)
// And you can even make it shorter if you don't
// want all the drag'n drop thing. -->

// <!--
// AUTHOR: @paulrouget <paul@mozilla.com>

// LICENSE:
// DO WHAT THE FUCK YOU WANT TO PUBLIC LICENSE

// Everyone is permitted to copy and distribute verbatim or modified
// copies of this license document, and changing it is allowed as long
// as the name is changed.

// DO WHAT THE FUCK YOU WANT TO PUBLIC LICENSE
// TERMS AND CONDITIONS FOR COPYING, DISTRIBUTION AND MODIFICATION

// 0. You just DO WHAT THE FUCK YOU WANT TO. -->


// <!-- One single file. This one. -->


// <meta charset="utf8">
// <title>Yo.</title>

// <!-- This is a simple image uploader, with drag'n drop -->
// <!-- Also, if you want to do more, read this: https://hacks.mozilla.org/2011/01/how-to-develop-a-html5-image-uploader/ -->

// <!-- You can use this code whereever you want (your own domain)
// No server side code needed. -->

// <!-- The image is sent to imgur.com because they allow Cross Domain XMLHttpRequest.
// You'll need a key: http://api.imgur.com/ -->

// <!-- So this is the dropbox, with a <button> in case of the user doesn't
// have icons. Yes. Think about Fvwm (Linux) users like me -->
// <div>DROP!<button onclick="document.querySelector('input').click()">Or click</button></div>
// <input style="visibility: collapse; width: 0px;" type="file" onchange="upload(this.files[0])">

// <!-- So here is the magic -->
// <script>

//     /* Drag'n drop stuff */
//     window.ondragover = function(e) {e.preventDefault()}
//     window.ondrop = function(e) {e.preventDefault(); upload(e.dataTransfer.files[0]); }
//     function upload(file) {

//         /* Is the file an image? */
//         if (!file || !file.type.match(/image.*/)) return;

//         /* It is! */
//         document.body.className = "uploading";

//         /* Lets build a FormData object*/
//         var fd = new FormData(); // I wrote about it: https://hacks.mozilla.org/2011/01/how-to-develop-a-html5-image-uploader/
//         fd.append("image", file); // Append the file
//         var xhr = new XMLHttpRequest(); // Create the XHR (Cross-Domain XHR FTW!!!) Thank you sooooo much imgur.com
//         xhr.open("POST", "https://api.imgur.com/3/image.json"); // Boooom!
//         xhr.onload = function() {
//             // Big win!
//             document.querySelector("#link").href = JSON.parse(xhr.responseText).data.link;
//             document.body.className = "uploaded";
//         }
        
//         xhr.setRequestHeader('Authorization', 'Client-ID 28aaa2e823b03b1'); // Get your own key http://api.imgur.com/
        
//         // Ok, I don't handle the errors. An exercise for the reader.

//         /* And now, we send the formdata */
//         xhr.send(fd);
//     }
// </script>

// <!-- Bla bla bla stuff ... -->

// <style>
//     body {text-align: center; padding-top: 100px;}
//     div { border: 10px solid black; text-align: center; line-height: 100px; width: 200px; margin: auto; font-size: 40px; display: inline-block;}
//     #link, p , div {display: none}
//     div {display: inline-block;}
//     .uploading div {display: none}
//     .uploaded div {display: none}
//     .uploading p {display: inline}
//     .uploaded #link {display: inline}
//     em {position: absolute; bottom: 0; right: 0}
// </style>

// <p>Uploading...</p>
// <a id="link">It's online!!!</a>

// <em>Look at the source code for more information. By <a href="http://twitter.com/paulrouget">@paulrouget</a>.</em>


