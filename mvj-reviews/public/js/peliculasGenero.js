var PeliculaGenero = PeliculaGenero || {};


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
  console.log(response);
  var resp = JSON.parse(response.responseText);
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
    let m = PeliculaGenero.crearElemento("p", [], resp[ii]['sinopsis']);
    i.setAttribute("href", "/films/"+ resp[ii]['id']);
    f.appendChild(g);
    f.appendChild(h);
    j.appendChild(k);
    j.appendChild(l);
    j.appendChild(m);
    i.appendChild(j);
    e.appendChild(i);
    e.appendChild(f);
    d.appendChild(e);
    PeliculaGenero.containerCards.append(d);
  }

}

PeliculaGenero.getNextChunck = function(){
  var request = new XMLHttpRequest();
  request.onreadystatechange = function(){ // cuando la peticion cambia de estado.
      if (this.readyState==4 && this.status==200){ // si se recibe correctamente la respuesta.
          PeliculaGenero.buildGrid(this);
      };
  }
  PeliculaGenero.getData(request);
}

PeliculaGenero.getNextChunckScroll = function(){
  setTimeout(PeliculaGenero.getNextChunck, 400);
}

PeliculaGenero.initialize = function (genre, category, container) {
  PeliculaGenero.elementsPerChunck = 5;
  PeliculaGenero.offset = 0;
  PeliculaGenero.genre = genre;
  PeliculaGenero.category = category;
  PeliculaGenero.container = document.getElementById(container);
  PeliculaGenero.container.innerHTML = '';
  let nom = document.querySelector(".generos li div[value='"+PeliculaGenero.genre+"']").innerText;
  let a = PeliculaGenero.crearElemento("h3", [], "Top de Peliculas de "+nom+": ");
  PeliculaGenero.container.appendChild(a);
  let b = PeliculaGenero.crearElemento("div", ["container-peliculas-populares"]);
  PeliculaGenero.containerCards = PeliculaGenero.crearElemento("section", ["peliculas-genero"]);
  PeliculaGenero.containerCards.setAttribute("onscroll","PeliculaGenero.getNextChunckScroll()");
  b.appendChild(PeliculaGenero.containerCards);
  PeliculaGenero.container.appendChild(b);
  PeliculaGenero.getNextChunck();
}
