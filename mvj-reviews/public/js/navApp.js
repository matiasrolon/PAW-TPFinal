var window = window || {},
  document = document || {},
  console = console || {},
  NavPrincipal = NavPrincipal || {};

NavPrincipal.iniciarNavPrincipal= function(contenedorHTML){
     window.addEventListener("DOMContentLoaded", function(){

      var content = document.getElementById('content');

      //cuando hace click en cualquier espacio de la pagina, se sale el menu del perfil.
      content.addEventListener("click",function(){
         var op = document.querySelector('.opciones-login');
         if (op!=null){
            op.classList.add('no-visible');
         }
       })

      //cuando hace click al lado del nombre de usuario, se despliegan las opciones de login.
      var bop = document.querySelector('.boton-opciones-login');
      if (bop!=null){
         bop.addEventListener("click",function(){
              var op = document.querySelector('.opciones-login')
                  op.classList.remove('no-visible');
         });
      }

       NavPrincipal.contenedor = document.getElementById('app');
       console.log('APP asocio js con html ');
        NavPrincipal.buscador = document.getElementById('buscador');
        console.log(NavPrincipal.buscador);
        // cada vez que ingresa caracter en el buscador
        NavPrincipal.buscador.addEventListener("keyup",NavPrincipal.buscarFilm);

        //cuando hace click en cualquier espacio de la pagina, se sale la lista de resultados si la hubiera.
        content.addEventListener("click",NavPrincipal.borrarListaResultados);
     });
}


NavPrincipal.borrarListaResultados = function(){
    var content = document.getElementById('content');
    var secBuscador = document.querySelector('.navseccion.buscador');
    var lista = document.querySelector('.resultados-buscador');
    if (lista!=null){
      secBuscador.removeChild(lista);
    }
}

NavPrincipal.buscarFilm = function(){
    //Cuando apreta un caracter, se borra la lista de resultados actual ya que puede estar desactualizada.
    NavPrincipal.borrarListaResultados();

    if (NavPrincipal.buscador.value!=""){
      var request = new XMLHttpRequest();
      request.onreadystatechange = function(){ // cuando la peticion cambia de estado.
        console.log("estado de la peticion search film: " + this.status);
        if (this.readyState==4 && this.status==200){ // si se recibe correctamente la respuesta.
            NavPrincipal.recibirResponseSearchFilm(this);
        };
      }
      NavPrincipal.enviarRequestSearchFilm(request);
      console.log('escribio letra, texto hasta ahora: ' + NavPrincipal.buscador.value);
    }
}


NavPrincipal.enviarRequestSearchFilm = function(request){
    console.log("se va a enviar a '"+ NavPrincipal.buscador.value+"''");
    request.open("GET", "/search/"+NavPrincipal.buscador.value, true);
//    request.setRequestHeader('X-CSRF-Token', $('meta[name="csrf-token"]').attr('content'));
    request.send();
}

/*
<ul class="resultados-buscador">
    <li class="item-resultado">Item 1</li>
    <li class="item-resultado">Item 2</li>
</ul>
*/

NavPrincipal.recibirResponseSearchFilm= function(response){ //imprime lista de resultados en buscador
    var resp = JSON.parse(response.responseText);
    console.log("se recibio respuesta de searchLocalFilm ");

    var secBuscador = document.querySelector('.navseccion.buscador');
    var lista = document.createElement('ul');
    lista.classList.add('resultados-buscador');
    if (resp.length>0){
      for( i in resp){
          console.log(resp[i].titulo);
          var linkFilm = document.createElement('a');
          linkFilm.setAttribute('href',"/films/"+resp[i].id);
              var item = document.createElement('li');
              item.classList.add('item-resultado');
              item.innerHTML = resp[i].titulo + "("+resp[i].fecha_estreno+")";
          linkFilm.appendChild(item);
          lista.appendChild(linkFilm);
      }
      console.log("-------------");
      secBuscador.appendChild(lista);

    }else{ // si no se encontro ninguna peli con nombre similar
      var lista = document.createElement('ul');
      lista.classList.add('resultados-buscador');
        var item = document.createElement('li');
        item.classList.add('item-resultado');
        item.innerHTML="No se encontraron resultados";
      lista.appendChild(item);
      secBuscador.appendChild(lista);
    }
}
