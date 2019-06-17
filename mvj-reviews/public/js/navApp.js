var window = window || {},
  document = document || {},
  console = console || {},
  NavPrincipal = NavPrincipal || {};

NavPrincipal.iniciarNavPrincipal= function(contenedorHTML){
     window.addEventListener("DOMContentLoaded", function(){
       NavPrincipal.contenedor = document.getElementById('app');
       console.log('APP asocio js con html ');
        NavPrincipal.buscador = document.getElementById('buscador');
        console.log(NavPrincipal.buscador);
        NavPrincipal.buscador.addEventListener("keyup",NavPrincipal.buscarFilm);
     });
}


NavPrincipal.buscarFilm = function(){
    /*
    PRUEBA
     TO DO-> POR CADA LETRA APRETADA HAY QUE IR A BUSCAR A LA BD LAS COINCIDENCIAS
                 -SI HAY COINCIDENCIAS, SE LAS MUESTRA TODAS
                 -SI NO, NO SE HACE NADA --> SE GUARDARA LA BUSQUEDA PENDIENTE SOLO SI APRETA ENTER.
                  ( SE HARIA EN OTRO EVENT)
    */
    NavPrincipal.buscador.value = NavPrincipal.buscador.value.toUpperCase();//LA CONVIERTE EN MAYUSCULA
    console.log('escribio letra, texto hasta ahora: ' + NavPrincipal.buscador.value);
}
