<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReviewController extends Controller
{
    //
    public function index ()
    {
        $reviews = App\Models\Review::all();
        return view('Review.index', compact('reviews'));
    }

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

        $review = new Review;
        $review->titulo = $request->titulo;
        $review->descripcion = $request->titulo;
        $review->user = App\Models\User::find($request->user_id);
        $review->obra = App\Models\Obra::find($request->obra_id);
        $review->save();
    }

}
