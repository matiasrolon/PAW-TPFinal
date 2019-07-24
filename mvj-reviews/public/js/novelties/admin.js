var window = window || {},
  document = document || {},
  console = console || {},
  Novelties = Novelties || {};

Novelties.startNovelties = function (contenedorHTML) {
  window.addEventListener("DOMContentLoaded", function () {
    console.log("Premios asocio JS con HTML.");
      Novelties.buttonFunctions();
      Novelties.cargarSolicitudAJAX();
  });
}


Novelties.buttonFunctions = function(){
    //boton letra grande
    var btnBig = document.querySelector('.edit-panel .option.big');
    btnBig.addEventListener('click',function(){ Novelties.alterContent("big");});

    //boton letra grande
    var btnMedium = document.querySelector('.edit-panel .option.medium');
    btnMedium.addEventListener('click',function(){ Novelties.alterContent("medium");});

    //boton letra chica
    var btnSmall = document.querySelector('.edit-panel .option.small');
    btnSmall.addEventListener('click',function(){ Novelties.alterContent("small");});

    //boton letra bold
    var btnBold = document.querySelector('.edit-panel .option.bold');
    btnBold.addEventListener('click',function(){ Novelties.alterContent("bold");});

    //boton letra cursive
    var btnCursive = document.querySelector('.edit-panel .option.cursive');
    btnCursive.addEventListener('click',function(){ Novelties.alterContent("cursive");});

    //boton letra subrayada
    var btnUnderline = document.querySelector('.edit-panel .option.underline');
    btnUnderline.addEventListener('click',function(){ Novelties.alterContent("underline");});

    //añadir lista
    var btnList = document.querySelector('.edit-panel .option.list');
    btnList.addEventListener('click',function(){ Novelties.alterContent("list");});

    //boton añadir imagen
    var btnImage = document.querySelector('.edit-panel .option.image');
    btnImage.addEventListener('click',function(){ Novelties.alterContent("image");});
    //boton tamaño letra
}

Novelties.alterContent = function(accion){
  let divContent = document.querySelector('.form.news form .field.content');

  if (accion=="bold"){document.execCommand("bold")};
  if (accion=="cursive"){document.execCommand("italic")};
  if (accion=="underline"){document.execCommand("underline")};
  if (accion=="list"){document.execCommand("insertUnorderedList")};
  if (accion == "image"){
    let img = prompt("Insertar imagen","Url de la imagen");
    document.execCommand("insertimage",false,img);
  };
  if (accion == "small"){document.execCommand("fontsize",false,1)};
  if (accion == "medium"){document.execCommand("fontsize",false,3)};
  if (accion == "big"){document.execCommand("fontsize",false,5)};

}


///PRUEBAS CON DIV PARA EDITAR texto
/*Novelties.prueba = function(){
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

        console.log(par.innerHTML); //texto html
        console.log(par.textContent); // texto sin html
      });

}*/
