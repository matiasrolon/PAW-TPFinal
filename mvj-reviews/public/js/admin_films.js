var window = window || {},
  document = document || {},
  console = console || {},
  AdminFilms = AdminFilms || {};
  idTheMovieDb = '';

AdminFilms.iniciarPagina = function (contenedorHTML) {
  window.addEventListener("DOMContentLoaded", function () {
    console.log("Film_Profile asocio JS con HTML.");

    AdminFilms.buscador = document.getElementById('buscadorFilms');

    AdminFilms.btnBuscador = document.getElementById('btnBuscadorFilms');
    AdminFilms.btnBuscador.addEventListener("click", function(){

      // Primero elimino los resultados de la busqueda anterior.
            var seccionResultados = document.querySelector('.resultados-obtenidos');
            var resultadosAnt = document.querySelectorAll('.resultados-obtenidos .resultado-obtenido');
            console.log(resultadosAnt);
            if (resultadosAnt.length > 0){
              resultadosAnt.forEach(function (resultAnt) {
                console.log(resultAnt);
                seccionResultados.removeChild(resultAnt);
              });
            }

            //Se podria seleccionar acorde a lo que haya filtrado en el select de busqueda. Se deja generico por ahora.
            AdminFilms.enviarRequestSearchFilmsAdmin('API');
            AdminFilms.enviarRequestSearchFilmsAdmin('DB');
    });

    AdminFilms.cargarFuncionalidadABM();
    AdminFilms.cargarFuncionalidadPendentSearches();

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
        request.onreadystatechange = function(){ // cuando la peticion cambia de estado.
          console.log("estado del ajax post: " + this.status);
          if (this.readyState==4 && this.status==200){ // si se recibe correctamente la respuesta.
              AdminFilms.recibirResponseStoreFilm(this);
          };
        }
        AdminFilms.enviarRequestStoreFilm(request);
  });

  // Boton de agregar genero
  var btnGenero = document.getElementById('agregar-genero');
  var selectGen = document.getElementById('generos');
  btnGenero.addEventListener('click', function() {
    AdminFilms.agregarGenero(selectGen.value);
  });
}

/*
 Funcion: crea el objeto ajax que recibira la funcion store de FilmController
*/
AdminFilms.enviarRequestStoreFilm = function(request){
  var info = '.resultado-seleccionado .info .campo ';
  //console.log(titulo);
  var film ={ // objeto a enviar
    "origen":document.querySelector('.resultado-seleccionado .info').getAttribute('origen'),
    "id":document.querySelector('.resultado-seleccionado .info').getAttribute('id'),
    "titulo": document.querySelector(info+'.titulo').value,
    "sinopsis": document.querySelector(info+'.sinopsis').value,
    "categoria": document.querySelector(info+'.categoria').value,
    "fecha_estreno": document.querySelector(info+'.fecha-estreno').value,
    "poster": document.querySelector('.resultado-seleccionado .poster img').getAttribute('path'),
    "genero": document.querySelector(info+'.genero').value,
    "pais": document.querySelector(info+'.pais').value,
    "duracion_min": document.querySelector(info+'.duracion-min').value,
    // Tomo la id de la variable global.
    "id_themoviedb": idTheMovieDb
  };

  var objeto = JSON.stringify(film);
  console.log("se va a enviar a "+ objeto);
  request.open("POST", "/storeFilm", true);
  request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  request.setRequestHeader('X-CSRF-Token', $('meta[name="csrf-token"]').attr('content'));
  request.send("objeto="+objeto);
}


/*
Funcion: Recibe la respuesta de la operacion y muestra el resultado acorde en pantalla
         Si la operacion fue exitosa, actualiza atributos de los elementos.
*/
  AdminFilms.recibirResponseStoreFilm = function(response){
      console.log('recibi respuesta de ajax post store film');
      var resp = JSON.parse(response.responseText);
      console.log("se recibio respuesta> se grabo la peli con el id="+ resp['id']);

      let p = document.querySelector('.admin-resultados .resultado-seleccionado .poster');
      let par = document.createElement('p');
      par.innerText = resp['mensaje'];
      p.appendChild(par);
      if (resp['estado']='OK'){
        par.classList.add('resultado-Ok');
        document.querySelector('.admin-resultados .resultado-seleccionado .info')
        .setAttribute('id',resp['id']);
      }else{
        par.classList.add('resultado-Failed');
        //con css mostrar algo en rojo, o campos erroneos (cuando ande validar en el back)
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

      //console.log("readystate buscar admin resultado: " + this.readyState);
      if (this.readyState == 4 && this.status == 200) { // si se recibe correctamente la respuesta.
        AdminFilms.recibirResponseSearchFilmsAdmin(this,origen);
        console.log("estado de la peticion buscar admin resultado: " + this.status);

      };
    }
    //envio la request
    console.log("se va a enviar a '" + AdminFilms.buscador.value + "' a "+origen);
    if (origen=='API'){  request.open("GET", "/admin/searchFilms/API/" + AdminFilms.buscador.value, true);
    }else{ request.open("GET", "/admin/searchFilms/DB/" + AdminFilms.buscador.value, true);}
    request.send();
  }
}


/**
* Funcion: Recibe las coincidencias con la busqueda, ya sea en la API como a nivel $localFilms
* Se agrego el parametro ORIGEN para actuar al respecto dependiendo si viene de la API o de la BD
* (Ejemplo: SRC del poster, clases para distingir una de otra via CSS,etc).
*/
AdminFilms.recibirResponseSearchFilmsAdmin = function (response,origen) {
  var resp = JSON.parse(response.responseText);
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

      // Agrego cada resultado al contenedor
  if (resp.length>0){
      resp.forEach(function (value, index) {

        var resultado = document.createElement('div');
        resultado.classList.add('resultado-obtenido');
        resultado.id = "r" + index.toString();

        if (index % 5 == 0 ){ //para las imagenes del principio de cada fila.
            resultado.classList.add('ini-fila');
        }
        // Primero recupero el poster.
        var poster = document.createElement('img');
        poster.classList.add('poster');

        if (typeof value['poster'] !== 'undefined'){ //a veces no carga bien la imagen proveniente de la api
            poster.src = base64 + value['poster'];
        }else{//establece una por defecto
            poster.src = window.location + '/images/noimage.jpg';
        }

        poster.alt = 'Poster';
        poster.setAttribute('path',value['poster']);
        resultado.appendChild(poster);
        resultado.classList.add(origen);//para distinguir via CSS las que vienen de API de las que vienen de BD
        //cargo los datos en el cuadro principal de ABM al hacer click sobre la imagen
        resultado.addEventListener("click",function(){
            AdminFilms.mostrarResultadoSeleccionado();
            AdminFilms.establecerResultadoSeleccionado(value,origen,base64);
        });
        resultado.classList.add(clase_resultado_obtenido);

        // Lo agrego al contenedor
        divResultados.appendChild(resultado);
      });
    }  
}


AdminFilms.mostrarResultadoSeleccionado = function() {
  var resultado = document.querySelector('.resultado-seleccionado');
  resultado.classList.remove('resultado-seleccionado-oculto');
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
  var estadoResultAnt = document.querySelector('.resultado-Ok');

  if (estadoResultAnt!=null){
    var padre = document.querySelector('.resultado-seleccionado .poster');
      padre.removeChild(estadoResultAnt);
  }

  var film_select = document.querySelector('.admin-resultados .resultado-seleccionado .info')
  film_select.setAttribute('origen',origen);
  if (origen=='DB'){
    film_select.setAttribute('id',resultado['id']);
  }else{
    film_select.setAttribute('id',-1);
  }
    var info = '.admin-resultados .resultado-seleccionado .info .campo';

        // Guardo el id_themoviedb en una variable global
        idTheMovieDb = resultado['id_themoviedb'];

        var textarea = document.querySelector(info + ' .titulo');
        textarea.innerHTML = resultado['titulo'];
        var textarea = document.querySelector(info + ' .sinopsis');
        textarea.innerHTML = resultado['sinopsis'];
        var textarea = document.querySelector(info + ' .categoria');
        textarea.innerHTML = resultado['categoria'];
        // var textarea = document.querySelector(info + ' .pais');
        // textarea.innerHTML = resultado['pais'];
        var select = document.querySelector(info + ' .pais');
        select.value = resultado['pais'];
        var textarea = document.querySelector(info + ' .fecha-estreno');
        textarea.innerHTML = resultado['fecha_estreno'];
        var textarea = document.querySelector(info + ' .duracion-min');
          textarea.innerHTML = resultado['duracion_min'];
        var textarea = document.querySelector(info + ' .genero');


        // Testingggggg
        // Carga la lista UL con los generos
        var lista = document.querySelector(info + ' .genero');
        // Borro los generos del film anterior
        lista.innerHTML = '';
        if (resultado['genero'] != undefined){
          resultado['genero'].forEach(AdminFilms.agregarGenero);
        }

    var poster = '.admin-resultados .resultado-seleccionado .poster img';
    var poster = document.querySelector(poster);
    poster.src = base64+resultado['poster'];
    poster.setAttribute('path',resultado['poster']);
    //habilito o desabilito botones
    var btnGuardar = document.querySelector('.resultado-seleccionado .opciones .boton-guardar');
    var btnModificar = document.querySelector('.resultado-seleccionado .opciones .boton-modificar');
    var btnEliminar = document.querySelector('.resultado-seleccionado .opciones .boton-eliminar');

    if (origen=='API'){
        btnGuardar.setAttribute('enabled','true');
        btnModificar.setAttribute('enabled','true');

        btnEliminar.setAttribute('disabled','true');
    }else{
      if (origen=='BD'){
            btnGuardar.setAttribute('enabled','false');
            btnModificar.setAttribute('enabled','true');
            btnEliminar.setAttribute('enabled','true')
      }
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
