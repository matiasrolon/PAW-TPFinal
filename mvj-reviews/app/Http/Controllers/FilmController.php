<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Film;
use App\Models\Review;
use App\Models\Score_Film;
use App\Models\PendentSearch;
use GuzzleHttp\Client;


class FilmController extends Controller
{

    /*
    * Busca un film solo en la BD del sitio.
    */
    public function searchLocalFilm($filmname){
      $obj = Film::where('titulo', 'like','%' . $filmname .'%')
                   ->select('id','titulo','fecha_estreno','pais','sinopsis', \DB::raw('TO_BASE64(poster) as poster'))
                   ->get();
      return $obj;
    }

    public function ranking(){
      $films = Film::orderBy('puntaje','desc')->take(100)->get();
      return view('ranking-films',compact('films'));
    }

    public function profile($film_id){
      $film = Film::where('id','=',$film_id)->first();
      $film->poster = base64_encode($film->poster);
      $reviews = Review::where('film_id','=',$film_id)
                         ->join('users','review.user_id','=','users.id')
                         ->select('review.*','users.username')
                         ->get();
  //var_dump($film->titulo);
     //return $film->titulo;
      return view('film_profile',compact('film','reviews'));
    }



    public function scoreFilm(){
        $obj = json_decode($_POST["objeto"]);
        $user = User::find($obj->user_id);
        $film = Film::find($obj->film_id);
        if ((($obj->puntaje)>10) || (($obj->puntaje)<0)){
          $obj->estado = "FAILED";
          $obj->mensaje = "El puntaje debe ser entre 1 y 10.";
        }else{
              if ($user==null){ //si no esta logeado -> no inserto nada en Score_Film
                $obj->estado = "FAILED";
                $obj->mensaje = "Debes iniciar sesion primero.";
              }else{ // si esta logeado
                $score_film = Score_Film::where('film_id',$film->id)
                                          ->where('user_id',$user->id)
                                          ->first();
                if ($score_film==null){// si no existe ese puntaje del usuario para esa pelicula, lo creo
                    $newScore_Film = new Score_Film();
                    $newScore_Film->puntaje = $obj->puntaje;
                    $newScore_Film->user_id = $user->id;
                    $newScore_Film->film_id = $film->id;
                    $newScore_Film->save();
                    $obj->estado = "OK";
                    $obj->mensaje = "Se añadio tu puntaje!";
                }else{ //el usuario ya punteo esta pelicula alguna vez, actualizo puntaje
                    $f = Score_Film::where('film_id',$film->id)
                                    ->where('user_id',$user->id)
                                    ->first();
                    $f->puntaje = $obj->puntaje;
                    $f->save();
                    $obj->estado = "OK";
                    $obj->mensaje = "Se actualizo tu puntaje!";
                }
              }
        }
        echo json_encode($obj);
    }


    /**
     * Esta funcion busca en la BD si hay coincidencias con lo que pone el usuario en el buscador
     * Luego responde con las coincidencias, que el vera en tiempo real (sin redireccionar la pagina).
     * @var filmName query que inserta el usuario en el buscador
     */
    public function searchSuggestions($filmname) {
      $obj = $this->searchLocalFilm($filmname);
      echo json_encode($obj);
    }


    /*
    Buscar (vista) que nos direcciona a la pagina con los resultados de la busqueda.
    */
    public function searchResults($searchText){
        $results = Film::where('titulo','like','%' . $searchText .'%')
                         ->get();
        if (count($results)==0){
            $search = PendentSearch::where('busqueda',$searchText)
                                    ->first();
            if ($search!=null){ //existe ya esa busqueda pendiente, actualizo cant busquedas
                $search->cant_busquedas =  ($search->cant_busquedas) +1;
                $search->save();
            }else{
              $new_search = new PendentSearch();
              $new_search->busqueda = $searchText;
              $new_search->save();
            }
        }
        return view('search',compact('results','searchText'));
    }

    /**
    * Busca peliculas o series de un genero especifico ordenadas por puntaje. (De a pedazos de data)
    * @var genero     Id del Genero
    * @var categoria  {PELICULA / SERIE}
    * @var offset     Comienza desde X registro
    * @var cant       Cantidad de tuplas que retorna.
    */
    public function searchByGenre($genero, $categoria, $offset, $cant) {
      $peliculas = Film::leftjoin('genre_film', 'film.id', '=', 'genre_film.film_id')
                   ->leftjoin('genre', 'genre.id', '=', 'genre_film.genre_id')
                   ->where('genre.id', '=', $genero)
                   ->where('film.categoria', '=', $categoria)
                   ->select('film.id','film.titulo','film.fecha_estreno','film.pais','film.sinopsis', 'film.puntaje', \DB::raw('TO_BASE64(film.poster) as poster'))
                   ->orderBy('puntaje','desc')
                   ->skip($offset)->take($cant)
                   ->get();
      // $peliculas = Film::select('id','titulo','fecha_estreno','pais','sinopsis','sinopsis', \DB::raw('TO_BASE64(poster) as poster')
      //               ->get();
      echo json_encode($peliculas);
    }



    /**
     * Para saber si la version que recupero de la API fue actualizada.
     * @param Film $filmAntiguo es el Film que tengo almacenado en la BD
     * @param Film $filmNuevo es el Film que recupero de la busqueda que hizo la API.
     * @return integer Codigos de respuesta:
     * * 1 = Esta actualizada;
     * * 0 = No esta actualizada;
     * * -1 = Error. Distinto id;
     * * -2 = Error. Distintto id_themoviedb;
     */
    public function isUpToDate($filmAntiguo, $filmNuevo){
        if ($filmAntiguo['id'] != $filmNuevo['id']) {
            return -1;
        } elseif ($filmAntiguo['id_themoviedb'] != $filmNuevo['id_themoviedb']) {
            return -2;
        } elseif ($filmAntiguo['hash'] != $filmNuevo['hash']) {
            return 0;
        } else {
            return 1;
        }
    }


    public function admin_films(){
      $searches = PendentSearch::where('estado','pendiente')
                                ->orderBy('cant_busquedas','desc')
                                ->get();
      return view('admin_films',compact('searches'));
    }

    /**
    *
    * @return
    */
    public function admin_search($filmname)
    {
        $DBFilms = $this->searchLocalFilm($filmname);
        return response()->json($DBFilms);
    }



    /**
     * - FIXME: Faltan algunas validaciones. No son de urgencia, solo dejo el recordatorio.
     * - Las fechas se almacenan en ingles: YYYY-MM-DD. En la API tambien es asi, por lo que esta bueno que asi sea.
     * - Mostrar la fecha en castellano debe ser un problema que soluciona la vista (MVC).
     * - Falta guardar el poster.
     * - Cambiar el campo 'trailer' por 'trailer_url'.
     * - Agregar los campos:
     *      'id_themoviedb' int
     *      'hash' string(40)
     *      'cant_temporadas' int
     */
    public function store(Request $request)
    {
        // Validate the request...
        $validator = Validator::make($request, [
            'titulo' => 'required|max:100',
            'fecha_estreno' => 'date',
            'sinopsis' => 'required|max:500',
            'anio' => 'regex:/[0-9]{4}/',
            'pais' => 'max:30',
            'duracion_min' => 'regex:/[0-9]+/',
            'categoria' => 'regex:/[0-9]{4}/',
            'fecha_finalizacion' => 'date'
        ]);

        if ($validator->fails()) {
            return redirect('post/create')
                        ->withErrors($validator)
                        ->withInput();

        $obra = new Film;
        $obra->titulo = $request->titulo;
        $obra->fecha_estreno = $request->fecha_estreno;
        $obra->sinopsis = $request->sinopsis;
        $obra->pais = $request->pais;
        $obra->duracion_min = $request->duracion_min;
        $obra->categoria = $request->categoria;
        $obra->fecha_finalizacion = $request->fecha_finalizacion;
        $obra->puntaje = 0;
        $obra->save();
    };
}

}
