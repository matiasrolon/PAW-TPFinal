var window = window || {},
  document = document || {},
  console = console || {},
  Pagina = Pagina || {};

Pagina.iniciarPagina= function(contenedorHTML){
     window.addEventListener("DOMContentLoaded", function(){
        Pagina.contenedor = document.getElementById(contenedorHTML);
        console.log("asocio JS con HTML de Film_Profile");
        Pagina.ordenarElementos();
     });
}

Pagina.ordenarElementos = function(){
  //agregarReview = document.querySelector('.opciones-film .container .opcion.agregarReview')
  botonAgregarReview = document.querySelector('.opciones-film .container .menu .item.agregarReview');
  console.log(botonAgregarReview);
  botonAgregarReview.addEventListener("click", function(){ Pagina.mostrarOpcion('agregarReview')});

//  reviews = document.querySelector('.opciones-film .container .opcion.reviews')
  botonReviews = document.querySelector('.opciones-film .container .menu .item.reviews');
  console.log(botonReviews);
  botonReviews.addEventListener("click", function(){ Pagina.mostrarOpcion('reviews')});

//  trailer = document.querySelector('.opciones-film .container .opcion.trailer')
  botonTrailer = document.querySelector('.opciones-film .container .menu .item.trailer');
  console.log(botonTrailer);
  botonTrailer.addEventListener("click", function(){ Pagina.mostrarOpcion('trailer')});

  Pagina.mostrarOpcion('agregarReview');
}

Pagina.mostrarOpcion = function(opcionElegida){
  console.log('entro a mostrarOpcion');
  opciones = document.querySelectorAll('.opciones-film .container .opcion');
  console.log(opciones.length);
  for( i in opciones) {
      console.log(i);
      if (!opciones[i].classList.contains(opcionElegida)){
          console.log(opciones[i]);
          opciones[i].classList.add('no-visible');
      }else{
        if (opciones[i].classList.contains('no-visible')){
          opciones[i].classList.remove('no-visible');
        }
      }
  }

}
