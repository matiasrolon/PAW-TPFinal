var window = window || {},
  document = document || {},
  console = console || {},
  Home = Home || {};

Home.iniciarPagina= function(){
     window.addEventListener("DOMContentLoaded", function(){
        console.log('INICIO LA HOME');
        setInterval(Home.actualizarUltimasReviews, 15000);
     });
}


Home.actualizarUltimasReviews = function(){
//--------- solicitud ajax
    var request = new XMLHttpRequest();
    request.onreadystatechange = function(){ // cuando la peticion cambia de estado.
      console.log("estado de la peticion Film: " + this.status);
      if (this.readyState==4 && this.status==200){ // si se recibe correctamente la respuesta.
          Home.recibirResponseUltimasReviews(this);
      };
    }
    //envio la request
    console.log("se va a enviar a '"+ NavPrincipal.buscador.value+"''");
    request.open("GET", "/lastReviews");
    request.send();
}


/*
* Funcion: recibe la request con las nuevas reviews ACTUALIZADA y lo compara
*  con la lista de nuevas reviews que esta en pantalla actualmente.
*/
Home.recibirResponseUltimasReviews= function(response){
    var resp = JSON.parse(response.responseText);
   console.log("se recibio respuesta> "+ resp.length);

//--------- actualizo la vista

/*  En primera instancia, solo compara la primer review de la pantalla (supuestamente la
*  mas reciente), y se fija en que posicion del nuevo array esta,
*/
  var primerReview = document.querySelector('.ultimas-reviews-container li');
  var encontro = false;
  var i=0;
  while ((!encontro)&&(i<resp.length)){
      if (resp[i]['review_id']==primerReview.getAttribute('review_id')){
          encontro=true;
          desplazamiento=i;
      }else
        {i++;}
  }

  if (!encontro){desplazamiento=resp.length}
  console.log('se desplazo el div en '+desplazamiento +' reviews nuevas');
  /*  asi sabe cuantas reviews nuevas se generaron despues de ella.
  *  Esto es para saber cuantas tengo que insertar arriba de todo y no volver a cargar todas de cero.
  */
  var padreUltReviews = document.querySelector('.ultimas-reviews-container');
  //recorre por la cantidad de reviews nuevas que hay e inserta.
  for (n=0;n<desplazamiento;n++){
    console.log(resp[n]['review_id'] + " es una review nueva. Dice: "+resp[n]['review_descripcion']);
    console.log('insertando review nueva '+n +' de '+desplazamiento);

    //elimino una de las ultimas reviews (viejas)
    var ultReviewsAnteriores = document.querySelectorAll('.ultimas-reviews-container li');
    padreUltReviews.removeChild(ultReviewsAnteriores[ultReviewsAnteriores.length-1]);

    //creo el LI que contendra la review nueva.
    var newReview = document.createElement('li');
    newReview.setAttribute('review_id',resp[n]['review_id']);
        var user = document.createElement('p');
        user.innerHTML ='@<a href="/users/'+resp[n]['username']+'">'+resp[n]['username']+'</a> dijo:';
        var comentario = document.createElement('div');
        comentario.classList.add('comment');
             var comentinner = document.createElement('div');
             comentinner.classList.add('comment-inner');
                  var titulo = document.createElement('h3');
                  titulo.innerHTML =  resp[n]['review_titulo'];
                  var descrip = document.createElement('p');
                  descrip.innerHTML = '"'+resp[n]['review_descripcion'].substring(0,100)+'..."';
                  var pelicula = document.createElement('p');
                  pelicula.innerHTML = 'Sobre: <a href="/films/'+resp[n]['film_id']+'"> '+resp[n]['film_titulo']+'</a>';
            comentinner.appendChild(titulo);
            comentinner.appendChild(descrip);
            comentinner.appendChild(pelicula);
        comentario.appendChild(comentinner);
    newReview.appendChild(user);
    newReview.appendChild(comentario);
    padreUltReviews.insertBefore(newReview,ultReviewsAnteriores[0]);
    console.log('nueva review insertada');
  }

}
