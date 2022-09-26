var FilmCardData = FilmCardData || {};

FilmCardData.getClasePuntaje = function (score) {
    let cl;
    if (score == 0) cl = "sin-puntuar";
    else if (score < 3.3) cl = "puntuacion-mala";
    else if (score < 6.6) cl = "puntuacion-buena";
    else cl = "puntuacion-muy-buena";
    return cl;
}

FilmCardData.modificarPuntajeClase = function () {
    let array = document.querySelectorAll(".puntuacion");
    for (let score of array) {
        score.classList.add(FilmCardData.getClasePuntaje(score.innerHTML));
    }
}


var xDown = null;
var yDown = null;

FilmCardData.enableSwipeOnCards = function () {
    var cards = document.getElementsByClassName("flip-card");
    Array.from(cards).forEach(element => {
        element.addEventListener('touchstart', handleTouchStart, false);
        element.addEventListener('touchmove', handleTouchMove, false);
    });
}

function getTouches(evt) {
  return evt.touches;
}

function handleTouchStart(evt) {
    const firstTouch = getTouches(evt)[0];
    xDown = firstTouch.clientX;
    yDown = firstTouch.clientY;
}

function handleTouchMove(evt) {
    if ( ! xDown || ! yDown ) {
        return;
    }

    var xUp = evt.touches[0].clientX;
    var yUp = evt.touches[0].clientY;

    var xDiff = xDown - xUp;
    var yDiff = yDown - yUp;

    // If horizontal swipe
    if ( Math.abs( xDiff ) > Math.abs( yDiff ) ) {
        this.querySelector('.flip-card-inner').classList.toggle("rotate-card");
    }

    xDown = null;
    yDown = null;
}
