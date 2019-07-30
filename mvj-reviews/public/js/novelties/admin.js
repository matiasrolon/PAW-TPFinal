var window = window || {},
  document = document || {},
  console = console || {},
  Novelties = Novelties || {};

Novelties.startNovelties = function (contenedorHTML) {
  window.addEventListener("DOMContentLoaded", function () {
    console.log("Premios asocio JS con HTML.");
    Novelties.buttonFunctions();

    let btnCreateNews = document.querySelector('.create-options .option.news');
    btnCreateNews.addEventListener("click",function(){ Novelties.changeNoveltieCreate('news');});

    let btnCreateAwards = document.querySelector('.create-options .option.award');
    btnCreateAwards.addEventListener("click",function(){ Novelties.changeNoveltieCreate('award');});

    let btnCategories = document.querySelectorAll('.btnQuit');
    if (btnCategories.length>0){
      btnCategories.forEach(function(btn){
        console.log(btn);
        btn.addEventListener("click",function(){
          console.log(btn.getAttribute('data-nro-category'));
            Novelties.removeCategory(btn.getAttribute('data-nro-category'));
        });
      });
    }

  });
}

//funcion para visualizar un formulario u otro segun donde se haya hecho click
Novelties.changeNoveltieCreate = function(type){
//primero achico el menu inicial de create-options
let createOptions = document.querySelector('.create-options');
if (createOptions.classList.contains('initial')){
  createOptions.classList.remove('initial');
  createOptions.classList.add('secondary');
}

//Invisiviliza todos los forms
  let forms = document.querySelectorAll('.form');
  forms.forEach(function(f){
    if (!f.classList.contains('no-visible')){
      f.classList.add('no-visible');
    }
  });
//Para luego visualizar el indicado.
  if (type=="news"){

      let formNews = document.querySelector('.form.news');
      if (formNews.classList.contains('no-visible')){
        formNews.classList.remove('no-visible');
        let categories = document.querySelectorAll('.category');
        categories.forEach(function(c){
            c.classList.add('no-visible');
        });
      }
  }

  if (type=="award"){

    let formAward = document.querySelector('.form.award');
    if (formAward.classList.contains('no-visible')){
      formAward.classList.remove('no-visible');
    }

    //muestro las categorias solo si el que esta visible es el form award
    let categories = document.querySelectorAll('.category');
    categories.forEach(function(c){
        if (c.classList.contains('no-visible')){
          c.classList.remove('no-visible');
        }
    });
  }

}


Novelties.buttonFunctions = function(){

    //Cuando en el div content cambia algo actualizo valor del input(que es de type HIDDEN)
    let divContent = document.querySelector('.form.news form .field.content');
    divContent.addEventListener("keyup",function(){
      let inputContent = document.querySelector('.form.news form input[name="cuerpo"]');
      inputContent.value = this.innerHTML;
    });

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
    let category = document.createElement('div');
    let nroCategory = document.querySelectorAll('.form.award form .field.content .category').length+1;
    category.classList.add('category');
    category.dataset.nroCategory = nroCategory;
        //field NAME. (DIV->LABEL->INPUT)
        let divName = document.createElement('div');
        divName.classList.add('attribute','name');
            let labelName = document.createElement('label');
            labelName.setAttribute('for','categoria.nombre.'+nroCategory);
            labelName.innerHTML = 'Cateoria';
                let inputName = document.createElement('input');
                inputName.setAttribute('name','categoria.nombre.'+nroCategory);
                inputName.setAttribute('type','text');
            labelName.appendChild(inputName);
        divName.appendChild(labelName);
        //field DESCRIPTION (DIV->LABEL->INPUT)
            let divDescrip = document.createElement('div');
            divDescrip.classList.add('attribute','description');
            let labelDescrip = document.createElement('label');
            labelDescrip.setAttribute('for','categoria.descripcion.'+nroCategory);
            labelDescrip.innerHTML = 'Descripcion';
                let inputDescrip = document.createElement('input');
                inputDescrip.setAttribute('name','categoria.descripcion.'+nroCategory);
                inputDescrip.setAttribute('type','text');
            labelDescrip.appendChild(inputDescrip);
        divDescrip.appendChild(labelDescrip);
        //Field Nominees List
        let ulNominees = document.createElement('ul');
        ulNominees.innerHTML = "Nominados:";
        ulNominees.classList.add('attribute','nominees-list');
        //inserto sus items nominados
        for (var i = 1; i <= input.value; i++) {
              console.log('insertando '+i+' nominado');
              let text = '<li class="nominee"> <div class="name"><label for="nominado.nombre" > <input name="nominado.nombre.'+nroCategory+'.'+i+'" type="text" placeholder="nombre"></label></div><div class="description"><label for="nominado.descripcion" >por<input name="nominado.descripcion.'+nroCategory+'.'+i+'" type="text" placeholder="pelicula"></label></div></li>'
              ulNominees.innerHTML =ulNominees.innerHTML + text;
          }
    //boton para eliminar esa categoria si se desea.
    let btnQuit = document.createElement('button');
    btnQuit.innerHTML='X';
    btnQuit.classList.add('btnQuit');
    btnQuit.dataset.nroCategory = nroCategory;
    btnQuit.addEventListener("click",function(){
      Novelties.removeCategory(nroCategory);
    });
    //agrega secciones finales.
    category.appendChild(btnQuit);
    category.appendChild(divName);
    category.appendChild(divDescrip);
    category.appendChild(ulNominees);
    //la agrego al div content.
    let divContent = document.querySelector('.form.award form .field.content');
    divContent.appendChild(category);
    //actualizo el input con el codigo html de categorys (para back()->withInput() en php)
    let inputContent = document.querySelector('.form.award form input[name="cuerpo"]');
    inputContent.value = divContent.innerHTML;
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

  let inputContent = document.querySelector('.form.news form input[name="cuerpo"]');
  inputContent.value = divContent.innerHTML;
}


Novelties.removeCategory = function(nroCategory){
  categoryQuit = document.querySelector('.category[data-nro-category="'+nroCategory+'"]');
  categoryQuit.classList.add('removed');
  categoryQuit.addEventListener('transitionend', function() {this.remove();});
}






//------------------------------------------------------------------------------------
//AJAX funcionalidad: por ahora, no se usa con los forms.
//------------------------------------------------------------------------------------
/*
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
}*/
