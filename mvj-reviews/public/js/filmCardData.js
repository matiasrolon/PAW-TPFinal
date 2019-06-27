var FilmCardData = FilmCardData || {};

FilmCardData.getClasePuntaje = function(p) {
  let cl;
  if (p < 3.3) cl = "puntuacion-mala";
  else if (p < 6.6) cl = "puntuacion-buena";
  else cl = "puntuacion-muy-buena";
  return cl;
}

FilmCardData.modificarPuntajeClase = function() {
  window.addEventListener("DOMContentLoaded", function(){
    let array = document.querySelectorAll(".puntuacion");
    for (let p of array) {
      p.classList.add(FilmCardData.getClasePuntaje(p.innerHTML));
    }
  });
}
