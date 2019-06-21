<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Film;
use App\Models\Review;
use App\Models\Score_Film;
use GuzzleHttp\Client;

class FilmController extends Controller
{
    //
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
                    Score_Film::where('film_id',$film->id)
                                ->where('user_id',$user->id)
                                ->update(['puntaje'=>($obj->puntaje)]);
                //  ACTUALIZA PUNTAJE PELICULA
                // (AVERIGUAR PORQUE NO FUNCIONA EL TRIGGER DE UPDATE EN SCORE_FILM)
                                $qScores =  Score_Film::where('film_id',$film->id)->count();
                                $totalScore =  Score_Film::where('film_id',$film->id)->sum('puntaje');

                                $film = Film::find($film->id);
                                $film->puntaje = $totalScore/$qScores;
                                $film->save();

                    $obj->estado = "OK";
                    $obj->mensaje = "Se actualizo tu puntaje!";
                }
              }
        }
        echo json_encode($obj);
    }


    /**
     * Esta funcion busca en la BD si hay coincidencias
     * Luego responde con las coincidencias.
     * @var filmName query que inserta el usuario en el buscador
     */
    public function searchLocalFilm($filmname) {
      $obj = Film::where('titulo', 'like','%' . $filmname .'%')->select('id','titulo','fecha_estreno','pais','sinopsis')->get();

          //$obj[];
          //$obj->estado = 'OK';
          //$obj->mensaje = 'recibi la request de search '+$filmname;  
      echo json_encode($obj);
    }

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
