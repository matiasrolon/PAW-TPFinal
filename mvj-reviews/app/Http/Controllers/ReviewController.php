<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
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


    public function addReview(){
        $obj = json_decode($_POST["objeto"]);
        $user = User::find($obj->user_id);
        $film = Film::find($obj->film_id);
        if ($user==null){ //si no esta logeado -> no inserto nada en Review
          $obj->estado = "FAILED";
          $obj->mensaje = "Debes iniciar sesion primero.";
        }else{ // si esta logeado
          $newReview = new Review();
          $newReview->user_id = $user->id;
          $newReview->film_id = $film->id;
          $newReview->titulo = $obj->titulo;
          $newReview->descripcion = $obj->descripcion;
          $newReview->save();

          //recupero la misma review con los datos adicionales que se insertan en los triggers.
          $reviewRec = Review::where('user_id',$newReview->user_id)
                              ->where('film_id',$newReview->film_id)
                              ->orderBy('created_at','desc')
                              ->first();
          $obj->username =  $user->username;                   
          $obj->created_at =$reviewRec->created_at;
          $obj->positivos =$reviewRec->positivos;
          $obj->negativos =$reviewRec->negativos;
          $obj->estado = "OK";
          $obj->mensaje = "Se añadio tu review!";
        }
        echo json_encode($obj);
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
