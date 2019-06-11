<?php

use Illuminate\Database\Seeder;
use App\Models\Film;

class FilmTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//pelicula 1
        $film1 = new Film();
        $film1->titulo = "El señor de los anillos: La Comunidad del Anillo";
        $film1->fecha_estreno ='2003-03-03';
        $film1->sinopsis = "Frodo encuentra el anillo y comienza su gran aventura";
        $film1->pais = 'Estados Unidos';
        $film1->duracion_min = 179;
        $film1->categoria = 'Pelicula';
        $film1->puntaje=0;
        $film1->save();
//pelicula 2
        $film1 = new Film();
        $film1->titulo = "Atrapado sin salida";
        $film1->fecha_estreno ='1976-05-10';
        $film1->sinopsis = "Un rebelde se hace internar en un loquero y descubre que no es el unico cuerdo";
        $film1->pais = 'Estados Unidos';
        $film1->duracion_min = 135;
        $film1->categoria = 'Pelicula';
        $film1->puntaje=0;
        $film1->save();
//serie
        $film1 = new Film();
        $film1->titulo = "True Detective";
        $film1->fecha_estreno ='2014-01-08';
        $film1->fecha_finalizacion ='2014-04-08';
        $film1->sinopsis = "Un misterio por resolver lleno de misticismo y religion";
        $film1->pais = 'Estados Unidos';
        $film1->categoria = 'Serie de TV';
        $film1->duracion_min = 60;
        $film1->puntaje=0;
        $film1->save();
    }
}
