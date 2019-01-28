$ = (el) => document.querySelector(el);
$$ = (el) => document.querySelectorAll(el);

var mapPosPoints = new Map();
var addPoint=true;

document.addEventListener('keypress', (event) => {
  const Touche = event.key;
    if(Touche=='a' && addPoint){
      addPann = false;
      var point = document.createElement("a-entity");
      point.setAttribute("template", "src: #template");
      point.setAttribute("data-target", "");
      point.setAttribute("position", "0 0 -5");
      $("#camera").appendChild(point);

      window.addEventListener('mousewheel', (event) => {
            var scroll = event.deltaY/100;
            scrollDown = scroll > 0;
            scrollUp = scroll < 0;
            pos = point.getAttribute("position");
            if((pos.z>=-2 && scrollUp) || (pos.z<=-30 && scrollDown) || (pos.z<-2 && pos.z>-30)){
              pos.z = pos.z+scroll;
            }
            point.setAttribute("position",pos);
          });

      document.addEventListener('keypress', (event) => {
        if(event.key=='a'){
          var dist = -point.getAttribute("position").z;
          var angle = ($("#camera").getAttribute("rotation").y+$("#cameraRotation").getAttribute("rotation").y) * Math.PI / 180;
          var xPos = -dist*Math.sin(angle);
          var zPos = -dist*Math.cos(angle);
          var angleX = ($("#camera").getAttribute("rotation").x+$("#cameraRotation").getAttribute("rotation").x) * Math.PI / 180;
          var yPos = dist*Math.tan(angleX);
          $("#camera").removeChild(point);
          ajouterPointInteret(`${xPos} ${yPos} ${zPos}`);
          addPoint = true;
        }
      });
    }
  if(Touche=='p' && addPoint){
    var dist = 5;
    window.addEventListener('mousewheel', (event) => {
      if(addPoint){
        //$("#"+idHud).removeAttribute("look-at");
        var scroll = event.deltaY/100;
        scrollDown = scroll > 0;
        scrollUp = scroll < 0;
        if((dist>=-2 && scrollUp) || (dist<=-30 && scrollDown) || (dist<-2 && dist>-30)){
          dist = dist-scroll;
        }
        var angle = ($("#camera").getAttribute("rotation").y+$("#cameraRotation").getAttribute("rotation").y) * Math.PI / 180;
        var xPos = -dist*Math.sin(angle);
        var zPos = -dist*Math.cos(angle);
        var yPos = dist*Math.tan(angleX);
        $("#"+idHud).setAttribute('position',`${xPos} ${yPos} ${zPos}`);
      }
    });
    if(Touche=='p'){
      var angle = ($("#camera").getAttribute("rotation").y+$("#cameraRotation").getAttribute("rotation").y) * Math.PI / 180;
      var xPos = -dist*Math.sin(angle);
      var zPos = -dist*Math.cos(angle);
      var angleX = (($("#camera").getAttribute("rotation").x+$("#cameraRotation").getAttribute("rotation").x) * Math.PI / 180);
      var yPos = dist*Math.tan(angleX);
      $("#"+idHud).setAttribute('position',`${xPos} ${yPos} ${zPos}`);
    }
  }
  if(Touche=='r'){
    var el = $("#cursor").components.raycaster.intersectedEls[0];
    if(el !== undefined){
      if(confirm("supprimer?")){
        supprimer(el);
      }
    }
  }
});


AFRAME.registerComponent('move', {
  schema: {
    on: {type: 'string'},
    target: {type: 'string'}
  },

  init: function(){
    //alert("coucou move");
    var data=this.data;
    var el=this.el;
    var originPlaceName = el.parentNode.parentNode.getAttribute('id');
    var targetElement=$(`#${data.target}`);
    var targetWorldPos = new THREE.Vector3();
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

        var elementToHaveInTheBack=elementInWithTarget(data.target, originPlaceName);
        if (typeof elementToHaveInTheBack !== 'undefined') {
          targetWorldPos.setFromMatrixPosition(elementToHaveInTheBack.object3D.matrixWorld);
          $("#cameraRotation").setAttribute("rotation", `0 ${Math.atan2(targetWorldPos.x, targetWorldPos.z)*(180/Math.PI)-$("#camera").getAttribute("rotation").y} 0`);
        }
        
        
        el.parentNode.parentNode.setAttribute('visible','false');       
        el.parentNode.parentNode.removeAttribute("current");
        targetElement.setAttribute('visible', 'true');
        targetElement.setAttribute("current","");
        $("#"+idHud).setAttribute('text','value', targetElement.getAttribute('description'));
        $("#cursor").setAttribute('raycaster', `objects: #${data.target}`);
      }
    );
  }
});

AFRAME.registerComponent('default', {
  schema: {
  },

  init: function(){
    //alert("coucou default");
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
    $("#"+idHud).setAttribute('text','value', el.getAttribute('description'));
    el.setAttribute('visible', 'true');
    el.setAttribute("current","");
    $("#cursor").setAttribute('raycaster', `objects: #${el.id}`);
  }
});

AFRAME.registerComponent('description', {
  schema: {type: 'string'}
  }
);

AFRAME.registerComponent('sourceimage', {
  schema: {type: 'string'},

  init: function(){
    //alert("coucou source");
    var div = document.createElement("div");
    div.setAttribute("id", this.el.getAttribute("id")+"Img");
    div.innerHTML=this.data;
    $("a-assets").appendChild(div);
  }
});

/*function getCookie(cname) {
  var name = cname + "=";
  var decodedCookie = decodeURIComponent(document.cookie);
  var ca = decodedCookie.split(';');
  for(var i = 0; i <ca.length; i++) {
    var c = ca[i];
    while (c.charAt(0) == ' ') {
      c = c.substring(1);
    }
    if (c.indexOf(name) == 0) {
      return c.substring(name.length, c.length);
    }
  }
  return "";
}*/

function ajouterPointInteret(pos){
    if(typeof(listImgs)=="undefined"){
      alert("Erreur");
      return;
    }
    var l = listImgs.split(':');
    var currentPlace = $(".imsky");
    var point = document.createElement("a-entity");
    point.setAttribute("template", "src: #template");
    var target = window.prompt("Destination ( nom de l'image (sans l'extension))?");
    if(target==null){
      return;
    }
    while(l.includes(target)==false){
      alert("Destination incorrect");
      var target = window.prompt("Destination ( nom de l'image (sans l'extension))?");
    }
    //alert(target);
    //alert(currentPlace.getAttribute("id"));
    if(target == currentPlace.getAttribute("id")){
      alert("impossible de mettre un point là ou on est déjà");
      return;
    }
    point.setAttribute("data-target", target);
    point.setAttribute("position", pos);
    currentPlace.appendChild(point);
    var lieuPresent = mapPosPoints.get(point.parentNode.getAttribute("id"));
    if(lieuPresent === undefined){
      mapPosPoints.set(point.parentNode.getAttribute("id"), new Map());
      lieuPresent = mapPosPoints.get(point.parentNode.getAttribute("id"));
    }
    lieuDest = lieuPresent.get(point.getAttribute("data-target"));
    if(lieuDest === undefined){
      lieuPresent.set(point.getAttribute("data-target"), pos);
    }
}

function supprimer(el){
  var lieuPresent = mapPosPoints.get(el.parentNode.parentNode.getAttribute("id"));
  if(lieuPresent !== undefined){
    lieuPresent.delete(el.parentNode.getAttribute("data-target"));
  }
  el.parentNode.parentNode.removeChild(el.parentNode);
}
