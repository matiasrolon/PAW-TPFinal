<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Film;
use App\Models\User;
use App\Models\Review;
use App\Models\Genre;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {}

    /**
     * Home. Se muestra:
     * - Top 8 peliculas con mayor puntaje
     * - Las ultimas 8 series agregadas a nuestra BD
     *
     * Si existe un filtro de genero, muestra solo resultados de ese genero
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $genreId = $request->query('genreId');
        if ($genreId == null ) {
            $peliculas = Film::movies()->released()->orderBy('puntaje','desc')->take(8)->get();
            $series = Film::series()->orderBy('created_at','desc')->take(8)->get();
        } else {
            $peliculas = Film::movies()
                ->join('genre_film', 'film_id', '=', 'id')
                ->where('genre_id', $genreId)
                ->orderBy('puntaje','desc')
                ->take(8)->get();
            $series = Film::series()
                ->join('genre_film', 'film_id', '=', 'id')
                ->where('genre_id', $genreId)
                ->orderBy('film.created_at','desc')
                ->take(8)->get();
        }

        // FIXME: Esto se puede evitar agregando un global scope. Pero implica cambiar todas las referencias de "portada" a "poster"
        foreach ($peliculas as $pelicula) {
            $pelicula->portada = base64_encode($pelicula->poster);
        }
        foreach ($series as $serie) {
            $serie->portada = base64_encode($serie->poster);
        }

        $reviews = Review::join('users','review.user_id','=','users.id')
        ->join('film','review.film_id','=','film.id')
        ->select('review.id as review_id','review.titulo as review_titulo',
            'review.descripcion as review_descripcion','users.username as username',
            'film.id  as film_id', 'film.titulo as film_titulo', 'film.fecha_estreno as film_fecha_estreno')
        ->take(5)
        ->orderBy('review.created_at','desc')
        ->get();

        //Aca irian los primeros 15 o 20 usuarios con mejor ranking
        $users = User::orderBy('puntos','desc')->take(10)->get();
        foreach ($users as $user) {
            $cantReviews = Review::select('film_id')->where('user_id', $user->id)->get();
            $user->cantReviews = $cantReviews->count();
        }

        $generos = Genre::all();
        return view('home', compact('peliculas','series','reviews', 'users', 'generos', 'genreId'));
    }

}
