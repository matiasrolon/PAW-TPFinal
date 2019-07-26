var window = window || {},
  document = document || {},
  console = console || {},
  Novelties = Novelties || {};

Novelties.startNovelties = function (contenedorHTML) {
  window.addEventListener("DOMContentLoaded", function () {
    console.log("Premios asocio JS con HTML.");
    Novelties.buttonFunctions();
      //Novelties.cargarSolicitudAJAX();
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

    //---------------------------------------------------------------------------------
    //Boton agregar CATEGORIA
    var btnCategory = document.querySelector('.edit-panel .option.addCategory');
    btnCategory.addEventListener('click',function(){Novelties.addCategory();});

    //boton cantidad de nominados de categoria
      var inputnom = document.querySelector('.edit-panel .button-section.award .attribute-option.nominee input');
      inputnom.addEventListener('keyup',function(event){
          if (event.keyCode ==13){
            Novelties.insertCategoryInContent();
          }
      })
}


Novelties.addCategory = function(){
  var atrsec = document.querySelector('.edit-panel .button-section.award .attribute-option.nominee');
  if (atrsec.classList.contains('no-visible')){
    atrsec.classList.remove('no-visible');
    atrsec.classList.remove('removed');
  }else{// si ya esta visible el campo, proceso a insertar la Category
      Novelties.insertCategoryInContent();
  }
}


Novelties.insertCategoryInContent = function(){
  //si no hace click en Category por 10 seg desaparece el input para el nro de nominados
  if (typeof intervalo !== 'undefined'){
    clearTimeout(intervalo);
  }
  intervalo = setTimeout(function(){
        var secNom = document.querySelector('.edit-panel .button-section.award .attribute-option.nominee');
        secNom.classList.add('removed');
        secNom.addEventListener('transitionend', function() {
          this.classList.add('no-visible');
        });
  }, 10000);

  //inserta categoria en el div content
  var input = document.querySelector('.edit-panel .button-section.award .attribute-option.nominee input');
  console.log('inserta category en content con '+input.value+' nominados');

  if (input.value>0){
    //clono category base del html
    var cloneNode = document.querySelector('.form.award form .field.content .category').cloneNode(true);
    cloneNode.classList.remove('no-visible');
    let nroCategory = document.querySelectorAll('.form.award form .field.content .category').length;
    cloneNode.setAttribute('nroCategory',nroCategory);
    document.querySelector('.form.award form .field.content').appendChild(cloneNode);
    //inserto nominados
      for (var i = 1; i < input.value; i++) {
          console.log('insertando '+i+' nominado');
          let nomList = document.querySelector('.category[nroCategory="'+nroCategory+'"] .attribute.nominees-list');
          let text = '<li class="nominee"> <div class="name"><label for="nominado" > <input name="nominado" type="text" placeholder="nombre"></label></div><div class="description"><label for="descripcion" >por<input name="descripcion" type="text" placeholder="pelicula"></label></div></li>'
          nomList.innerHTML = nomList.innerHTML+text;
      }
  }

};


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
