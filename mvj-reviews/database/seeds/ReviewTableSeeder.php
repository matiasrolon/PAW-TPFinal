<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Film;
use App\Models\Review;

class ReviewTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::find(4);
        $film = Film::find(3);
        $review = new Review();
        $review->user_id = $user->id;
        $review->film_id = $film->id;
        $review->titulo = "Lo mejor del año";
        $review->descripcion = "La verdad que me gusto mucho, la voy a volver a ver";
        $review->save();

        $user = User::find(3);
        $film = Film::find(1);
        $review = new Review();
        $review->user_id = $user->id;
        $review->film_id = $film->id;
        $review->titulo = "Malisima";
        $review->descripcion = "Perdi mi tiempo en ir a verla, debi haber exigido que me devuelvan el dinero";
        $review->save();

        $user = User::find(1);
        $film = Film::find(4);
        $review = new Review();
        $review->user_id = $user->id;
        $review->film_id = $film->id;
        $review->titulo = "Cuando Italia exporte buena calidad";
        $review->descripcion = "Tendria que haber mas peliculas como estas, donde se muestra la fragilidad humana junto con la felicidad que puede aparecer hasta en el aspecto mas efimero y sencillo de la vida.";
        $review->save();

        $user = User::find(5);
        $film = Film::find(7);
        $review = new Review();
        $review->user_id = $user->id;
        $review->film_id = $film->id;
        $review->titulo = "Parodia a los reallitys yankes";
        $review->descripcion = "El enfoque es interesante, en mi puntuacion personal le doy un 78/100";
        $review->save();

        $user = User::find(2);
        $film = Film::find(7);
        $review = new Review();
        $review->user_id = $user->id;
        $review->film_id = $film->id;
        $review->titulo = "Mucho blabla y poco PUM PUM";
        $review->descripcion = "Decepciona al no ser como en los libros, no convencen los momentos de accion";
        $review->save();

        $user = User::find(3);
        $film = Film::find(8);
        $review = new Review();
        $review->user_id = $user->id;
        $review->film_id = $film->id;
        $review->titulo = "De lo bizarro a lo brillante";
        $review->descripcion = "Eso es exactamente lo que hace siempre Scorcece con sus habilidades para montar historias desopilantes y dejarnos enseñanzas a cada paso";
        $review->save();
    }
}
