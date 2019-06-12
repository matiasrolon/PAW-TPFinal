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
        $film1->categoria = 'Pelicula';
        $film1->poster = file_get_contents ('https://i.pinimg.com/originals/f4/7e/a5/f47ea5c518f38b55f48ff13f1c0a6fb2.jpg');
        $film1->duracion_min = 179;
        $film1->puntaje=0;
        $film1->save();
//pelicula 2
        $film1 = new Film();
        $film1->titulo = "Atrapado sin salida";
        $film1->fecha_estreno ='1976-05-10';
        $film1->sinopsis = "Un rebelde se hace internar en un loquero y descubre que no es el unico cuerdo";
        $film1->pais = 'Estados Unidos';
        $film1->categoria = 'Pelicula';
        $film1->poster = file_get_contents ('https://images-na.ssl-images-amazon.com/images/I/71NbaIPFvkL._SY445_.jpg');
        $film1->duracion_min = 135;
        $film1->puntaje=0;
        $film1->save();
//pelicula 3
        $film1 = new Film();
        $film1->titulo = "El señor de los anillos: La Comunidad del Anillo";
        $film1->fecha_estreno ='2003-03-03';
        $film1->sinopsis = "Frodo encuentra el anillo y comienza su gran aventura";
        $film1->pais = 'Estados Unidos';
        $film1->categoria = 'Pelicula';
        $film1->poster = file_get_contents ('https://i.pinimg.com/originals/f4/7e/a5/f47ea5c518f38b55f48ff13f1c0a6fb2.jpg');
        $film1->duracion_min = 179;
        $film1->puntaje=0;
        $film1->save();
//pelicula 4
        $film1 = new Film();
        $film1->titulo = "Atrapado sin salida";
        $film1->fecha_estreno ='1976-05-10';
        $film1->sinopsis = "Un rebelde se hace internar en un loquero y descubre que no es el unico cuerdo";
        $film1->pais = 'Estados Unidos';
        $film1->categoria = 'Pelicula';
        $film1->poster = file_get_contents ('https://images-na.ssl-images-amazon.com/images/I/71NbaIPFvkL._SY445_.jpg');
        $film1->duracion_min = 135;
        $film1->puntaje=0;
        $film1->save();
//pelicula 5
        $film1 = new Film();
        $film1->titulo = "El señor de los anillos: La Comunidad del Anillo";
        $film1->fecha_estreno ='2003-03-03';
        $film1->sinopsis = "Frodo encuentra el anillo y comienza su gran aventura";
        $film1->pais = 'Estados Unidos';
        $film1->categoria = 'Pelicula';
        $film1->poster = file_get_contents ('https://i.pinimg.com/originals/f4/7e/a5/f47ea5c518f38b55f48ff13f1c0a6fb2.jpg');
        $film1->duracion_min = 179;
        $film1->puntaje=0;
        $film1->save();
//pelicula 6
        $film1 = new Film();
        $film1->titulo = "Atrapado sin salida";
        $film1->fecha_estreno ='1976-05-10';
        $film1->sinopsis = "Un rebelde se hace internar en un loquero y descubre que no es el unico cuerdo";
        $film1->pais = 'Estados Unidos';
        $film1->categoria = 'Pelicula';
        $film1->poster = file_get_contents ('https://images-na.ssl-images-amazon.com/images/I/71NbaIPFvkL._SY445_.jpg');
        $film1->duracion_min = 135;
        $film1->puntaje=0;
        $film1->save();
//pelicula 7
        $film1 = new Film();
        $film1->titulo = "El señor de los anillos: La Comunidad del Anillo";
        $film1->fecha_estreno ='2003-03-03';
        $film1->sinopsis = "Frodo encuentra el anillo y comienza su gran aventura";
        $film1->pais = 'Estados Unidos';
        $film1->categoria = 'Pelicula';
        $film1->poster = file_get_contents ('https://i.pinimg.com/originals/f4/7e/a5/f47ea5c518f38b55f48ff13f1c0a6fb2.jpg');
        $film1->duracion_min = 179;
        $film1->puntaje=0;
        $film1->save();
//pelicula 8
        $film1 = new Film();
        $film1->titulo = "Atrapado sin salida";
        $film1->fecha_estreno ='1976-05-10';
        $film1->sinopsis = "Un rebelde se hace internar en un loquero y descubre que no es el unico cuerdo";
        $film1->pais = 'Estados Unidos';
        $film1->categoria = 'Pelicula';
        $film1->poster = file_get_contents ('https://images-na.ssl-images-amazon.com/images/I/71NbaIPFvkL._SY445_.jpg');
        $film1->duracion_min = 135;
        $film1->puntaje=0;
        $film1->save();



//serie 1
        $film1 = new Film();
        $film1->titulo = "True Detective";
        $film1->fecha_estreno ='2014-01-08';
        $film1->fecha_finalizacion ='2014-04-08';
        $film1->sinopsis = "Un misterio por resolver lleno de misticismo y religion";
        $film1->pais = 'Estados Unidos';
        $film1->categoria = 'Serie';
        $film1->poster = file_get_contents ('https://playmax.xyz/img/c/400/1/1485452104/58.jpg');
        $film1->duracion_min = 60;
        $film1->puntaje=0;
        $film1->save();

//serie 2
        $film1 = new Film();
        $film1->titulo = "Breacking Bad";
        $film1->fecha_estreno ='2008-07-10';
        $film1->fecha_finalizacion ='2013-10-13';
        $film1->sinopsis = "Un profesor se mete en el negocio de las drogas cuando se entera que tiene cancer.";
        $film1->pais = 'Estados Unidos';
        $film1->categoria = 'Serie';
        $film1->poster = file_get_contents ('http://www.caratulasylogos.com/sites/default/files/breaking_bad.jpg');
        $film1->duracion_min = 45;
        $film1->puntaje=50;
        $film1->save();

//serie 3
        $film1 = new Film();
        $film1->titulo = "True Detective";
        $film1->fecha_estreno ='2014-01-08';
        $film1->fecha_finalizacion ='2014-04-08';
        $film1->sinopsis = "Un misterio por resolver lleno de misticismo y religion";
        $film1->pais = 'Estados Unidos';
        $film1->categoria = 'Serie';
        $film1->poster = file_get_contents ('https://playmax.xyz/img/c/400/1/1485452104/58.jpg');
        $film1->duracion_min = 60;
        $film1->puntaje=0;
        $film1->save();

//serie 4
        $film1 = new Film();
        $film1->titulo = "Breacking Bad";
        $film1->fecha_estreno ='2008-07-10';
        $film1->fecha_finalizacion ='2013-10-13';
        $film1->sinopsis = "Un profesor se mete en el negocio de las drogas cuando se entera que tiene cancer.";
        $film1->pais = 'Estados Unidos';
        $film1->categoria = 'Serie';
        $film1->poster = file_get_contents ('http://www.caratulasylogos.com/sites/default/files/breaking_bad.jpg');
        $film1->duracion_min = 45;
        $film1->puntaje=50;
        $film1->save();
    }
}
