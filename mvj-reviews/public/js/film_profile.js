var window = window || {},
  document = document || {},
  console = console || {},
  Pagina = Pagina || {};

const HOME_URL = '/home';
const FILM_SCORE_URL = '/films/{id}/score';
const SESSION_COOKIE = 'laravel_session';

Pagina.iniciarPagina= function(contenedorHTML){
     window.addEventListener("DOMContentLoaded", function(){
       //Cuando llega al final, carga las siguientes reviews
       window.addEventListener("scroll", function(){
              //var element = document.getElementById('app');
              //console.log("Te has desplazado "+scrollY+" píxeles o más desde la parte superior del documento");
              //if ((element.innerHeight + element.pageYOffset)>= document.body.offsetHeight){
          if (scrollY>=500){
            clearTimeout(Pagina.intervaloCargarFilms);
            Pagina.intervaloCargarFilms = setTimeout(function(){
                      console.log('llegamos al final.');
                      Pagina.enviarRequestCargarReviews();
            }, 1000);
          }
       }, false);

        Pagina.contenedor = document.getElementById(contenedorHTML);
        console.log("Film_Profile asocio JS con HTML.");
        console.log(document.getElementById('app').scrollHeight);
        Pagina.page_info = document.getElementById('page_info');

        //VOTAR FILM -> cada vez que ticlee en una estrella, se enviara el puntaje por AJAX.
        let estrellas = document.querySelectorAll('.iconos-puntaje .estrella');
        estrellas.forEach(function(estrella){
            estrella.addEventListener("click", function(){
                Pagina.enviarPuntajeFilm(estrella.dataset.value);
            });
        });

        Pagina.botonEnviarReview =document.getElementById('enviarReview');
        Pagina.botonEnviarReview.addEventListener("click", Pagina.enviarReview);

        Pagina.cargarBotonesReview(null);

        Pagina.ordenarElementos();
      //--> FUNCIONA PERO AL FINAL TIRA UNA EXCEPCION QUE NO TE DEJA SEGUIR DESPUES. ARRGLAR.

        Pagina.fetchFilmScore();
     });
}


/*---- OrdenarElementos() ------------------------------------------------------------------
        Descripcion:  asigna los eventos de Click a las opciones de la review
        (Hacer review, ver trailer o ver reviews)
*/
Pagina.ordenarElementos = function(){

  botonAgregarReview = document.querySelector('.opciones-film .container .menu .item.agregarReview');
  //console.log(botonAgregarReview);
  if (botonAgregarReview != null) {
    botonAgregarReview.addEventListener("click", function(){ Pagina.mostrarOpcion('agregarReview')});
  }

  botonReviews = document.querySelector('.opciones-film .container .menu .item.reviews');
  //console.log(botonReviews);
  if (botonReviews != null) {
    botonReviews.addEventListener("click", function(){ Pagina.mostrarOpcion('reviews')});
  }

  botonTrailer = document.querySelector('.opciones-film .container .menu .item.trailer');
  //console.log(botonTrailer);
  if (botonTrailer) {
    botonTrailer.addEventListener("click", function(){ Pagina.mostrarOpcion('trailer')});
  }

  Pagina.mostrarOpcion('trailer');
}


/*---- mostrarOpcion(opcionElegida) ------------------------------------------------------------------
       Descripcion:  Decide que opcion de las tres mencionadas arriba va a verse ante el usuario.
*/
Pagina.mostrarOpcion = function(opcionElegida){
  opcionAnt = document.querySelector('.opciones-film .container .opcion.elegida');
  console.log(opcionAnt);
  if (opcionAnt!=null){
    opcionAnt.classList.remove('elegida');

    opcionActual = document.querySelector('.opciones-film .container .opcion.'+opcionElegida);
    opcionActual.classList.add('elegida');
  }else{
    opcionActual = document.querySelector('.opciones-film .container .opcion.'+opcionElegida);
    opcionActual.classList.add('elegida');
  }
  console.log(opcionActual);
}


/*---- cargarBotonesReview ------------------------------------------------------------------
       Descripcion:  Agrega funcionalidad a los botones likes-dislike
                    Si review =  null, lo hace para todos los botones.
                    Si no, solo para la review indicada
*/
Pagina.cargarBotonesReview = function(review){

      let textLike ='.like-review';
      let textDislike ='.dislike-review';

      if (review!=null){
          textLike +=  '[data-review="'+review+'"]';
          textDislike += '[data-review="'+review+'"]';
      }

      var likes = document.querySelectorAll(textLike);
      var dislikes = document.querySelectorAll(textDislike);

      likes.forEach(like => {
          like.addEventListener("click",function(){
              Pagina.enviarPuntajeReview(like.dataset.review,true);
          })
      });
      dislikes.forEach(dislike => {
          dislike.addEventListener("click", function(){
                Pagina.enviarPuntajeReview(dislike.dataset.review,false);
          })
      });


}

/*---- enviarPuntaje(opcionElegida) ------------------------------------------------------------------
       Descripcion:  Genera la peticion AJAX que es enviada al servidor para crear un Score_Film (Film, User, Puntaje)
*/
Pagina.enviarPuntajeFilm = function(puntaje){

    var request = new XMLHttpRequest();
    request.onreadystatechange = function(){ // cuando la peticion cambia de estado.
      console.log("estado de la peticion Film: " + this.status);
      if (this.readyState==4 && this.status==200){ // si se recibe correctamente la respuesta.
          Pagina.recibirResponsePuntajeFilm(this);
      };
    }
    Pagina.enviarRequestPuntajeFilm(request,puntaje);
}


Pagina.enviarRequestPuntajeFilm = function(request,puntaje){
    console.log(" Es la peli "+Pagina.page_info.dataset.film);
    var score_film ={ // objeto a enviar
      "puntaje": puntaje,
      "film_id": Pagina.page_info.dataset.film
    };

    var objeto = JSON.stringify(score_film);
    console.log("se va a enviar a "+ objeto);
    request.open("POST", "/scoreFilm", true);
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.setRequestHeader('X-CSRF-Token', $('meta[name="csrf-token"]').attr('content'));
    request.send("objeto="+objeto);
}


Pagina.recibirResponsePuntajeFilm= function(response){
    var resp = JSON.parse(response.responseText);
    var infoPuntaje = document.querySelector('.info-puntaje');
    var respuesta = resp['mensaje'];
    // si estaba oculta de alguna solicitd ajax anterior, la muestro nuevamente
    if (infoPuntaje.classList.contains('desaparece')){
      infoPuntaje.classList.remove('desaparece');
    }

    if (resp['estado']=='OK'){// muestro mensaje con style de todo OK!
      if(infoPuntaje.classList.contains('error')){
        infoPuntaje.classList.remove('error');
      }
      if(!infoPuntaje.classList.contains('ok')){
        infoPuntaje.classList.add('ok');
      }

      Pagina.setFilmScore(resp.puntaje);

    }else{ // muestro mensaje con style de error
      if(infoPuntaje.classList.contains('ok')){
        infoPuntaje.classList.remove('ok');
      }
      if(!infoPuntaje.classList.contains('error')){
        infoPuntaje.classList.add('error');
      }
      //el mensaje tendra un link para ir al inicio de sesion
      if (resp['tipoError']=='sesion_usuario'){
        respuesta = '<a href="/login">' + respuesta + '</a>';
      }
    }

    infoPuntaje.innerHTML = respuesta;
    window.setInterval(function(){
        infoPuntaje.classList.add('desaparece');
    },7000);
}

Pagina.enviarReview = function(){
  var request = new XMLHttpRequest();
  request.onreadystatechange = function(){ // cuando la peticion cambia de estado.
    console.log("estado de la peticion Review: " + this.status);
    if (this.readyState==4 && this.status==200){ // si se recibe correctamente la respuesta.
        Pagina.recibirResponseAgregarReview(this);
    };
  }
  Pagina.enviarRequestAgregarReview(request);
}


Pagina.enviarRequestAgregarReview = function(request){
    console.log("Review hecha a la peli "+Pagina.page_info.dataset.film);
    var tituloR = document.querySelector('.form-agregar-review .titulo-review');
    var descripR = document.querySelector('.form-agregar-review .descripcion-review');
    var review ={ // objeto a enviar
      "film_id": Pagina.page_info.dataset.film,
      "titulo": tituloR.value,
      "descripcion": descripR.value
    };

    var objeto = JSON.stringify(review);
    console.log("se va a enviar a "+ objeto);
    request.open("POST", "/addReview", true);
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.setRequestHeader('X-CSRF-Token', $('meta[name="csrf-token"]').attr('content'));
    request.send("objeto="+objeto);
}


Pagina.recibirResponseAgregarReview = function(response){
  var resp = JSON.parse(response.responseText);
  console.log("se recibio respuesta> "+ resp['mensaje']);
  var estadoReview = document.querySelector('.opcion.agregarReview .estado .descripcion-estado');
  if (estadoReview.classList.contains('no-visible')){
      estadoReview.classList.remove('no-visible');
  }

  if (resp['estado']=='OK'){
    estadoReview.innerHTML = resp['mensaje'];
    if (estadoReview.classList.contains('failed')){
      estadoReview.classList.remove('failed');
    }
    if (!estadoReview.classList.contains('ok')){
      estadoReview.classList.add('ok');
    }
    //CREO UN CUADRO DE REVIEWS COMO LAS QUE YA ESTAN EN LA PAGINA HASTA EL MOMENTO.
    Pagina.agregarReview(resp);

    //Por ultimo pongo en verde el recuadro de mensaje del estado de la review
    var padre =document.querySelector('#info-reviews');
    var mensajeNoReviews = document.querySelector('#info-reviews .no-reviews');
    if (mensajeNoReviews!=null){
      padre.removeChild(mensajeNoReviews);
    }

    var tituloR = document.querySelector('.form-agregar-review .titulo-review');
    var descripR = document.querySelector('.form-agregar-review .descripcion-review');
    tituloR.value ="";
    descripR.value="";

  }else{ // es un mensaje de error
        //Pongo en rojo recuadro de la review
        if (estadoReview.classList.contains('ok')){
          estadoReview.classList.remove('ok');
        }
        if (!estadoReview.classList.contains('failed')){
          estadoReview.classList.add('failed');
        }

        let respuesta = resp['mensaje'];
        if (resp['tipoError']=="sesion_usuario"){
          respuesta = '<a href="/login">' + respuesta + '</a>';
        }

        estadoReview.innerHTML = respuesta;
  }

  setTimeout(function(){
        if (!estadoReview.classList.contains('no-visible')){
            estadoReview.classList.add('no-visible');
        }
  },10000);
}

//Agrega review a partir de una respuesta que haya recibido por AJAX
Pagina.agregarReview = function(resp){
  var seccionReviews = document.querySelector('.opcion.reviews');
  var review = document.createElement('div');
  review.classList.add('review-user');
  var codigo =
  "<section class='info-review-user'><label class='info-review-user-placeholder'>@<a href='/users/'"+resp['username']+">"+resp['username']+"</a></label><label>"+resp['created_at']+"</label><label class='info-review-title'>"+resp['titulo']+"</label><label class='info-review-descrip'>"+resp['descripcion']+"</label><label class='like-review' data-review='"+resp['review_id']+"'><i class='fas fa-thumbs-up'></i>"+ resp['positivos']+"</label><label class='dislike-review' data-review='"+resp['review_id']+"'><i class='fas fa-thumbs-down'></i>"+resp['negativos']+"</label><div data-review='"+resp['review_id']+"' class='estado-puntaje-review'><label class='descripcion'> </label></div></section>";

  review.innerHTML = codigo;
  //agregoo la review al la pagina.
  seccionReviews.appendChild(review);
  Pagina.cargarBotonesReview(resp['review_id']);
 //Cuando ya se cargo, agrego funcionalidad a sus botones de like-dislike


}

Pagina.enviarPuntajeReview = function(review,voto){
  var request = new XMLHttpRequest();
  request.onreadystatechange = function(){ // cuando la peticion cambia de estado.
    console.log("estado de la peticion Review: " + this.status);
    if (this.readyState==4 && this.status==200){ // si se recibe correctamente la respuesta.
        Pagina.recibirResponsePuntajeReview(this);
    };
  }
  Pagina.enviarRequestPuntajeReview(request, review,voto);
}

Pagina.enviarRequestPuntajeReview = function(request, review, voto){
  console.log('el usuario voto la review '+review+'--> '+voto);
  var score_review ={ // objeto a enviar
    "review_id": review,
    "voto": voto
  };

  var objeto = JSON.stringify(score_review);
  console.log("se va a enviar > "+ objeto);
  request.open("POST", "/addScoreReview", true);
  request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  request.setRequestHeader('X-CSRF-Token', $('meta[name="csrf-token"]').attr('content'));
  request.send("objeto="+objeto);
}


Pagina.recibirResponsePuntajeReview = function(response){
  var resp = JSON.parse(response.responseText);
  console.log("se recibio respuesta> "+ resp['mensaje']);
  //var estadoReview = document.querySelector('.opcion.agregarReview .estado .descripcion-estado');
  var estadoPuntajeReview = document.querySelector(".estado-puntaje-review[data-review='"+resp['review_id']+"'] .descripcion");
  console.log(estadoPuntajeReview);

  if (estadoPuntajeReview.classList.contains('desaparece')){
    estadoPuntajeReview.classList.remove('desaparece');
  }

  if (resp['estado']=='OK'){
      if (estadoPuntajeReview.classList.contains('failed')){
        estadoPuntajeReview.classList.remove('failed');
      }
      if (!estadoPuntajeReview.classList.contains('ok')){
        estadoPuntajeReview.classList.add('ok');
      }

  }else{ // si estado = FAILED
        if (estadoPuntajeReview.classList.contains('ok')){
          estadoPuntajeReview.classList.remove('ok');
        }
        if (!estadoPuntajeReview.classList.contains('failed')){
          estadoPuntajeReview.classList.add('failed');
        }
  }

  estadoPuntajeReview.innerHTML = resp['mensaje'];
  window.setInterval(function(){
        estadoPuntajeReview.classList.add('desaparece');
  },7000);

}

/*------------------- CARGAR LAS REVIEWS POR DEMANDA -------------------*/

Pagina.enviarRequestCargarReviews = function(){
  var request = new XMLHttpRequest();
  request.onreadystatechange = function(){ // cuando la peticion cambia de estado.
    console.log("estado de la peticion Review: " + this.status);
    if (this.readyState==4 && this.status==200){ // si se recibe correctamente la respuesta.
        Pagina.recibirResponseCargarReviews(this);
    };
  }

  var film = Pagina.page_info.dataset.film;
  var offset = document.querySelectorAll('.review-user').length;
  var qReviews = 5;
  console.log('peli> '+ film + '. offset>'+offset);
  request.open("GET", "/film-on-demand/"+film+"/"+offset+"/"+qReviews, true);
  request.send();
};


//Carga la nueva tanda de reviews que se pidio al hacer scroll.
Pagina.recibirResponseCargarReviews = function(response){
  var resp = JSON.parse(response.responseText);
//  console.log("se recibio respuesta> "+ resp[1]);
  resp.forEach(function(r){
      Pagina.agregarReview(r);
  });
}

Pagina.filterByGenre = (genreId) => {
    if ('URLSearchParams' in window) {
        var searchParams = new URLSearchParams(window.location.search);
        // FIXME: Revisar que hago con esta constante que esta definida en el archivo peliculasGenero.js
        searchParams.set(QUERY_PARAM_GENRE_ID, genreId);
        window.location.replace(HOME_URL + searchParams.toString());
    } else {
        // Browser does not support "URLSearchParams"
        console.error('Error al filtrar las peliculas por genero');
    }
}


/** Obtiene el puntaje que el usuario le dio */
Pagina.fetchFilmScore = function () {
    var request = new XMLHttpRequest();
    request.onreadystatechange = function() {
        if (this.readyState==4 && this.status==200){
            Pagina.setFilmScore(this.responseText);
        };
    }

    var filmId = window.location.pathname.split('/films/')[1];
    request.open("GET", FILM_SCORE_URL.replace('{id}', filmId), true);
    request.send();
}

Pagina.setFilmScore = (score) => {
    if (score !== null) {
        // Pinta TODAS las estrellas de amarillo
        document.querySelectorAll('.iconos-puntaje .estrella')
            .forEach((element) => {
                element.style.color = '#ff9c06';
            });

        // Pinta de blanco las estrellas que estan delante del puntaje elegido
        document.querySelectorAll(`.iconos-puntaje > .estrella[data-value="${score}"] ~ .estrella`)
            .forEach((element) => {
                element.style.color = 'white';
            });
    }
};
