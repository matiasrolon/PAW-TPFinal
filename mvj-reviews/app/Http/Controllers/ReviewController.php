<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReviewController extends Controller
{
    //

    public function total_votos()
    {
        $voto = DB::table('puntuacion_review')
                  ->select(DB::raw('sum(voto) as votos'))
                  ->where('review_id', $this->id)
                  ->get();
    }
}
