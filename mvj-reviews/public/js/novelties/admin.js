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

  /*  //Cuando se carga una imagen, se mostrara su vista previa.
    let inputPoster = document.querySelector(".form.news form .field.poster label input");
    inputPoster.addEventListener("change",function(){
        let file = document.forms['news']['portada'].files[0];
        Novelties.setPosterPreview(file);
    });

  //  boton de enviar > envia AJAX para crear la novedad
    let btnSendNews = document.querySelector('form .btnSendNews');
    btnSendNews.addEventListener("click", function(){
      Novelties.createNoveltiesRequest('news');
    });

    let btnSendAward = document.querySelector('form .btnSendAward');
    btnSendAward.addEventListener("click", function(){
      Novelties.createNoveltiesRequest('award');
    });
  */

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
  //si no hace click en Category por 10 seg desaparece el input para ingresar cant de nominados
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

  //inserta nueva categoria (para completar) en el div content
  var input = document.querySelector('.edit-panel .button-section.award .attribute-option.nominee input');
  console.log('inserta category en content con '+input.value+' nominados');

  if (input.value>0){//cant nominados > 0
    //clono category base del html
    var cloneNode = document.querySelector('.form.award form .field.content .category').cloneNode(true);
    cloneNode.classList.remove('no-visible');
    let nroCategory = document.querySelectorAll('.form.award form .field.content .category').length;
    cloneNode.setAttribute('nroCategory',nroCategory);
    //la agrego al div content.
    document.querySelector('.form.award form .field.content').appendChild(cloneNode);
    //inserto sus nominados
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

  //actualizo el valor del input que representa el cuerpo (es de type HIDDEN)
  let inputContent = document.querySelector('.form.news form input[name="cuerpo"]');
  inputContent.value = divContent.innerHTML;

}

//------------------------------------------------------------------------------------
//AJAX funcionalidad

Novelties.createNoveltiesRequest = function(type){
  //CREA solicitud AJAX
  var request = new XMLHttpRequest();
  request.onreadystatechange = function(){ // cuando la peticion cambia de estado.
    console.log("estado de la peticion crear Novedad: " + this.status);
    if (this.readyState==4 && this.status==200){ // si se recibe correctamente la respuesta.
        if(type=="news"){Novelties.recieveNoveltiesResponse(this,'news');}
        if(type=="award"){Novelties.recieveNoveltiesResponse(this,'award');}
    };
  }
// crea un objecto parametro para la solicitud segun el tipo de novedad.
  let noveltie = '';
  if (type=="news"){ noveltie = Novelties.createNewsObjectRequest();}
  if (type=="award"){ noveltie = Novelties.createAwardObjectRequest();}
//envia
  var object = JSON.stringify(noveltie);
  console.log("se va a enviar a "+ object);
  request.open("POST", "/admin/novelties/create-noveltie", true);
  request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  request.setRequestHeader('X-CSRF-Token', $('meta[name="csrf-token"]').attr('content'));
  request.send("object="+object);
}


//Recibe la respuesta de crear una Novedad, actualiza el formulario correspondiente. Puede
// a. Mostrar los campos erroneos al crear la novedad
// b. Redireccionar a la nueva novedad creada.
Novelties.recieveNoveltiesResponse = function(response,type){
  var resp = JSON.parse(response.responseText);
  console.log("se recibio respuesta para crear Novedad ");

  if (resp['state']=='OK'){
   console.log("OK> "+resp['message']);
   //document.getElementById("portada-news-preview").setAttribute('src',resp['portada']);
   //console.log(img.size);
 }else{ //marcar campos erroneos
     console.log("ERROR en campos> "+resp['errors']);

  }

}


//crea un objecto para la request AJAX con atributos para  crear una Noticia
Novelties.createNewsObjectRequest = function(){
    console.log('creando objeto Noticia');
    let queryBase= '.form.news form .field';

    var news ={ // objeto a enviar
      "type":"news",
      'titulo': document.querySelector(queryBase+'.tittle label input').value,
      'copete':document.querySelector(queryBase+'.description label input').value,
      'portada':document.getElementById('portada-news-preview').getAttribute("src"),
      'cuerpo':document.querySelector(queryBase+'.content').innerHTML,
      'fuente':document.querySelector(queryBase+'.source label input').value,
    };

    return news;
}

 Novelties.setPosterPreview = function(file){
   var reader = new FileReader();
   reader.readAsDataURL(file);
     reader.onload = function () {
       console.log(reader.result);
       var img =document.createElement('img');
       img.setAttribute('src',reader.result);
       img.classList.add('poster-preview')
       img.setAttribute('id','portada-news-preview');
       document.querySelector('.form.news form .field.poster').appendChild(img);
     };
 }



//crea un objecto para la request AJAX con atributos para  crear un Premio
Novelties.createAwardObjectRequest = function(){
    console.log('creando objeto Premio');
    var award ={ // objeto a enviar
      "type":"award"
    };
    return award;
}
