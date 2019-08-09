<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Score_Review;
use App\Models\User;
use App\Models\Film;


class ReviewController extends Controller
{
    //
    public function index ()
    {
        $reviews = App\Models\Review::all();
      //  return view('Reviews', compact('reviews'));
    }

//devuel las ultimas 10 reviews hechas en la pagina.
    public function lastReviews(){
      $reviews = Review::join('users','review.user_id','=','users.id')
                     ->join('film','review.film_id','=','film.id')
                     ->select('review.id as review_id','review.titulo as review_titulo',
                      'review.descripcion as review_descripcion','users.username as username',
                      'film.id  as film_id', 'film.titulo as film_titulo', 'film.fecha_estreno as film_fecha_estreno')
                     ->take(10)
                     ->orderBy('review.created_at','desc')
                     ->get();
      return response()->json($reviews);
    }


    public function addReview(){
        $obj = json_decode($_POST["objeto"]);
        $film = Film::find($obj->film_id);
        if (Auth()->user()==null){ //si no esta logeado -> no inserto nada en Review
          $obj->estado = "FAILED";
          $obj->tipoError = "sesion_usuario";
          $obj->mensaje = "Debes iniciar sesion.";
        }else{ // si esta logeado
          if ( (empty($obj->titulo)) || (empty($obj->descripcion)) ){//si esta vacia la review
            $obj->estado = "FAILED";
            $obj->tipoError = "review_vacia";
            $obj->mensaje = "No se permite campos vacios";
          }else{
                $newReview = new Review();
                $newReview->user_id = Auth()->user()->id;
                $newReview->film_id = $film->id;
                $newReview->titulo = $obj->titulo;
                $newReview->descripcion = $obj->descripcion;
                $newReview->save();

                //cargo algunos datos que serviran para la vista, a partir de la review recien creada.
                $obj->review_id = $newReview->id;
                $obj->username =   Auth()->user()->username;
                $obj->created_at =date("d/m/Y", strtotime($newReview->created_at));
                $obj->positivos =$newReview->positivos;
                $obj->negativos =$newReview->negativos;
                //seteo estado y mensaje que vera el usuario.
                $obj->estado = "OK";
                $obj->mensaje = "Se añadio tu review!";
          }
        }
        return response()->json($obj);
    }


    public function addScoreReview(){
      $obj = json_decode($_POST["objeto"]);
      $review = Review::find($obj->review_id);
      if (Auth()->user()==null){ //si no esta logeado -> no inserto nada en Review
        $obj->estado = "FAILED";
        $obj->mensaje = " Debes iniciar sesion. ";
      }else{ // si esta logeado
          $score_review = Score_Review::where('review_id',$obj->review_id)
                                      ->where('user_id',Auth()->user()->id)
                                      ->first();
          $newScore_review = new Score_Review();
          $newScore_review->user_id = Auth()->user()->id;
          $newScore_review->review_id = $obj->review_id;
          $newScore_review->voto = $obj->voto;

          if ($score_review==null) {
            $newScore_review->save();
            $obj->estado = "OK";
            $obj->mensaje = " Puntaje añadido! ";
          }else{
            $score_review->voto = $obj->voto;
            $score_review->save();
            $obj->estado = "OK";
            $obj->mensaje = " Puntaje actualizado! ";
          }
      }
        echo json_encode($obj);
  }

  /**
  * Busca peliculas o series a medida que el cliente las vaya pidiendo
  * En este caso, al ir haciendo scroll sobre el final de la pagina.
  * @var film  {PELICULA / SERIE}
  * @var offset     Comienza desde X registro
  * @var q       Cantidad de tuplas que retorna.
  */
  public function searchOnDemand($film, $offset, $q) {
    $films = Review::where('film_id',$film)
                 ->join('users','review.user_id','=','users.id')
                 ->select('review.*','review.id as review_id','users.username')
                 ->skip($offset)
                 ->take($q)
                 ->get();

    return response()->json($films);

  }


    //No se usa por ahora, habria que copiar el codigo y enviarlo al trigger. (review.boot())
    public function store(Request $request)
    {
        // Validate the request...
        $validator = Validator::make($request, [
            'titulo' => 'required|max:50',
            'descripcion' => 'required|max:2000',
            'user_id' => 'exists:user,id',
            'obra_id' => 'exists:obra,id'
        ]);

        if ($validator->fails()) {
            return redirect('post/create')
                        ->withErrors($validator)
                        ->withInput();
        }
        $review = new Review;
        $review->titulo = $request->titulo;
        $review->descripcion = $request->titulo;
        $review->user = App\Models\User::find($request->user_id);
        $review->obra = App\Models\Obra::find($request->obra_id);
        $review->save();
    }

}
