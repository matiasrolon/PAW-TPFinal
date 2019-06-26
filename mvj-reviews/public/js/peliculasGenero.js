var PeliculaGenero = PeliculaGenero || {};


PeliculaGenero.getNextChunck = function (request) {
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
  let x = PeliculaGenero.container;
  x.innerHTML = '';
  let a = PeliculaGenero.crearElemento("h3", [], "Top de Peliculas del genero: ");
  let b = PeliculaGenero.crearElemento("div", ["container-peliculas-populares"]);
  let c = PeliculaGenero.crearElemento("section", ["peliculas"]);
  b.appendChild(c);
  for (var ii in resp) {
    let d = PeliculaGenero.crearElemento("div", ["flip-card"]);
    let e = PeliculaGenero.crearElemento("div", ["cuadro-film","flip-card-inner"]);
    let f = PeliculaGenero.crearElemento("div", ["flip-card-front"]);
    let g = PeliculaGenero.crearElemento("p", ["puntuacion","puntuacion-muy-buena"], (resp[ii]['puntaje']).toFixed(1));
    let h = PeliculaGenero.crearElemento("img", ["poster"]);
    h.setAttribute("src", "data:image/png;base64," + resp[ii]['poster']);
    let i = PeliculaGenero.crearElemento("a");
    let j = PeliculaGenero.crearElemento("div", ["flip-card-back"]);
    let k = PeliculaGenero.crearElemento("p", [], resp[ii]['fecha_estreno']);
    let l = PeliculaGenero.crearElemento("p", ["titulo-film","puntuacion-muy-buena"], resp[ii]['titulo']);
    let m = PeliculaGenero.crearElemento("p", [], resp[ii]['sinopsis']);
    i.setAttribute("href", "/films/"+ resp[ii]['id']);
    f.appendChild(g);
    f.appendChild(h);
    j.appendChild(k);
    j.appendChild(l);
    j.appendChild(m);
    i.appendChild(j);
    e.appendChild(f);
    e.appendChild(j);
    d.appendChild(e);
    c.append(d);
  }
  x.appendChild(a);
  x.appendChild(b);
}

PeliculaGenero.initialize = function (genre, category, container) {
  PeliculaGenero.elementsPerChunck = 5;
  PeliculaGenero.offset = 0;
  PeliculaGenero.genre = genre;
  PeliculaGenero.category = category;
  PeliculaGenero.container = document.getElementById(container);
  var request = new XMLHttpRequest();
  request.onreadystatechange = function(){ // cuando la peticion cambia de estado.
      if (this.readyState==4 && this.status==200){ // si se recibe correctamente la respuesta.
          PeliculaGenero.buildGrid(this);
      };
  }
  PeliculaGenero.getNextChunck(request);
}
