var window = window || {},
  document = document || {},
  console = console || {},
  AdminFilms = AdminFilms || {};
  idTheMovieDb = '';

const GENERIC_IMAGE_URL = '/images/noimage.jpg';

AdminFilms.iniciarPagina = function (contenedorHTML) {
  window.addEventListener("DOMContentLoaded", function () {
    console.log("Film_Profile asocio JS con HTML.");

    AdminFilms.buscador = document.getElementById('buscadorFilms');
    AdminFilms.btnBuscador = document.getElementById('btnBuscadorFilms');
    AdminFilms.btnBuscador.addEventListener("click", function(){

      // Primero elimino los resultados de la busqueda anterior.
            var seccionResultados = document.querySelector('.resultados-obtenidos');
            var resultadosAnt = document.querySelectorAll('.resultados-obtenidos .resultado-obtenido');
            if (resultadosAnt.length > 0){
              resultadosAnt.forEach(function (resultAnt) {
                seccionResultados.removeChild(resultAnt);
              });
            }

            // Oculto la seccion de resutado seleccionado
            AdminFilms.mostrarResultadoSeleccionado(false);

            // Selector del motor de busqueda
            var select = document.getElementById('src-selector');
            console.log('src-selector: ' + select.value);
            if (select.value == 'TheMovieDB' || select.value == 'Ambos') {
              AdminFilms.enviarRequestSearchFilmsAdmin('API');
            }
            if (select.value == 'MVJ Reviews' || select.value == 'Ambos') {
              AdminFilms.enviarRequestSearchFilmsAdmin('DB');
            }
    });

    AdminFilms.cargarFuncionalidadABM();
    AdminFilms.cargarFuncionalidadPendentSearches();

    window.scrollTo(0,0);
  });
}

/* PENDENT SEARCHES */

/**
 * Carga la funcionalidad para el boton "Resolver" de cada busqueda pendiente.
 */
AdminFilms.cargarFuncionalidadPendentSearches = function() {
  var busqPendientes = document.querySelectorAll(".pendientes .busqueda");
  // console.log('Entro al foreach de cargarFuncionalidadPendentSearches');
  busqPendientes.forEach(function (busqueda) {
    var keyword = busqueda.getAttribute('text');
    // console.log('keyword: ' + keyword);

    // Boton de RESOLVER
    busqueda.querySelector('.button1').addEventListener('click', function() {

      var request = new XMLHttpRequest();
      request.onreadystatechange = function() {
        // console.log("estado del ajax post: " + this.status +': ' + this.responseText);

        if (this.readyState==4 && this.status==200) {
          // Para la animacion
          busqueda.classList.add('removed');
          busqueda.addEventListener('transitionend', function() {
            // console.log('chau');
            // Borro la pendent search del HTML
            this.remove();
          });

        } else if (this.readyState == 4 && this.status == 404) {
          console.log('eliminarPendentSearch ERROR: ' + this.responseText);
        }
      }
      request.open('POST', '/admin/solvePendentFilm', true);
      // Sin esto tira HTTP STATUS 419
      request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      request.setRequestHeader('X-CSRF-Token', $('meta[name="csrf-token"]').attr('content'));
      var json = {'searchText':keyword};
      // console.log('Sending request: ' + JSON.stringify(json));
      request.send('objeto=' + JSON.stringify(json) );

    }); // FIN DEL BOTON RESOLVER
  });
}

/**
 * Hace la peticion para eliminar la busqueda via AJAX.
 */
/*
AdminFilms.eliminarPendentSearch = function (keyword) {
  // console.log('Entro a eliminarPendentSearch');
  var request = new XMLHttpRequest();
  request.onreadystatechange = function() {
    // console.log("estado del ajax post: " + this.status +': ' + this.responseText);

    if (this.readyState==4 && this.status==200) {
      // Busco el div que tengo que borrar
      // console.log('entro aqui');
      var busqPendientes = document.querySelectorAll(".pendientes .busqueda");
      busqPendientes.forEach(function (busqueda) {
        // console.log('keywordd= ' + keyword);
        if (busqueda.getAttribute('text') == keyword) {
          // console.log('busqueda.getAttribute(text)= ' + busqueda.getAttribute('text'));
          // Borro la pendent search del HTML
          busqueda.classList.add('removed');
          busqueda.addEventListener('transitionend', function() {
            // console.log('chau');
            this.remove();
          })
        }
      });

    } else if (this.readyState == 4 && this.status == 404) {
      console.log('eliminarPendentSearch ERROR: ' + this.responseText);
    }
  }
  request.open('POST', '/admin/solvePendentFilm', true);
  // Sin esto tira HTTP STATUS 419
  request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  request.setRequestHeader('X-CSRF-Token', $('meta[name="csrf-token"]').attr('content'));
  var json = {'searchText':keyword};
  request.send('objeto=' + JSON.stringify(json) );
}
*/

// Funcion: agrega funcionalidad a los botones ni bien se carga la pagina.
AdminFilms.cargarFuncionalidadABM = function(){
  // Cuando presiono el boton modificar: permito editar los campos
  var btnModificar = document.querySelector('.resultado-seleccionado .opciones .boton-modificar');
  btnModificar.addEventListener("click", function(){
      // var campos  = document.querySelectorAll('.resultado-seleccionado .info .campo textarea');
      var campos  = document.querySelectorAll('.resultado-seleccionado .info .campo .editable');
      campos.forEach(function(campo){
        campo.removeAttribute('disabled');
        campo.setAttribute('enabled','true');
      });

      // Caso especial: la cruz en cada genero
      var cruces = document.querySelectorAll('.resultado-seleccionado .campo .cruz');
      cruces.forEach(function(cruz) {
        cruz.style.display = 'inline-block';
      });
  });

  var btnGuardar = document.querySelector('.resultado-seleccionado .opciones .boton-guardar');
  btnGuardar.addEventListener("click",function(){
        //empiezo request ajax
        var request = new XMLHttpRequest();
        // Prueba
        // request.responseType = 'json';
        request.onreadystatechange = function(){ // cuando la peticion cambia de estado.
          console.log("estado del ajax post: " + this.status);
          // if (this.readyState==4 && this.status==200){ // si se recibe correctamente la respuesta.
          if (this.readyState==4) {
              AdminFilms.recibirResponseStoreFilm(this);
          };
        }
        AdminFilms.enviarRequestStoreFilm(request);
  });

  var btnEliminar = document.querySelector('.resultado-seleccionado .opciones .boton-eliminar');
  btnEliminar.addEventListener('click', function() {
    var request = new XMLHttpRequest();
    request.onreadystatechange = function(){ // cuando la peticion cambia de estado.
      console.log("estado del ajax post: " + this.status);
      if (this.readyState==4) {
          AdminFilms.recibirResponseDeleteFilm(this);
      };
    }
    // Selecciono el id de la pelicula a borrar. Lo obtengo del div
    var div = document.querySelector('.admin-resultados .resultado-seleccionado .info');
    var filmID = div.getAttribute('id');
    console.log('Se va a borrar el film con id=' + filmID);

    request.open('GET', '/delete/' + filmID);
    request.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
    request.send();

  });

  // Boton de agregar genero
  var btnGenero = document.getElementById('agregar-genero');
  var selectGen = document.getElementById('generos');
  btnGenero.addEventListener('click', function() {
    AdminFilms.agregarGenero(selectGen.value);
  });
}

/**
 * Funcion que devuelve los generos para el resultado seleccionado.
 * Se utilizada para guardar los datos en la BD
 * @returns Array of String con los nombres de cada genero.
 */
AdminFilms.getListaGeneros = function() {
  var lista = document.querySelector('.resultado-seleccionado .info .campo .genero');
  lista = lista.getElementsByTagName('li');
  console.log('Lista de generos:');
  var resp = Array();
  for (var i=0; i < lista.length; i++) {
    // console.log("item: " + lista[i]);
    // console.log("innerText: " + lista[i].innerText);
    resp[i] = lista[i].innerText;
  }
  console.log(resp);
  return resp;
}


/**
 * Funcion: crea el objeto ajax que recibira la funcion store de FilmController
 * Me costo un huevo encontrar como era: https://developer.mozilla.org/en-US/docs/Web/API/FormData/Using_FormData_Objects
 */
AdminFilms.enviarRequestStoreFilm = function(request){
    var info = '.resultado-seleccionado .info .campo ';

    var film = {
        "origen": document.querySelector('.resultado-seleccionado .info').getAttribute('origen'),
        "id": document.querySelector('.resultado-seleccionado .info').getAttribute('id'),
        "titulo": document.querySelector(info+'.titulo').value,
        "sinopsis": document.querySelector(info+'.sinopsis').value,
        "categoria": document.querySelector(info+'.categoria').value,
        "fecha_estreno": document.querySelector(info+'.fecha-estreno').value,
        "fecha_finalizacion": document.querySelector(info + '.fecha-finalizacion').value,
        "poster": document.querySelector('.resultado-seleccionado .poster img').getAttribute('path'),
        "genero": AdminFilms.getListaGeneros(),
        "pais": document.querySelector(info+'.pais').value,
        "duracion_min": document.querySelector(info+'.duracion-min').value,
        "trailer": document.querySelector(info + '.trailer-url').value,
        "id_themoviedb": idTheMovieDb   // Tomo la id de la variable global.
    };

    if (film.id === "-1")
        request.open("POST", "/films", true);
    else
        request.open("PUT", "/films", true);

    // Para que Laravel responda con un JSON y un HTTP 422 cuando algun campo es invalido
    request.setRequestHeader('Accept', 'application/json');
    request.setRequestHeader("Content-type", "application/json");
    request.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
    request.send(JSON.stringify(film));
}


AdminFilms.recibirResponseDeleteFilm = function(response) {
  console.log('recibi respuesta de ajax post delete film. Status: ' + response.status);
  AdminFilms.borrarMensajes();
  var ulMensajes = document.getElementById('mensajes');
  var liMsj = document.createElement('li');

  if (response.status == 200) {
    // Este no se si andara
    var resp = JSON.parse(response.responseText);
    liMsj.classList.add('resultado-Ok');
    liMsj.innerText = resp['mensaje'];

  } else if (response.status == 409) {
    liMsj.classList.add('resultado-Failed');
    liMsj.innerText = response.responseText;

  } else {
    // Error desconocido
    liMsj.classList.add('resultado-Failed');
    liMsj.innerText = 'Error del servidor.';
  }
  AdminFilms.borrarOnClick(liMsj);
  ulMensajes.appendChild(liMsj);

  console.log("DELETE.responseText: " + response.responseText);
}

/*
Funcion: Recibe la respuesta de la operacion y muestra el resultado acorde en pantalla
         Si la operacion fue exitosa, actualiza atributos de los elementos.
*/
AdminFilms.recibirResponseStoreFilm = function(response){
  console.log('recibi respuesta de ajax post store film. Status: ' + response.status);
  let poster = document.querySelector('.admin-resultados .resultado-seleccionado .poster');
  // var ulMensajes = document.querySelector('admin-resultados .resultado-seleccionado .poster ul');
  ulMensajes = document.getElementById('mensajes');
  AdminFilms.borrarMensajes();


  // Cuando laravel genera un error, devuelve status = 500
  // console.log("response.status: " + response.status);
  // console.log("ResponseType: " + response.responseType);
  // var respType = response.getResponseHeader('Content-Type');
  // console.log("RespType: " + respType);
  // Si respType es 'text/html; charset=UTF-8' es que hubo un error, ya que espero un 'application/json'
  if (response.responseText != null && response.status == 200) {
    console.log("Response: " + response.responseText);
    var resp = JSON.parse(response.responseText);

    console.log("se recibio respuesta> se grabo la peli con el id="+ resp['id']);
    /*
    if (resp['estado']='OK'){
      par.classList.add('resultado-Ok');
      document.querySelector('.admin-resultados .resultado-seleccionado .info')
        .setAttribute('id',resp['id']);
    }else{
      // Atrapa errores contemplados por el programador en FilmController
      par.classList.add('resultado-Failed');
      //con css mostrar algo en rojo, o campos erroneos (cuando ande validar en el back)
    }

    par.innerText = resp['mensaje'];
    p.appendChild(par);
    */

    // par.classList.add('resultado-Ok');
    document.querySelector('.admin-resultados .resultado-seleccionado .info')
      .setAttribute('id',resp['id']);
    var liMsj = document.createElement('li');
    liMsj.classList.add('resultado-Ok');
    liMsj.innerText = resp['mensaje'];
    AdminFilms.borrarOnClick(liMsj);
    ulMensajes.appendChild(liMsj);


  } else if (response.status == 422) {
    // Status 422 = Error al validar algun campo
    // par.classList.add('resultado-Failed');
    // par.innerText = 'Error: ';
    var resp = JSON.parse(response.responseText);
    for (var campo in resp.errors) {
      console.log('msj: ' + resp.errors[campo][0]);
      var liMsj = document.createElement('li');
      liMsj.classList.add('resultado-Failed');
      liMsj.innerText += resp.errors[campo][0];
      AdminFilms.borrarOnClick(liMsj);
      ulMensajes.appendChild(liMsj);
    }

  } else {

    // Atrapa errores generados por laravel
    console.log('ERROR. Response: ' + response);
    console.log("Response: " + response.responseText);

    var liMsj = document.createElement('li');
    liMsj.classList.add('resultado-Failed');
    liMsj.innerText = 'Error del servidor.';
    AdminFilms.borrarOnClick(liMsj);
    ulMensajes.appendChild(liMsj);

    // p.appendChild(par);
  }

  // Agrego el mensaje
  poster.appendChild(ulMensajes);
  // Borro el mensaje a los 5 segundos
  /*
  setTimeout(function() {
    AdminFilms.borrarMensajes();
  }, 5000);
  */

  // Reemplazarla x que se borre cada mensaje al hacerle click encima
  /*
  ulMensajes.addEventListener('click', function() {
    AdminFilms.borrarMensajes();
  });
  */
}

/**
 * Borra los mensajes de exito o error que aparecen bajo el poster
 * Nuevo: borra los mensajes de que no hubo coincidencias.
 */
AdminFilms.borrarMensajes = function() {
  // var ulMensajes = document.querySelector('.admin-resultados .resultado-seleccionado .poster p');
  var lis = document.getElementById('mensajes').getElementsByTagName('li');
  if ( lis != null ) {
    for (var index = 0; index < lis.length; index++) {
      lis[index].remove();
    }
  } else {
    console.log('no se encontraron li(s).');
  }

  // Borra mensajes de que no hubo coincidencias
  var msjs = document.querySelectorAll('.sin-resultados');
  var i = 0;
  for (i=0; i < msjs.length; i++) {
    msjs[i].remove();
  }
}

AdminFilms.borrarOnClick = function(elemento) {
  if (elemento) {
    elemento.addEventListener('click', function() {
      this.classList.add('removed');
      this.addEventListener('transitionend', function() {
        // Este this esta en otro contexto
        this.remove();
      });
    });
  }
}

/*
Funcion: Manda la request ajax para mostrar los films que coinciden con la busqueda diferenciando
         de donde vienen (Si de la Api o la bd del sitio)
*/
AdminFilms.enviarRequestSearchFilmsAdmin = function (origen) {
  if (AdminFilms.buscador.value != "") {
    var request = new XMLHttpRequest();
    request.onreadystatechange = function () { // cuando la peticion cambia de estado.
      console.log('Recibi respuesta de la ' + origen + '. Estado: ' + this.status);
      //console.log("readystate buscar admin resultado: " + this.readyState);
      if (this.readyState == 4 && this.status == 200) { // si se recibe correctamente la respuesta.
        AdminFilms.recibirResponseSearchFilmsAdmin(this,origen);
        // console.log("estado de la peticion buscar admin resultado: " + this.status);

      } else {
        // console.log('Error: Recibi respuesta de la '+ origen +'. Estado: '+ this.status + '. ReadyState: '+ this.readyState);
      }
    }

    if (origen=='API'){
        request.open("GET", "/admin/searchFilms/API/" + AdminFilms.buscador.value, true);
            //envio la request
        console.log("Enviada request" + AdminFilms.buscador.value + " a la API.");
    } else {
        request.open("GET", "/admin/searchFilms/DB/" + AdminFilms.buscador.value, true);
        console.log("Enviada request" + AdminFilms.buscador.value + " a la DB");
    }
    request.send();
  }
}


/**
* Funcion: Recibe las coincidencias con la busqueda, ya sea en la API como a nivel $localFilms
* Se agrego el parametro ORIGEN para actuar al respecto dependiendo si viene de la API o de la BD
* (Ejemplo: SRC del poster, clases para distingir una de otra via CSS,etc).
*/
AdminFilms.recibirResponseSearchFilmsAdmin = function (response,origen) {
  if (response.status !== 200) {
    // TODO: Pregunto el codigo, o sencillamente manejo errores

  } else {
    // HTTP 200 OK
    var resp = JSON.parse(response.responseText);
    console.log('RESP(' + ') = ' + resp);
    console.log("se recibio respuesta de searchLocalFilm. ");
    // resp es un arreglo de objetos
    var divResultados = document.getElementsByClassName('resultados-obtenidos')[0];
    var base64 = "";
    var clase_resultado_obtenido;
    //Seteo parametros que seran asignados luego
    if (origen=='DB'){
      base64 = 'data:image/png;base64,';
      clase_resultado_obtenido = 'interno';
    }else{
      base64="";
      clase_resultado_obtenido = 'externo';
    }

    console.log('resp.length (' + origen +') = ' + resp.length);
    // Agrego cada resultado al contenedor
    if (resp.length>0){
        console.log('Cargo respuesta de ' + origen);
        resp.forEach(function (value, index) {

          // console.log('FILM ' + index + ' POSTER --> ' + value['poster']);

          var resultado = document.createElement('div');
          resultado.classList.add('resultado-obtenido');
          resultado.id = "r" + index.toString();

          if (index % 5 == 0 ){ //para las imagenes del principio de cada fila.
              resultado.classList.add('ini-fila');
          }
          // Primero recupero el poster.
          var poster = document.createElement('img');
          poster.classList.add('poster');

          if (value['poster'] != '') {
              poster.src = base64 + value['poster'];
          } else {
              poster.src = GENERIC_IMAGE_URL;
          }

          poster.alt = 'Poster';
          poster.setAttribute('path',value['poster']);
          resultado.appendChild(poster);
          resultado.classList.add(origen);//para distinguir via CSS las que vienen de API de las que vienen de BD
          //cargo los datos en el cuadro principal de ABM al hacer click sobre la imagen
          resultado.addEventListener("click",function(){
              AdminFilms.mostrarResultadoSeleccionado(true);
              AdminFilms.establecerResultadoSeleccionado(value,origen,base64);
          });
          resultado.classList.add(clase_resultado_obtenido);

          // Lo agrego al contenedor
          divResultados.appendChild(resultado);
          console.log('Agrego resultado: ' + value['titulo']);
        });
      } else {
        // No se encontraron resultados
        var h2 = document.createElement('h2');
        var lugarBusqueda = '';
        if (origen == 'DB') {
          lugarBusqueda = 'MVJ Reviews'
        } else if (origen == 'API') {
          lugarBusqueda = 'TheMovieDB';
        }
        h2.innerHTML = 'No se encontraron coincidencias en ' + lugarBusqueda + '.';
        h2.classList.add('sin-resultados');
        var contenedor = document.querySelector('.administrador-films .admin-resultados');
        // Lo inserta en la posicion 2: Despues del form, antes del resto de los resultados
        contenedor.insertBefore(h2, contenedor.childNodes[1]);
      }
  }

}

/**
 * @param $switch si es true lo muestra. Si es false lo oculta.
 */
AdminFilms.mostrarResultadoSeleccionado = function($switch) {
  var resultado = document.querySelector('.resultado-seleccionado');
  if ($switch) {
    resultado.classList.remove('resultado-seleccionado-oculto');
  } else {
    resultado.classList.add('resultado-seleccionado-oculto');
  }

  // Elimino el cartel del resultado de la ultima operacion
  AdminFilms.borrarMensajes();
}

/**
 * Agrega un genero pasado por parametro a la lista UL de generos
 */
AdminFilms.agregarGenero = function(genero) {
  var lista = document.querySelector('.admin-resultados .resultado-seleccionado .info .campo .genero');
  // Si el genero es desconocido viene en false
  if (genero != false) {
    var li = document.createElement('li');
    // Cruz para eliminar el genero
    var cruz = document.createElement('span');
    cruz.classList.add('cruz');
    cruz.addEventListener('click', function() {
      // Borra el li que lo contiene
      this.parentElement.remove();
    });
    // Queda asi hasta que se presione el boton modificar.
    // cruz.style.display = 'none';

    li.innerHTML = genero; // Deberia ser un string
    // Agrego clases que se usan para identificar los li en AdminFilms.getListaGeneros()
    // li.classList.add('.resultado-seleccionado .info .campo .genero');
    li.appendChild(cruz);
    lista.appendChild(li);
  }
}

/* en los textarea del resultado seleccionado inserto los valores de la imagen clicleada.
* ademas, segun sea de BD o de API, habilito y desabilito botones de ABM. (Ideal tambien validar por backend)
*/
AdminFilms.establecerResultadoSeleccionado = function(resultado,origen,base64){
  //a la seccion info le agrego datos importantes de la peli seleccionada que no se muestran en los textareas.
  //pero que despues se mandara en la request si es que el usuario realiza una accion sobre el (Agregar/modificar/etc)

  /*var estadoResultAnt = document.querySelector('.resultado-Ok');

  if (estadoResultAnt!=null){
    var padre = document.querySelector('.resultado-seleccionado .poster');
      padre.removeChild(estadoResultAnt);
  }*/
  AdminFilms.borrarMensajes();

  var film_select = document.querySelector('.admin-resultados .resultado-seleccionado .info');
  film_select.setAttribute('origen',origen);
  if (origen=='DB') {
    film_select.setAttribute('id',resultado['id']);
  } else {
    film_select.setAttribute('id',-1);
  }

  var info = '.admin-resultados .resultado-seleccionado .info .campo';
  // Guardo el id_themoviedb en una variable global
  idTheMovieDb = resultado['id_themoviedb'];

  var input = document.querySelector(info + ' .titulo');
  input.value = resultado['titulo'] || '';

  input = document.querySelector(info + ' .sinopsis');
  input.value = resultado['sinopsis'] || '';

  var select = document.querySelector(info + ' .categoria');
  select.value = resultado['categoria'] || '';

  // var textarea = document.querySelector(info + ' .pais');
  // textarea.innerHTML = resultado['pais'];
  select = document.querySelector(info + ' .pais');
  select.value = resultado['pais'] || '';

  input = document.querySelector(info + ' .fecha-estreno');
  input.value = resultado['fecha_estreno'] || '';

  input = document.querySelector(info + ' .fecha-finalizacion');
  input.value = resultado['fecha_finalizacion'] || '';

  input = document.querySelector(info + ' .duracion-min');
  input.value = resultado['duracion_min'] || '';

  var textarea = document.querySelector(info + ' .trailer-url');
  textarea.value = resultado['trailer'] || '';

  // Testingggggg
  // Carga la lista UL con los generos
  var lista = document.querySelector(info + ' .genero');
  // Borro los generos del film anterior
  lista.innerHTML = '';
  if (resultado['genero'] != undefined){
    resultado['genero'].forEach(AdminFilms.agregarGenero);
  }

  var poster = document.querySelector('.admin-resultados .resultado-seleccionado .poster img');
  if (resultado.poster == "") {
    poster.src = GENERIC_IMAGE_URL;
  } else {
    poster.src = base64+resultado['poster'];
    poster.setAttribute('path',resultado['poster']);
  }

  //habilito o desabilito botones
  var btnGuardar = document.querySelector('.resultado-seleccionado .opciones .boton-guardar');
  var btnModificar = document.querySelector('.resultado-seleccionado .opciones .boton-modificar');
  var btnEliminar = document.querySelector('.resultado-seleccionado .opciones .boton-eliminar');

  if (origen=='API') {
    btnGuardar.setAttribute('enabled','true');
    btnModificar.setAttribute('enabled','true');
    btnEliminar.setAttribute('disabled','disabled');

  } else if (origen=='DB') {
    btnGuardar.setAttribute('enabled','false');
    btnModificar.setAttribute('enabled','true');
    btnEliminar.setAttribute('enabled','true');
    btnEliminar.removeAttribute('disabled');
  }
  //a todos los campos por defecto los traigo para no ser editados, una vez que clickea en el boton modificar
  //se cambia a enabled.
  // var campos  = document.querySelectorAll('.resultado-seleccionado .info .campo textarea');
  var campos  = document.querySelectorAll('.resultado-seleccionado .info .campo .editable');
  campos.forEach(function(campo){
    campo.removeAttribute('enabled');
    campo.setAttribute('disabled','true');
  });

  // Caso especial: la cruz en cada genero
  var cruces = document.querySelectorAll('.resultado-seleccionado .campo .cruz');
  cruces.forEach(function(cruz) {
    cruz.style.display = 'none';
  });
}

function showAdminHelpPopup() {
    var popup = document.querySelector(".overlay");
    popup.style.visibility = 'visible';
}

function hideAdminHelpPopup() {
    var popup = document.querySelector(".overlay");
    popup.style.visibility = 'hidden';
}
