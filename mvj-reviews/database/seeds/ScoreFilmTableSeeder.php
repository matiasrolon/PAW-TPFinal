<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Film;
use App\Models\Score_Film;


class ScoreFilmTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   //La pelicula con id=2 tiene 3 votos con un puntaje total de 16.
        //Por ende el puntaje en Film de esa pelicula deberia ser 5.33 (16/3)
        
        $score_film = new Score_Film();
        $score_film->user_id = User::find(1)->id;
        $score_film->film_id = Film::find(2)->id;
        $score_film->puntaje = 8;
        $score_film->save();

        $score_film = new Score_Film();
        $score_film->user_id = User::find(2)->id;
        $score_film->film_id = Film::find(3)->id;
        $score_film->puntaje = 6;
        $score_film->save();

        $score_film = new Score_Film();
        $score_film->user_id = User::find(1)->id;
        $score_film->film_id = Film::find(3)->id;
        $score_film->puntaje = 7;
        $score_film->save();

        $score_film = new Score_Film();
        $score_film->user_id = User::find(7)->id;
        $score_film->film_id = Film::find(3)->id;
        $score_film->puntaje = 3;
        $score_film->save();
        //AGREGAR MAS PRUEBAS PARA LUEGO PROBAR EL RANKING
        //(SIN NECESIDAD QUE ESTE TERMINADA LA PAGINA DE VOTAR PELICULA)
    }
}
