<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Film;
use App\Models\User;
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

        $peliculas = Film::where('categoria','Pelicula')->get();
        foreach ($peliculas as $pelicula) {
          $pelicula->portada = base64_encode($pelicula->poster);
        }
        $series = Film::where('categoria','Serie')->get();
        foreach ($series as $serie) {
          $serie->portada = base64_encode($serie->poster);
        }

        //Aca irian los primeros 15 o 20 usuarios con mejor ranking
        $users = User::orderBy('puntos','desc')->take(5)->get();
        $generos = Genre::all();
        return view('home', compact('peliculas','series','users', 'generos'));
    }

}
