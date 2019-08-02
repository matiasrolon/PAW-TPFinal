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

      factory(Review::class, 50)->create();

        $user = User::find(4);
        $film = Film::find(3);
        $review = new Review();
        $review->user_id = $user->id;
        $review->film_id = $film->id;
        $review->titulo = "Lo mejor del año";
        $review->descripcion = "MAe gusto mucho, la voy a volver a ver";
        $review->save();

        $user = User::find(3);
        $film = Film::find(1);
        $review = new Review();
        $review->user_id = $user->id;
        $review->film_id = $film->id;
        $review->titulo = "Malisima";
        $review->descripcion = "Perdi mi tiempo en ir a verla";
        $review->save();

        $user = User::find(1);
        $film = Film::find(4);
        $review = new Review();
        $review->user_id = $user->id;
        $review->film_id = $film->id;
        $review->titulo = "Italia exporta buena calidad";
        $review->descripcion = "Tendria que haber mas peliculas como estas";
        $review->save();

        $user = User::find(5);
        $film = Film::find(7);
        $review = new Review();
        $review->user_id = $user->id;
        $review->film_id = $film->id;
        $review->titulo = "Parodia a los reallitys yankes";
        $review->descripcion = "El enfoque es interesante, 78/100";
        $review->save();

        $user = User::find(2);
        $film = Film::find(7);
        $review = new Review();
        $review->user_id = $user->id;
        $review->film_id = $film->id;
        $review->titulo = "Mucho blabla y poco PUM PUM";
        $review->descripcion = "Decepciona al no ser como en los libros";
        $review->save();

        $user = User::find(3);
        $film = Film::find(8);
        $review = new Review();
        $review->user_id = $user->id;
        $review->film_id = $film->id;
        $review->titulo = "De lo bizarro a lo brillante";
        $review->descripcion = "Es exactamente lo que hace siempre Scorcece, genial ";
        $review->save();
    }
}
