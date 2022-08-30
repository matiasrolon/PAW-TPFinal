const QUERY_PARAM_GENRE_ID = 'genreId';
const CATEGORY_MOVIES = 'Pelicula';
const CATEGORY_SERIES = 'Serie';

var document = document || {},
    window = window || {};

var PeliculaGenero = {
    chunkSize: 8,
    genreId: null,
};

var movies = {
    name: CATEGORY_MOVIES,
    offset: 0,
    hasMore: true,
    container: 'section-peliculas'
};

var series = {
    name: CATEGORY_SERIES,
    offset: 0,
    hasMore: true,
    container: 'section-series'
};


/**
 * Funcion de entrada.
 * Inicializa variables.
 * */
PeliculaGenero.load =  function() {
    var elements = document.querySelectorAll("#section-peliculas div.flip-card");
    movies.offset = elements.length;
    if (elements.length == 0 || elements.length < PeliculaGenero.chunkSize)
        document.getElementById('btn-fetch-movies').classList.add('no-visible');

    elements = document.querySelectorAll("#section-series div.flip-card");
    series.offset = elements.length;
    if (elements.length == 0 || elements.length < PeliculaGenero.chunkSize)
        document.getElementById('btn-fetch-series').classList.add('no-visible');

    if (PeliculaGenero.genreId == null) {
        if ('URLSearchParams' in window) {
            var searchParams = new URLSearchParams(window.location.search);
            var genreId = searchParams.get(QUERY_PARAM_GENRE_ID);
            if (genreId !== null)
                PeliculaGenero.genreId = genreId;
            else {
                // Si no hay filtro por genero...
                document.getElementById('btn-fetch-movies').classList.add('no-visible');
                document.getElementById('btn-fetch-series').classList.add('no-visible');
            }
        } else {
            // Browser does not support "URLSearchParams"
            console.error('Actualice su navegador para utilizar este sitio');
        }
    }
}

/**
 * Hace la request para cargar mas elemento y parsea la respuesta
 * @param {String} category "Pelicula" o "Serie"
 */
PeliculaGenero.fetchFilms = function(category) {
    var cat = category == CATEGORY_MOVIES ? movies : series;
    PeliculaGenero.getNextChunk(cat);
}

PeliculaGenero.getNextChunk = (category) => {
    var request = new XMLHttpRequest();
    request.onreadystatechange = function() {
        if (this.readyState==4 && this.status==200) {
            var title = `Top de ${category.name}s de ${getGenreNameById(PeliculaGenero.genreId)}`;
            PeliculaGenero.updateTitle(category.name, title);

            var response = JSON.parse(this.responseText);
            if (category.name == CATEGORY_MOVIES) {
                if (response.length < PeliculaGenero.chunkSize)
                    document.getElementById('btn-fetch-movies').classList.add('no-visible');
                else
                    document.getElementById('btn-fetch-movies').classList.remove('no-visible');
            }
            if (category.name == CATEGORY_SERIES) {
                if (response.length < PeliculaGenero.chunkSize)
                    document.getElementById('btn-fetch-series').classList.add('no-visible');
                else
                    document.getElementById('btn-fetch-series').classList.remove('no-visible');
            }
            var container = document.getElementById(category.container);
            PeliculaGenero.buildGrid(response, container);
            FilmCardData.modificarPuntajeClase();
            showSpinner(false);
        };
    }

    showSpinner(true);
    request.open("GET", "/film-by-genre/"+PeliculaGenero.genreId+"/"+category.name+"/"+category.offset+"/"+PeliculaGenero.chunkSize, true);
    request.send();
    category.offset += PeliculaGenero.chunkSize;
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

PeliculaGenero.buildGrid = function (response, container) {
  console.log(response);
  for (var ii in response) {
    let puntaje = (response[ii]['puntaje']).toFixed(1);
    let d = PeliculaGenero.crearElemento("div", ["flip-card"]);
    let e = PeliculaGenero.crearElemento("div", ["cuadro-film","flip-card-inner"]);
    let f = PeliculaGenero.crearElemento("div", ["flip-card-front"]);
    let g = PeliculaGenero.crearElemento("p", ["puntuacion"], puntaje);
    let h = PeliculaGenero.crearElemento("img", ["poster"]);
    h.setAttribute("src", "data:image/png;base64," + response[ii]['poster']);
    let i = PeliculaGenero.crearElemento("a");
    let j = PeliculaGenero.crearElemento("div", ["flip-card-back"]);
    let k = PeliculaGenero.crearElemento("p", [], response[ii]['fecha_estreno']);

    let l = PeliculaGenero.crearElemento("p", ["titulo-film"], response[ii]['titulo']);
    let sin = response[ii]['sinopsis'];
    sin = (sin.length > 90)? sin.substring(0, 89) + "..." : sin;
    let m = PeliculaGenero.crearElemento("p", [], sin);
    i.setAttribute("href", "/films/"+ response[ii]['id']);

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
    container.append(d);
  }
}


/**
 * Coloca el filtro elegido por el usuario y actualiza las peliculas/series
 * @param {Number} genreId
 */
PeliculaGenero.setGenre = function (genreId) {
    if (genreId != null) {
        document.getElementById('section-peliculas').innerHTML = '';
        document.getElementById('section-series').innerHTML = '';

        updateQueryString(QUERY_PARAM_GENRE_ID, genreId);
        PeliculaGenero.genreId = genreId;

        movies.offset = 0;
        PeliculaGenero.fetchFilms(CATEGORY_MOVIES);
        series.offset = 0;
        PeliculaGenero.fetchFilms(CATEGORY_SERIES);
    }
}

PeliculaGenero.updateTitle = (category, text) => {
    if (category === CATEGORY_MOVIES)
        var title = document.getElementById('movies-title');
    else
        var title = document.getElementById('series-title');

    title.innerText = text;
}

function updateQueryString(key, value) {
    if ('URLSearchParams' in window) {
        var searchParams = new URLSearchParams(window.location.search)
        searchParams.set(key, value);
        var newRelativePathQuery = window.location.pathname + '?' + searchParams.toString();
        history.pushState(null, '', newRelativePathQuery);
    } else {
        // Browser does not support "URLSearchParams"
        console.error('Error al filtrar las peliculas por genero');
    }
}

function getGenreNameById(id) {
    return document.querySelector(".generos li[value='"+id+"']").innerText;
}

function showSpinner(show) {
    if (show)
        document.getElementById("spinner-genre").classList.remove('no-visible');
    else
        document.getElementById("spinner-genre").classList.add('no-visible');
}
