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


///PRUEBAS CON DIV PARA EDITAR texto
Noticias.prueba = function(){
  var texto = document.getElementById("texto");
    var btn = document.getElementById("boton");
    btn.addEventListener("click",function(){
        var r   = document.createRange();
        console.log(texto.selectionStart);
        console.log(texto.selectionEnd);

        var text = texto.value;
        var inicio=text.slice(0,texto.selectionStart)
        var medio =text.slice(texto.selectionStart,texto.selectionEnd);
        var fin   =text.slice(texto.selectionEnd,text.length);

        medio="<b><big>"+medio+"</big></b>"

        texto.innerHTML = inicio+medio+fin;

        let par = document.createElement('div');
        par.setAttribute('contentEditable',true);
        par.innerHTML = inicio+medio+fin;
        Noticias.contenedor.appendChild(par);

        console.log(par.innerHTML); //texto sin html
        console.log(par.textContent); // texto html
      });

}
