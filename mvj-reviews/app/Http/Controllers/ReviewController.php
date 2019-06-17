<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\User;


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
        $obj->estado = "OK";
        $obj->mensaje = "Se agrego tu review!";

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
