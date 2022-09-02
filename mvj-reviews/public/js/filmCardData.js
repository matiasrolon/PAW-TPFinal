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
