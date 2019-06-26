var window = window || {},
  document = document || {},
  console = console || {},
  AdminFilms = AdminFilms || {};

AdminFilms.iniciarPagina = function (contenedorHTML) {
  window.addEventListener("DOMContentLoaded", function () {
    console.log("Film_Profile asocio JS con HTML.");

    AdminFilms.buscador = document.getElementById('buscadorFilms');

    AdminFilms.btnBuscador = document.getElementById('btnBuscadorFilms');
    AdminFilms.btnBuscador.addEventListener("click", AdminFilms.enviarRequestSearchFilmsAdmin);
  });
}

/*
Manda la request ajax para mostrar los films que coinciden con la busqueda diferenciando de donde vienen
(Si de la Api o la bd del sitio)
*/
AdminFilms.enviarRequestSearchFilmsAdmin = function () {
  if (AdminFilms.buscador.value != "") {
    var request = new XMLHttpRequest();
    request.onreadystatechange = function () { // cuando la peticion cambia de estado.

      //console.log("readystate buscar admin resultado: " + this.readyState);
      if (this.readyState == 4 && this.status == 200) { // si se recibe correctamente la respuesta.
        AdminFilms.recibirResponseSearchFilmsAdmin(this);
        console.log("estado de la peticion buscar admin resultado: " + this.status);

      };
    }
    //envio la request
    console.log("se va a enviar a '" + AdminFilms.buscador.value + "''");
    request.open("GET", "/admin/searchFilms/" + AdminFilms.buscador.value, true);
    request.send();
  }
}


/**
* Recibe las coincidencias con la busqueda, ya sea en la API como a nivel $localFilms
* 25/06/2019 -> modo de prueba, local funciona bien, para API falta parsear para mostrarlo.
*/
AdminFilms.recibirResponseSearchFilmsAdmin = function (response) {
  var resp = JSON.parse(response.responseText);
  //console.log("se recibio respuesta de searchLocalFilm 3 : "+ response.responseText[1].titulo);
  //console.log("se recibio respuesta de searchLocalFilm 4 : "+ response.responseText);
  //console.log("se recibio respuesta de searchLocalFilm 5 : "+ response[1].titulo);
  console.log("se recibio respuesta de searchLocalFilm 6 : " + resp);
  //console.log("se recibio respuesta de searchLocalFilm 7 : "+ resp[1].titulo);

  // resp es un arreglo de objetos
  var divResultados = document.getElementsByClassName('resultados')[0];

  // Agrego cada resultado al contenedor
  resp.forEach(function (value, index, array) {
    var resultado = document.createElement('div');
    resultado.classList.add('resultado');
    resultado.id = "r" + index.toString();

    // Primero recupero el poster. Podria ser async?
    var poster = document.createElement('img');
    poster.classList.add('poster');
    poster.src = value['poster'];
    poster.alt = 'Poster';
    resultado.appendChild(poster);

    // En vez de hacer un for podria hacerse a mano, eligiendo solo lo que queremos mostrar
    // Ej la imagen.
    // Cada value es un objeto Film
    // Itero sobre los films
    for (f in value) {
      // console.log(f + " - " + value[f]);
      if (f != 'poster') {
        var encabezado = document.createElement('h4');
        encabezado.classList.add('encabezado-resultado');
        encabezado.innerHTML = f; // Ej: 'titulo'
        resultado.appendChild(encabezado);

        var cuerpo = document.createElement('p');
        cuerpo.classList.add('cuerpo-resultado');
        cuerpo.innerHTML = value[f]; // EJ: 'Buscando a nemo'
        resultado.appendChild(cuerpo);
      }
    }

    // Lo agrego al contenedor
    divResultados.appendChild(resultado);
  });

}
