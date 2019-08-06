<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Film;
use App\Models\Review;
use App\Models\Genre;
use App\Models\Score_Film;
use App\Models\PendentSearch;
use GuzzleHttp\Client;
use function GuzzleHttp\json_decode;
// use Illuminate\Validation\Validator;
// Este es el que esta en app/config/app.php
use Illuminate\Support\Facades\Validator;
// use \Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Storage;
use Symfony\Component\HttpKernel\Log\Logger;

class FilmController extends Controller
{

    public function searchByApiId($idApi) {
      return Film::where('id_themoviedb', '=', $idApi)->first();
    }

    /**
    * Busca films (puede ser ninguno, uno o muchos) solo en la BD del sitio.
    */
    public function searchLocalFilm($filmname){
      $obj = Film::where('titulo', 'like','%' . $filmname .'%')
                   ->select('id','titulo','sinopsis','fecha_estreno','duracion_min','fecha_finalizacion',
                            'pais','trailer','puntaje','categoria', \DB::raw('TO_BASE64(poster) as poster'))
                   ->get();
      return $obj;
    }


    /**
    * obtiene la lista de paises desde el archivo api.countries.
    */
    static public function getCountries(){
        $paises = array();
        $archivo = Storage::get('api.countries.es.json');
        $contenido = json_decode($archivo);
        $i = 0;
        while ($i < sizeof($contenido)) {
            // Error raro sino pongo el isset()
            if (isset($contenido[$i]->spanish_name)) {
                // Agrego el pais al arreglo
                $paises[] =  $contenido[$i]->spanish_name;
            }
            $i++;
        }
        sort($paises);
        return $paises;
    }

    /**
    * obtiene la lista de generos de film desde el archivo api.genres.
    */
    static public function getGenres(){
        $generos = array();
        $archivo = Storage::get('api.genres.es.json');
        $contenido = json_decode($archivo);
        $i = 0;
        while ($i < sizeof($contenido)) {
            if (isset($contenido[$i]->name)) {
                $generos[] =  $contenido[$i]->name;
            }
            $i++;
        }
        sort($generos);
        return $generos;
    }


    public function ranking(){
      $films = Film::orderBy('puntaje','desc')
                    ->select('film.*',\DB::raw('TO_BASE64(film.poster) as poster64'))
                    ->take(100)
                    ->get();

      return view('ranking-films',compact('films'));
    }

//perfil de film
    public function profile($film_id,$review_id=null){
      $reviewIni = null;
      $film = Film::where('id','=',$film_id)->first();
      $film->poster = base64_encode($film->poster);
      if ($review_id!=null){
        $reviewIni = Review::where('review.id','=',$review_id)
                            ->join('users','review.user_id','=','users.id')
                            ->select('review.*','users.username')
                            ->first();
      }
      $reviews = Review::where('film_id','=',$film_id)
                         ->join('users','review.user_id','=','users.id')
                         ->select('review.id','titulo','descripcion','positivos','negativos',
                         'review.created_at','user_id','film_id','users.username')
                         ->skip(0)
                         ->take(4)
                         ->get();
      $generos = $film->genres()->get();

        return view('film_profile',compact('film','reviews', 'generos','reviewIni'));

    }



    public function scoreFilm(){
        $obj = json_decode($_POST["objeto"]);
        $film = Film::find($obj->film_id);
        if ((($obj->puntaje)>10) || (($obj->puntaje)<0)){
          $obj->estado = "FAILED";
          $obj->tipoError = "rango_puntaje";
          $obj->mensaje = "El puntaje debe ser entre 1 y 10.";
        }else{
              if (Auth()->user()==null){ //si no esta logeado -> no inserto nada en Score_Film
                $obj->estado = "FAILED";
                $obj->tipoError = "sesion_usuario";
                $obj->mensaje = "Debes iniciar sesion primero.";
              }else{ // si esta logeado
                $score_film = Score_Film::where('film_id',$film->id)
                                          ->where('user_id',Auth()->user()->id)
                                          ->first();
                if ($score_film==null){// si no existe ese puntaje del usuario para esa pelicula, lo creo
                    $newScore_Film = new Score_Film();
                    $newScore_Film->puntaje = $obj->puntaje;
                    $newScore_Film->user_id = Auth()->user()->id;
                    $newScore_Film->film_id = $film->id;
                    $newScore_Film->save();
                    $obj->estado = "OK";
                    $obj->mensaje = "Se añadio tu puntaje!";
                }else{ //el usuario ya punteo esta pelicula alguna vez, actualizo puntaje
                    $f = Score_Film::where('film_id',$film->id)
                                    ->where('user_id',Auth()->user()->id)
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
                   ->select('film.id','film.titulo','film.fecha_estreno','film.pais','film.sinopsis',
                   'film.puntaje', \DB::raw('TO_BASE64(film.poster) as poster'))
                   ->orderBy('puntaje','desc')
                   ->skip($offset)->take($cant)
                   ->get();
      // $peliculas = Film::select('id','titulo','fecha_estreno','pais','sinopsis','sinopsis', \DB::raw('TO_BASE64(poster) as poster')
      //               ->get();
      echo json_encode($peliculas);
    }


    /**
     * Marca como "RESUELTA" la busqueda pendiente indicada por el usuario.
     * De esta forma ya no aoarecera mas en Admin_Films
    */
    public function solvePendentFilm() {
      $searchText = json_decode( $_POST['objeto'], true )['searchText'];
      // return 'PHP: ' . $searchText;
      $search = PendentSearch::where('busqueda', $searchText)->first();
      if ($search != null) {
          $search->estado = 'Resuelta';
          $search->save();
          return response('OK');
      } else {
        return response('No se encontro una busqueda con ese nombre', 404);
      }
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

    /**
     * Muestra la pagina admin films, para interactuar con la Api
     * pudiendo dar de alta, modificar o elimianr Films.
     * Ademas, se muestran las busquedas que fueron realizadas por los usuarios
     *  que no obtuvieron resultados, por orden de importancia.
     */
    public function admin_films(){
      $searches = PendentSearch::where('estado','pendiente')
                                ->orderBy('cant_busquedas','desc')
                                ->get();

      // Hago una lista de los paises disponibles
      $paises = $this->getCountries();
      $generos = $this->getGenres();
      $categorias = Film::$categorias;

      return view('admin_films',compact('searches', 'paises', 'generos', 'categorias'));
    }


    /**
    * Devuelve las peliculas almacenadas en la BD que coinciden con la keyword
    * @return json
    */
    public function admin_search($filmname)
    {
        $DBFilms = $this->searchLocalFilm($filmname);
        // Agrego los generos a la respuesta
        $filmsWithGenre = array();
        $genPorFilm = array(); // Generos por film. Ya que el parse en el js espera recibir un arreglo
        foreach ($DBFilms as $film) {
          // Me devuelve un objeto genero. Me quedo solo con el nombre
          foreach ($film->genres()->get() as $genre) {
            $genPorFilm[] = $genre->nombre;
          }
          // Le saco la coma del final
          $film->genero = $genPorFilm;
          $filmsWithGenre[] = $film;
          // Limpio la variable auxiliar
          $genPorFilm = array();
        }
        return response()->json($filmsWithGenre);
    }

    /**
     * Metodo recomendado de laravel para actualizar
     *  URL: https://laracasts.com/series/laravel-from-scratch-2018/episodes/12
     */
    public function update() {

    }


    /**
     * - FIXME:
     * - UPDATE 27/06 : Se considero que este es el controller ideal para realizar los store ya que
    *                   ApiController se enfoca en la interaccion con la API.
     * - Las fechas se almacenan en ingles: YYYY-MM-DD. En la API tambien es asi, por lo que esta bueno que asi sea.
     * - Mostrar la fecha en castellano debe ser un problema que soluciona la vista (MVC).
     * - Cambiar el campo 'trailer' por 'trailer_url'.
     *      'cant_temporadas' int
     */
    public function store(Request $request){

      // En el HTTP request debe ponerse 'Accept: application/json' en el header
      // Para que te devuelva un JSON y un HTTP 422 si el validador falla
      $request->validate([
        'titulo' => 'required|max:100',
        'fecha_estreno' => 'required|date',
        'sinopsis' => 'required|max:1000',
        'pais' => 'max:30',
        'duracion_min' => 'nullable|numeric|min:1|max:3600', // Es necesario el nullable
        'categoria' => ['required', Rule::in(Film::$categorias)],
        'fecha_finalizacion' => 'nullable|date', // Aca tambien
        'trailer' =>'max:300'
      ]);

      // Los datos pasan la validacipn
      // Si es un film de la API, contendra ID=-1;         ??????
      $filmOriginal = Film::where('id',$request->id)->first();
      if ($filmOriginal!=null){
        $filmOriginal->titulo = $request->titulo;
        $filmOriginal->fecha_estreno = $request->fecha_estreno;
        $filmOriginal->sinopsis = $request->sinopsis;
        $filmOriginal->pais = $request->pais;
        // Lo deshabilito temporalmente, ya que no puedo actualizar el poster
        // $filmOriginal->poster = $request->poster; //sin el file_get_contents porque ya esta en base64
        $filmOriginal->duracion_min = $request->duracion_min;
        $filmOriginal->categoria = $request->categoria;

        if (!empty($request->fecha_finalizacion)) {
          $filmOriginal->fecha_finalizacion = $request->fecha_finalizacion;
        }
        $filmOriginal->trailer = $request->trailer;
        $filmOriginal->save();

        // *** Reviso si cambiaron los generos ***
        $generosActuales = $filmOriginal->genres()->select('nombre')->get();
        // Paso el array recibido a un Tipo Coleccion.
        $generosEnviados = Genre::all()->whereIn('nombre',$request->genero);

        // Quito los generos que ya no estan (Actuales - Nuevos(todos))
        $genABorrar = $generosActuales->diff($generosEnviados);
        if ($genABorrar) {
          // $filmOriginal->genres()->whereIn('genre_id',$genABorrar)->delete();
          // delete() es para borrar la tupla de la tabla genero
          // detach() es para borrar la relacion en la tabla intermedia.
          $filmOriginal->genres()->whereIn('genre_id',$genABorrar)->detach();
        }

        // Agrego los generos nuevos (Nuevos(Todos) - Actuales)
        $genAAgregar = $generosEnviados->diff($generosActuales);
        if ($genAAgregar) {
          $filmOriginal->genres()->attach($genAAgregar);
        }

        // $request->estado ='OK';
        $request['mensaje'] = 'Actualización exitosa.';
      } else {
        $obra = new Film;
        $obra->titulo = $request->titulo;
        $obra->fecha_estreno = $request->fecha_estreno;
        $obra->sinopsis = $request->sinopsis;
        $obra->pais = $request->pais;
        // Ver que pasa si la pelicula no trae el poster.
        $obra->poster = file_get_contents($request->poster);
        $obra->duracion_min = $request->duracion_min;
        $obra->categoria = $request->categoria;

        if (!empty($obra->fecha_finalizacion)) {
          $obra->fecha_finalizacion = $request->fecha_finalizacion;
        }
        $obra->trailer = $request->trailer;
        $obra->id_themoviedb = $request->id_themoviedb;
        $obra->save();

        // Agrego los generos
        $generosEnviados = $request->genero;
        $coincidencias = Genre::all();
        // Obtengo todos los modelos de los generos que coinciden con los nombres de los que me enviaron
        $coincidencias = $coincidencias->intersect( Genre::whereIn('nombre', $generosEnviados)->get() );

        // Hago la relacion en la tabla intermedia
        foreach ($coincidencias as $coincidencia) {
            $obra->genres()->attach($coincidencia);
        }

        $request['id'] = $obra->id;// actualizo con el nuevo id
        // $request->estado ='OK'; // Esto no va
        $request['mensaje'] = 'Guardado exitoso.';
      } // end IF id!=-1

      return response()->json($request);
    } // end store film

    /**
     * Elimina un film de la BD por la ID.
     */
    public function destroy($id) {
      $film = Film::find($id);
      if ($film != null) {
        // Las FKs se eliminan por cascada
        $aux = $film;
        try {
          if ($film->delete()){
            $aux['mensaje'] = 'Eliminado exitoso.';
            return response()->json($aux);
          }
        } catch (\Illuminate\Database\QueryException $e) {
          // SQL 23000: Constraint Violation xq tiene alguna FK puesta en NO ACTION
          Log::error('Error en FilmController@destroy: ' . $e->getMessage());
          return response('Error al intentar borrar el film: ' . $film->titulo, 409);
        }
      }
      // Else: id inexistente
      return response('Not found',404);
    }

} // end controller
