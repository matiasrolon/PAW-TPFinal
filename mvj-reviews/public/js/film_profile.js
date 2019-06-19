var window = window || {},
  document = document || {},
  console = console || {},
  Pagina = Pagina || {};

Pagina.iniciarPagina= function(contenedorHTML){
     window.addEventListener("DOMContentLoaded", function(){
        Pagina.contenedor = document.getElementById(contenedorHTML);
        console.log("Film_Profile asocio JS con HTML.");
        Pagina.page_info = document.getElementById('page_info');

        Pagina.botonEnviarPuntaje = document.getElementById('enviarPuntaje');
        Pagina.botonEnviarPuntaje.addEventListener("click", Pagina.enviarPuntaje);

        Pagina.botonEnviarReview = document.getElementById('enviarReview');
        Pagina.botonEnviarReview.addEventListener("click", Pagina.enviarReview);

      //  Pagina.ordenarElementos();
      //--> FUNCIONA PERO AL FINAL TIRA UNA EXCEPCION QUE NO TE DEJA SEGUIR DESPUES. ARRGLAR.
     });
}


/*---- OrdenarElementos() ------------------------------------------------------------------
        Descripcion:  asigna los eventos de Click a las opciones de la review
        (Hacer review, ver trailer o ver reviews)
*/
Pagina.ordenarElementos = function(){

  botonAgregarReview = document.querySelector('.opciones-film .container .menu .item.agregarReview');
  console.log(botonAgregarReview);
  botonAgregarReview.addEventListener("click", function(){ Pagina.mostrarOpcion('agregarReview')});

  botonReviews = document.querySelector('.opciones-film .container .menu .item.reviews');
  console.log(botonReviews);
  botonReviews.addEventListener("click", function(){ Pagina.mostrarOpcion('reviews')});

  botonTrailer = document.querySelector('.opciones-film .container .menu .item.trailer');
  console.log(botonTrailer);
  botonTrailer.addEventListener("click", function(){ Pagina.mostrarOpcion('trailer')});

  Pagina.mostrarOpcion('agregarReview');
}


/*---- mostrarOpcion(opcionElegida) ------------------------------------------------------------------
       Descripcion:  Decide que opcion de las tres mencionadas arriba va a verse ante el usuario.
*/
Pagina.mostrarOpcion = function(opcionElegida){
  opciones = document.querySelectorAll('.opciones-film .container .opcion');
  for( i in opciones) {
      //console.log(i);
      if (!opciones[i].classList.contains(opcionElegida)){
          //console.log(opciones[i]);
          opciones[i].classList.add('no-visible');
      }else{
        if (opciones[i].classList.contains('no-visible')){
          opciones[i].classList.remove('no-visible');
        }
      }
  }
  console.log("termino mostrarOpcion");
}


/*---- enviarPuntaje(opcionElegida) ------------------------------------------------------------------
       Descripcion:  Genera la peticion AJAX que es enviada al servidor para crear un Score_Film (Film, User, Puntaje)
*/
Pagina.enviarPuntaje = function(){

    var request = new XMLHttpRequest();
    request.onreadystatechange = function(){ // cuando la peticion cambia de estado.
      console.log("estado de la peticion Film: " + this.status);
      if (this.readyState==4 && this.status==200){ // si se recibe correctamente la respuesta.
          Pagina.recibirResponsePuntaje(this);
      };
    }
    Pagina.enviarRequestPuntaje(request);
}


Pagina.enviarRequestPuntaje = function(request){
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


Pagina.recibirResponsePuntaje= function(response){
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
        Pagina.recibirResponseReview(this);
    };
  }
  Pagina.enviarRequestReview(request);
}


Pagina.enviarRequestReview = function(request){
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


Pagina.recibirResponseReview = function(response){
  var resp = JSON.parse(response.responseText);
  console.log("se recibio respuesta> "+ resp['mensaje']);
  var estadoReview = document.querySelector('.opcion.agregarReview .estado .descripcion-estado');
  if (resp['estado']='OK'){
    estadoReview.innerHTML = resp['mensaje'];
    //CREO UN CUADRO DE REVIEWS COMO LAS QUE YA ESTAN EN LA PAGINA HASTA EL MOMENTO.
    var seccionReviews = document.querySelector('.opcion.reviews');
    var review = document.createElement('div');
    review.classList.add('review-user');

        var secInfoReview = document.createElement('section');
        secInfoReview.classList.add('info-review-user');
              var usuario = document.createElement('label');
              usuario.innerHTML = "usuario: ";
                    var refPerfil = document.createElement('a');
                    refPerfil.setAttribute('href',"/users/"+resp['username']),
                    refPerfil.innerHTML =resp['username'];
              usuario.appendChild(refPerfil);
              var fecha = document.createElement('label');
              fecha.innerHTML = "fecha: "+ resp['created_at'];
              var titulo = document.createElement('label');
              titulo.innerHTML = "titulo: "+ resp['titulo'];
              var likes = document.createElement('label');
              likes.innerHTML = "likes: "+resp['positivos'];
                    var botonLike = document.createElement('button');
                    botonLike.classList.add('like-review');
                    botonLike.setAttribute('username',resp['username']);
                    botonLike.innerHTML = "Like";
              likes.appendChild(botonLike);
              var dislikes = document.createElement('label');
              dislikes.innerHTML = "dislikes: "+resp['negativos'];
                    var botonDislike =document.createElement('button');
                    botonDislike.classList.add('deslike-review');
                    botonDislike.setAttribute('username',Pagina.page_info.getAttribute('user'));
                    botonDislike.innerHTML = "Dislike";
              dislikes.appendChild(botonDislike);
        secInfoReview.appendChild(usuario);
        secInfoReview.appendChild(fecha);
        secInfoReview.appendChild(titulo);
        secInfoReview.appendChild(likes);
        secInfoReview.appendChild(dislikes);

        var secDescripReview = document.createElement('section');
        secDescripReview.classList.add('descripcion-review-user');
            var descripcion = document.createElement('label');
            descripcion.innerHTML = "descripcion: "+ resp['descripcion'];
        secDescripReview.appendChild(descripcion);

    review.appendChild(secInfoReview);
    review.appendChild(secDescripReview);
    //agregoo la review al la pagina.
    seccionReviews.appendChild(review);

    //Por ultimo pongo en ver el recuadro de mensaje del estado de la review

  }else{
    estadoReview.innerHTML = resp['mensaje'];
    //Pongo en rojo recuadro de la review
  }
}
