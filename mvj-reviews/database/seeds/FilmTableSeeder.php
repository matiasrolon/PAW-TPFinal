<?php

use Illuminate\Database\Seeder;
use App\Models\Film;
use App\Models\Genre;

class FilmTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//pelicula id =1
        $film1 = new Film();
        $film1->titulo = "El señor de los anillos: La Comunidad del Anillo";
        $film1->fecha_estreno ='2003-03-03';
        $film1->sinopsis = "Frodo encuentra el anillo y comienza su gran aventura para librarse de el";
        $film1->pais = 'Estados Unidos';
        $film1->categoria = 'Pelicula';
        $film1->poster = file_get_contents ('https://i.pinimg.com/originals/f4/7e/a5/f47ea5c518f38b55f48ff13f1c0a6fb2.jpg');
        $film1->trailer ='https://www.youtube.com/watch?v=V75dMMIW2B4&ab_channel=Movieclips';
        $film1->duracion_min = 179;
        $film1->save();
        $film1->genres()->attach( Genre::find(rand(1,10)));
        $film1->save();
//pelicula id =2
        $film1 = new Film();
        $film1->titulo = "Atrapado sin salida";
        $film1->fecha_estreno ='1976-05-10';
        $film1->sinopsis = "Un rebelde se hace internar en un loquero y descubre que no es el unico cuerdo en el lugar";
        $film1->pais = 'Estados Unidos';
        $film1->categoria = 'Pelicula';
        $film1->trailer ='https://www.youtube.com/watch?v=-pNMIhnlEho&ab_channel=amboliatoto';
        $film1->poster = file_get_contents ('https://images-na.ssl-images-amazon.com/images/I/71NbaIPFvkL._SY445_.jpg');
        $film1->duracion_min = 135;
        $film1->save();
        $film1->genres()->attach( Genre::find(rand(1,10)));
        $film1->save();
//pelicula id =3
        $film1 = new Film();
        $film1->titulo = "Harry Potter y la camara secreta";
        $film1->fecha_estreno ='2002-08-11';
        $film1->sinopsis = "Segundo año de Harry en en la escuela de magia y debe lidiar con un fantasma del pasado oscuro de Howarts";
        $film1->pais = 'Ingraterra';
        $film1->categoria = 'Pelicula';
        $film1->trailer ='https://www.youtube.com/watch?v=1bq0qff4iF8&ab_channel=MovieclipsClassicTrailers';
        $film1->poster = file_get_contents ('https://i.pinimg.com/originals/f4/7e/a5/f47ea5c518f38b55f48ff13f1c0a6fb2.jpg');
        $film1->duracion_min = 179;
        $film1->save();
        $film1->genres()->attach( Genre::find(rand(1,10)));
        $film1->save();
//pelicula id =4
        $film1 = new Film();
        $film1->titulo = "La vida es bella";
        $film1->fecha_estreno ='1976-05-10';
        $film1->sinopsis = "Un judio capturado en los campos de concentracion le enseña a su hijo lo lindo de la vida a pesar de todo.";
        $film1->pais = 'Italia';
        $film1->categoria = 'Pelicula';
        $film1->trailer ='https://www.youtube.com/watch?v=1bq0qff4iF8&ab_channel=MovieclipsClassicTrailers';
        $film1->poster = file_get_contents ('https://images-na.ssl-images-amazon.com/images/I/71NbaIPFvkL._SY445_.jpg');
        $film1->duracion_min = 135;
        $film1->save();
        $film1->genres()->attach( Genre::find(rand(1,10)));
        $film1->save();
//pelicula 5
        $film1 = new Film();
        $film1->titulo = "Transformers 3";
        $film1->fecha_estreno ='2003-03-03';
        $film1->sinopsis = "Los Autobots vuelven para la batalla final contra los Decepticons";
        $film1->pais = 'Estados Unidos';
        $film1->categoria = 'Pelicula';
        $film1->trailer ='https://www.youtube.com/watch?v=1bq0qff4iF8&ab_channel=MovieclipsClassicTrailers';
        $film1->poster = file_get_contents ('https://i.pinimg.com/originals/f4/7e/a5/f47ea5c518f38b55f48ff13f1c0a6fb2.jpg');
        $film1->duracion_min = 179;
        $film1->save();
        $film1->genres()->attach( Genre::find(rand(1,10)));
        $film1->save();
//pelicula id =6
        $film1 = new Film();
        $film1->titulo = "El Dia de la Marmota";
        $film1->fecha_estreno ='1993-05-10';
        $film1->sinopsis = "Un hombre engreido queda condenado a vivir el mismo dia en una ciudad que no conoce";
        $film1->pais = 'Estados Unidos';
        $film1->categoria = 'Pelicula';
        $film1->trailer ='https://www.youtube.com/watch?v=1bq0qff4iF8&ab_channel=MovieclipsClassicTrailers';
        $film1->poster = file_get_contents ('https://images-na.ssl-images-amazon.com/images/I/71NbaIPFvkL._SY445_.jpg');
        $film1->duracion_min = 135;
        $film1->save();
        $film1->genres()->attach( Genre::find(rand(1,10)));
        $film1->save();
//pelicula id =7
        $film1 = new Film();
        $film1->titulo = "Los Juegos del Hambre";
        $film1->fecha_estreno ='2012-06-06';
        $film1->sinopsis = "Katniss es elegida como tributo para participar de un duelo a muerte entre 24 sobrevivientes";
        $film1->pais = 'Estados Unidos';
        $film1->categoria = 'Pelicula';
        $film1->trailer ='https://www.youtube.com/watch?v=1bq0qff4iF8&ab_channel=MovieclipsClassicTrailers';
        $film1->poster = file_get_contents ('https://i.pinimg.com/originals/f4/7e/a5/f47ea5c518f38b55f48ff13f1c0a6fb2.jpg');
        $film1->duracion_min = 179;
        $film1->save();
        $film1->genres()->attach( Genre::find(rand(1,10)));
        $film1->save();
//pelicula id =8
        $film1 = new Film();
        $film1->titulo = "El Lobo de Wall street";
        $film1->fecha_estreno ='2013-12-11';
        $film1->sinopsis = "La excentrica vida del multimillonario de Walltreet Jordan Belfort";
        $film1->pais = 'Estados Unidos';
        $film1->categoria = 'Pelicula';
        $film1->trailer ='https://www.youtube.com/watch?v=1bq0qff4iF8&ab_channel=MovieclipsClassicTrailers';
        $film1->poster = file_get_contents ('https://images-na.ssl-images-amazon.com/images/I/71NbaIPFvkL._SY445_.jpg');
        $film1->duracion_min = 135;
        $film1->save();
        $film1->genres()->attach( Genre::find(rand(1,10)));
        $film1->save();



//serie 1 id =9
        $film1 = new Film();
        $film1->titulo = "True Detective";
        $film1->fecha_estreno ='2014-01-08';
        $film1->fecha_finalizacion ='2014-04-08';
        $film1->sinopsis = "Un misterio por resolver lleno de misticismo y religion";
        $film1->pais = 'Estados Unidos';
        $film1->categoria = 'Serie';
        $film1->trailer ='https://www.youtube.com/watch?v=1bq0qff4iF8&ab_channel=MovieclipsClassicTrailers';
        $film1->poster = file_get_contents ('https://playmax.xyz/img/c/400/1/1485452104/58.jpg');
        $film1->duracion_min = 0;
        $film1->save();
        $film1->save();
        $film1->genres()->attach( Genre::find(rand(1,10)));
        $film1->save();

//serie 2 id =10
        $film1 = new Film();
        $film1->titulo = "Breaking Bad";
        $film1->fecha_estreno ='2008-07-10';
        $film1->fecha_finalizacion ='2013-10-13';
        $film1->sinopsis = "Un profesor se mete en el negocio de las drogas cuando se entera que tiene cancer.";
        $film1->pais = 'Estados Unidos';
        $film1->categoria = 'Serie';
        $film1->trailer ='https://www.youtube.com/watch?v=1bq0qff4iF8&ab_channel=MovieclipsClassicTrailers';
        $film1->poster = file_get_contents ('http://www.caratulasylogos.com/sites/default/files/breaking_bad.jpg');
        $film1->duracion_min = 45;
        $film1->save();
        $film1->genres()->attach( Genre::find(rand(1,10)));
        $film1->save();

//serie 3 id =11
        $film1 = new Film();
        $film1->titulo = "Friends";
        $film1->fecha_estreno ='1994-01-08';
        $film1->fecha_finalizacion ='2004-04-08';
        $film1->sinopsis = "Un grupo de amigos viven una desopilante vida juntos en un apartamento de New Tork";
        $film1->pais = 'Estados Unidos';
        $film1->categoria = 'Serie';
        $film1->trailer ='https://www.youtube.com/watch?v=1bq0qff4iF8&ab_channel=MovieclipsClassicTrailers';
        $film1->poster = file_get_contents ('https://playmax.xyz/img/c/400/1/1485452104/58.jpg');
        $film1->duracion_min = 60;
        $film1->save();
        $film1->genres()->attach( Genre::find(rand(1,10)));
        $film1->save();

//serie 4 id =12
        $film1 = new Film();
        $film1->titulo = "Vikings";
        $film1->fecha_estreno ='2013-07-10';
        $film1->fecha_finalizacion ='2019-01-13';
        $film1->sinopsis = "Las conquistas del legendario Vikingo Ragnar LothBrok en su afan de descubrir nuevos mundos.";
        $film1->pais = 'Irlanda';
        $film1->categoria = 'Serie';
        $film1->trailer ='https://www.youtube.com/watch?v=1bq0qff4iF8&ab_channel=MovieclipsClassicTrailers';
        $film1->poster = file_get_contents ('http://www.caratulasylogos.com/sites/default/files/breaking_bad.jpg');
        $film1->duracion_min = 45;
        $film1->puntaje=0;
        $film1->save();
        $film1->genres()->attach( Genre::find(rand(1,10)));
        $film1->save();
    }
}
