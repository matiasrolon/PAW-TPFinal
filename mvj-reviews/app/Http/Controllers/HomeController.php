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
    public function __construct()
    {
      //  $this->middleware('auth'); //Para que pase por el login si no es usuario
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
      //Cambiar consulta: Peliculas con mas puntos de la ultima semana o mes.

        $peliculas = Film::where('categoria','Pelicula')->take(8)->orderBy('puntaje','desc')->get();
        foreach ($peliculas as $pelicula) {
          $pelicula->portada = base64_encode($pelicula->poster);
        }
        $series = Film::where('categoria','Serie')->get();
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
        return view('home', compact('peliculas','series','reviews', 'users', 'generos'));
    }

}
