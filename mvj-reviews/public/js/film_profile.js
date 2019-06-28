var window = window || {},
  document = document || {},
  console = console || {},
  Pagina = Pagina || {};

Pagina.iniciarPagina= function(contenedorHTML){
     window.addEventListener("DOMContentLoaded", function(){
        Pagina.contenedor = document.getElementById(contenedorHTML);
        console.log("Film_Profile asocio JS con HTML.");
        Pagina.page_info = document.getElementById('page_info');

        Pagina.botonEnviarPuntajeFilm = document.getElementById('enviarPuntaje');
        Pagina.botonEnviarPuntajeFilm.addEventListener("click", Pagina.enviarPuntajeFilm);

        Pagina.botonEnviarReview = document.getElementById('enviarReview');
        Pagina.botonEnviarReview.addEventListener("click", Pagina.enviarReview);

        Pagina.cargarBotonesReview();

        Pagina.ordenarElementos();
      //--> FUNCIONA PERO AL FINAL TIRA UNA EXCEPCION QUE NO TE DEJA SEGUIR DESPUES. ARRGLAR.
     });
}


/*---- OrdenarElementos() ------------------------------------------------------------------
        Descripcion:  asigna los eventos de Click a las opciones de la review
        (Hacer review, ver trailer o ver reviews)
*/
Pagina.ordenarElementos = function(){

  botonAgregarReview = document.querySelector('.opciones-film .container .menu .item.agregarReview');
  //console.log(botonAgregarReview);
  botonAgregarReview.addEventListener("click", function(){ Pagina.mostrarOpcion('agregarReview')});

  botonReviews = document.querySelector('.opciones-film .container .menu .item.reviews');
  //console.log(botonReviews);
  botonReviews.addEventListener("click", function(){ Pagina.mostrarOpcion('reviews')});

  botonTrailer = document.querySelector('.opciones-film .container .menu .item.trailer');
  //console.log(botonTrailer);
  botonTrailer.addEventListener("click", function(){ Pagina.mostrarOpcion('trailer')});

  Pagina.mostrarOpcion('agregarReview');
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


/*---- enviarPuntaje(opcionElegida) ------------------------------------------------------------------
       Descripcion:  Genera la peticion AJAX que es enviada al servidor para crear un Score_Film (Film, User, Puntaje)
*/
Pagina.enviarPuntajeFilm = function(){

    var request = new XMLHttpRequest();
    request.onreadystatechange = function(){ // cuando la peticion cambia de estado.
      console.log("estado de la peticion Film: " + this.status);
      if (this.readyState==4 && this.status==200){ // si se recibe correctamente la respuesta.
          Pagina.recibirResponsePuntajeFilm(this);
      };
    }
    Pagina.enviarRequestPuntajeFilm(request);
}


Pagina.enviarRequestPuntajeFilm = function(request){
    console.log(" Es el user "+Pagina.page_info.getAttribute('user')+
                " en la peli "+Pagina.page_info.getAttribute('film'));
    var inputPuntaje = document.getElementById("puntajeFilm");
    var score_film ={ // objeto a enviar
      "puntaje":inputPuntaje.value,
      "user_id": Pagina.page_info.getAttribute('user'),
      "film_id": Pagina.page_info.getAttribute('film')
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
    console.log("se recibio respuesta> "+ resp['mensaje']);
    var infoPuntaje = document.querySelector('.info-puntaje');

    if (resp['estado']='OK'){
      infoPuntaje.innerHTML = resp['mensaje'];
        //y Pongo en verde el recuadro de puntaje
    }else{
      //Pongo en rojo el recuadro de puntaje
    }
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
    console.log(" Es el user "+Pagina.page_info.getAttribute('user')+
                " en la peli "+Pagina.page_info.getAttribute('film'));
    var tituloR = document.querySelector('.form-agregar-review .titulo-review');
    var descripR = document.querySelector('.form-agregar-review .descripcion-review');
    var review ={ // objeto a enviar
      "user_id": Pagina.page_info.getAttribute('user'),
      "film_id": Pagina.page_info.getAttribute('film'),
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
  if (resp['estado']=='OK'){
    estadoReview.innerHTML = resp['mensaje'];
    //CREO UN CUADRO DE REVIEWS COMO LAS QUE YA ESTAN EN LA PAGINA HASTA EL MOMENTO.
    var seccionReviews = document.querySelector('.opcion.reviews');
    var review = document.createElement('div');
    review.classList.add('review-user');

        var secInfoReview = document.createElement('section');
        secInfoReview.classList.add('info-review-user');
              var usuario = document.createElement('label');
              usuario.innerHTML = " Usuario: ";
                    var refPerfil = document.createElement('a');
                    refPerfil.setAttribute('href',"/users/"+resp['username']),
                    refPerfil.innerHTML =resp['username'];
              usuario.appendChild(refPerfil);
              var fecha = document.createElement('label');
              fecha.innerHTML = " Fecha: "+ resp['created_at'];
              var titulo = document.createElement('label');
              titulo.innerHTML = " Titulo: "+ resp['titulo'];
              var likes = document.createElement('label');
              likes.innerHTML = " Likes: "+resp['positivos'];
                    var botonLike = document.createElement('button');
                    botonLike.classList.add('like-review');
                    botonLike.setAttribute('user',resp['user_id']);
                    botonLike.setAttribute('review',resp['review_id']);
                    botonLike.innerHTML = "Like";
                    botonLike.addEventListener("click",function(){
                        Pagina.enviarPuntajeReview(resp['user_id'],resp['review_id'],true);
                    })
              likes.appendChild(botonLike);
              var dislikes = document.createElement('label');
              dislikes.innerHTML = " Dislikes: "+resp['negativos'];
                    var botonDislike =document.createElement('button');
                    botonDislike.classList.add('deslike-review');
                    botonDislike.setAttribute('user',resp['user_id']);
                    botonDislike.setAttribute('review',resp['review_id']);
                    botonDislike.innerHTML = "Dislike";
                    botonDislike.addEventListener("click",function(){
                        Pagina.enviarPuntajeReview(resp['user_id'],resp['review_id'],false);
                    })
              dislikes.appendChild(botonDislike);
              var estado = document.createElement('div');
              estado.classList.add('estado-puntaje-review');
              estado.setAttribute('review',resp['review_id']);
                  var descripEstado = document.createElement('label');
                  descripEstado.classList.add('descripcion');
              estado.appendChild(descripEstado);

        secInfoReview.appendChild(usuario);
        secInfoReview.appendChild(fecha);
        secInfoReview.appendChild(titulo);
        secInfoReview.appendChild(likes);
        secInfoReview.appendChild(dislikes);
        secInfoReview.appendChild(estado);

        var secDescripReview = document.createElement('section');
        secDescripReview.classList.add('descripcion-review-user');
            var descripcion = document.createElement('label');
            descripcion.innerHTML = "descripcion: "+ resp['descripcion'];
        secDescripReview.appendChild(descripcion);

    review.appendChild(secInfoReview);
    review.appendChild(secDescripReview);
    //agregoo la review al la pagina.
    seccionReviews.appendChild(review);

    //Por ultimo pongo en verde el recuadro de mensaje del estado de la review
    var padre =document.querySelector('#info-reviews');
    var mensajeNoReviews = document.querySelector('#info-reviews .no-reviews');
    if (mensajeNoReviews!=null){
      padre.removeChild(mensajeNoReviews);
    }

  }else{
    estadoReview.innerHTML = resp['mensaje'];
    //Pongo en rojo recuadro de la review
  }
}


Pagina.cargarBotonesReview = function(){
    var likes = document.querySelectorAll('.like-review');
    var dislikes = document.querySelectorAll('.dislike-review');
    likes.forEach(like => {
        like.addEventListener("click",function(){
            Pagina.enviarPuntajeReview(like.getAttribute('user'),like.getAttribute('review'),true);
        })
    });
    dislikes.forEach(dislike => {
        dislike.addEventListener("click", function(){
              Pagina.enviarPuntajeReview(dislike.getAttribute('user'),dislike.getAttribute('review'),false);
        })
    });

}

Pagina.enviarPuntajeReview = function(user, review,voto){
  var request = new XMLHttpRequest();
  request.onreadystatechange = function(){ // cuando la peticion cambia de estado.
    console.log("estado de la peticion Review: " + this.status);
    if (this.readyState==4 && this.status==200){ // si se recibe correctamente la respuesta.
        Pagina.recibirResponsePuntajeReview(this);
    };
  }
  Pagina.enviarRequestPuntajeReview(request, user,review,voto);
}

Pagina.enviarRequestPuntajeReview = function(request, user, review, voto){
  console.log('el usuario '+ Pagina.page_info.getAttribute('user') + ' voto la review '+review+' que fue hecha por el usuario'+user +'--> '+voto);
  var score_review ={ // objeto a enviar
    "user_id": Pagina.page_info.getAttribute('user'),
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
  var estadoPuntajeReview = document.querySelector(".estado-puntaje-review[review='"+resp['review_id']+"'] .descripcion");
  console.log(estadoPuntajeReview);
  estadoPuntajeReview.innerHTML = resp['mensaje'];

  if (resp['estado']='OK'){
    //poner en verde icono
  }else{
    //poner en verde icono

  }
}
