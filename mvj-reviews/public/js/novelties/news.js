var window = window || {},
  document = document || {},
  console = console || {},
  Noticias = Noticias || {};

Noticias.iniciarNoticias = function (contenedorHTML) {
  window.addEventListener("DOMContentLoaded", function () {
    Noticias.contenedor = document.getElementById(contenedorHTML);
    console.log("Noticias asocio JS con HTML.");
        //Noticias.prueba();

  });//fin add event listener CONTENT LOADED
}
