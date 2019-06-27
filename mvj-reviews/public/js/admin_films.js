var window = window || {},
  document = document || {},
  console = console || {},
  AdminFilms = AdminFilms || {};

AdminFilms.iniciarPagina = function (contenedorHTML) {
  window.addEventListener("DOMContentLoaded", function () {
    console.log("Film_Profile asocio JS con HTML.");

    AdminFilms.buscador = document.getElementById('buscadorFilms');

    AdminFilms.btnBuscador = document.getElementById('btnBuscadorFilms');
    AdminFilms.btnBuscador.addEventListener("click", function(){
      //Se podria seleccionar acorde a lo que haya filtrado en el select de busqueda. Se deja generico por ahora.
      AdminFilms.enviarRequestSearchFilmsAdmin('API');
      AdminFilms.enviarRequestSearchFilmsAdmin('DB');
    });

  });
}

/*
Manda la request ajax para mostrar los films que coinciden con la busqueda diferenciando de donde vienen
(Si de la Api o la bd del sitio)
*/
AdminFilms.enviarRequestSearchFilmsAdmin = function (origen) {
  if (AdminFilms.buscador.value != "") {
    var request = new XMLHttpRequest();
    request.onreadystatechange = function () { // cuando la peticion cambia de estado.

      //console.log("readystate buscar admin resultado: " + this.readyState);
      if (this.readyState == 4 && this.status == 200) { // si se recibe correctamente la respuesta.
        AdminFilms.recibirResponseSearchFilmsAdmin(this,origen);
        console.log("estado de la peticion buscar admin resultado: " + this.status);

      };
    }
    //envio la request
    console.log("se va a enviar a '" + AdminFilms.buscador.value + "''");
    if (origen=='API'){  request.open("GET", "/admin/searchFilms/API/" + AdminFilms.buscador.value, true);
    }else{ request.open("GET", "/admin/searchFilms/DB/" + AdminFilms.buscador.value, true);}
    request.send();
  }
}


/**
* Recibe las coincidencias con la busqueda, ya sea en la API como a nivel $localFilms
* Se agrego el parametro ORIGEN para actuar al respecto dependiendo si viene de la API o de la BD
* (Ejemplo: SRC del poster, proximamente clases para distingir una de otra via CSS,etc).
*/
AdminFilms.recibirResponseSearchFilmsAdmin = function (response,origen) {
  var resp = JSON.parse(response.responseText);
  console.log("se recibio respuesta de searchLocalFilm. ");
  // resp es un arreglo de objetos
  var divResultados = document.getElementsByClassName('resultados-obtenidos')[0];
//Seteo parametros que seran asignados luego
  var base64 = "";
  var clase_resultado_obtenido;
  if (origen=='DB'){
    base64 = 'data:image/png;base64,';
    clase_resultado_obtenido = 'interno';
  }else{
    base64="";
    clase_resultado_obtenido = 'externo';
  }

  // Agrego cada resultado al contenedor
  resp.forEach(function (value, index, array) {
    var resultado = document.createElement('div');
    resultado.classList.add('resultado-obtenido');
    resultado.id = "r" + index.toString();

    if (index % 5 == 0 ){ //para las imagenes del principio de cada fila.
        resultado.classList.add('ini-fila');
    }
    // Primero recupero el poster.
    var poster = document.createElement('img');
    poster.classList.add('poster');
    if (typeof value['poster'] !== 'undefined'){ //a veces no carga la imagen proveniente de la api
        value['poster'] = base64 + value['poster'];
        poster.src = value['poster'];
    }else{//establece una por defecto
        poster.src = 'https://rimage.gnst.jp/livejapan.com/public/img/common/noimage.jpg';
    }
    poster.alt = 'Poster';
    resultado.appendChild(poster);

    //cargo los datos en el cuadro principal de ABM al hacer click sobre la imagen
    resultado.addEventListener("click",function(){
        AdminFilms.establecerResultadoSeleccionado(value,origen);
    });

    // Lo agrego al contenedor
    divResultados.appendChild(resultado);
  });

}

/* en los textarea del resultado seleccionado inserto los valores de la imagen ticleada.
* ademas, segun sea de BD o de API, habilito y desabilito botones de ABM. (Ideal tambien validar por backend)
* si es de BD habilita textareas para poder modificar
*/
AdminFilms.establecerResultadoSeleccionado = function(resultado,origen){

    var info = '.admin-resultados .resultado-seleccionado .info .campo';
        var textarea = document.querySelector(info + ' .titulo');
        textarea.innerHTML = resultado['titulo'];
        var textarea = document.querySelector(info + ' .sinopsis');
        textarea.innerHTML = resultado['sinopsis'];
        var textarea = document.querySelector(info + ' .categoria');
        textarea.innerHTML = resultado['categoria'];
        var textarea = document.querySelector(info + ' .pais');
        textarea.innerHTML = resultado['pais'];
        var textarea = document.querySelector(info + ' .fecha-estreno');
        textarea.innerHTML = resultado['fecha_estreno'];
        var textarea = document.querySelector(info + ' .duracion-min');
        textarea.innerHTML = resultado['duracion_min'];
    var poster = '.admin-resultados .resultado-seleccionado .poster img';
    var poster = document.querySelector(poster);
    poster.src = resultado['poster'];

    var btnGuardar = document.querySelector('.resultado-seleccionado .opciones .boton-guardar');
    var btnModificar = document.querySelector('.resultado-seleccionado .opciones .boton-modificar');
    var btnEliminar = document.querySelector('.resultado-seleccionado .opciones .boton-eliminar');

    if (origen=='API'){
        btnGuardar.setAttribute('disabled','true');
        btnModificar.setAttribute('enabled','true');
        btnEliminar.setAttribute('disabled','true');
    }else{
      if (origen=='BD'){
            btnGuardar.setAttribute('enabled','false');
            btnModificar.setAttribute('enabled','true');
            btnEliminar.setAttribute('enabled','true')
      }
    }

}
