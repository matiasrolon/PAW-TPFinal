var PeliculaGenero = PeliculaGenero || {},
    document = document || {},
    window = window || {};


PeliculaGenero.getData = function (request) {
  request.open("GET", "/film-by-genre/"+PeliculaGenero.genre+"/"+PeliculaGenero.category+"/"+PeliculaGenero.offset+"/"+PeliculaGenero.elementsPerChunck, true);
  request.send();
  PeliculaGenero.offset += PeliculaGenero.elementsPerChunck;
}


PeliculaGenero.crearElemento = function (e, clss, inner){
  let p = document.createElement(e);
  if (clss != null)  {
    for (var i = 0; i < clss.length; i++) {
      p.classList.add(clss[i]);
    }
  }
  if (inner != null) p.innerHTML = inner;
  return p;
}

PeliculaGenero.buildGrid = function (response) {
  var resp = JSON.parse(response.responseText);
  console.log(resp);
  for (var ii in resp) {
    let puntaje = (resp[ii]['puntaje']).toFixed(1);
    let d = PeliculaGenero.crearElemento("div", ["flip-card"]);
    let e = PeliculaGenero.crearElemento("div", ["cuadro-film","flip-card-inner"]);
    let f = PeliculaGenero.crearElemento("div", ["flip-card-front"]);
    let g = PeliculaGenero.crearElemento("p", ["puntuacion"], puntaje);
    let h = PeliculaGenero.crearElemento("img", ["poster"]);
    h.setAttribute("src", "data:image/png;base64," + resp[ii]['poster']);
    let i = PeliculaGenero.crearElemento("a");
    let j = PeliculaGenero.crearElemento("div", ["flip-card-back"]);
    let k = PeliculaGenero.crearElemento("p", [], resp[ii]['fecha_estreno']);

    let l = PeliculaGenero.crearElemento("p", ["titulo-film"], resp[ii]['titulo']);
    let sin = resp[ii]['sinopsis'];
    sin = (sin.length > 90)? sin.substring(0, 89) + "..." : sin;
    let m = PeliculaGenero.crearElemento("p", [], sin);
    i.setAttribute("href", "/films/"+ resp[ii]['id']);

    // Corregido para que ande tambien en firefox
    f.appendChild(g);
    f.appendChild(h);
    j.appendChild(k);
    j.appendChild(l);
    j.appendChild(m);
    e.appendChild(f)
    e.appendChild(j);
    i.appendChild(e);
    d.appendChild(i);
    PeliculaGenero.containerCards.append(d);
  }

}

PeliculaGenero.getNextChunck = function(){
  var request = new XMLHttpRequest();
  request.onreadystatechange = function(){ // cuando la peticion cambia de estado.
      if (this.readyState==4 && this.status==200){ // si se recibe correctamente la respuesta.
          PeliculaGenero.buildGrid(this);
          FilmCardData.modificarPuntajeClase();
          PeliculaGenero.container.querySelector("#spinnerGenre").classList.add('no-visible');
      };
  }
  PeliculaGenero.getData(request);
}

PeliculaGenero.locked = false;

PeliculaGenero.getNextChunckScroll = function(event){

  if (PeliculaGenero.locked) return;
  else {
    var currScrTop = event.target.scrollingElement.scrollTop;
    console.log(currScrTop, PeliculaGenero.scrollTop);
    PeliculaGenero.locked = true;
    if (PeliculaGenero.scrollTop < currScrTop) {
      PeliculaGenero.container.querySelector("#spinnerGenre").classList.remove('no-visible');
      PeliculaGenero.scrollTop = currScrTop;
      PeliculaGenero.lastCall = setTimeout(() => {
        PeliculaGenero.getNextChunck();
        PeliculaGenero.locked = false;
      }, 600);
    }
 }
}

PeliculaGenero.initialize = function (genre, category, container) {
  PeliculaGenero.elementsPerChunck = 4;
  PeliculaGenero.offset = 0;
  PeliculaGenero.scrollTop = 0;
  PeliculaGenero.genre = genre;
  PeliculaGenero.category = category;
  PeliculaGenero.container = document.getElementById(container);
  PeliculaGenero.container.innerHTML = '';
  let nom = document.querySelector(".generos li div[value='"+PeliculaGenero.genre+"']").innerText;
  let a = PeliculaGenero.crearElemento("h3", [], "Top de Peliculas de "+nom+": ");
  PeliculaGenero.container.appendChild(a);
  let b = PeliculaGenero.crearElemento("div", ["container-peliculas-populares"]);
  let c = PeliculaGenero.crearElemento("div", ["loading-spin","no-visible"]);
  c.setAttribute('id','spinnerGenre');
  PeliculaGenero.containerCards = PeliculaGenero.crearElemento("section", ["peliculas"]);

  window.addEventListener("scroll",PeliculaGenero.getNextChunckScroll);
  b.appendChild(PeliculaGenero.containerCards);
  PeliculaGenero.container.appendChild(b);
  PeliculaGenero.container.appendChild(c);
  PeliculaGenero.getNextChunck();
  PeliculaGenero.getNextChunck();
}
