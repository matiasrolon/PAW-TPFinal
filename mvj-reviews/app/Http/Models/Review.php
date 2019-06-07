<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    //
    protected $table = 'review';

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function obra()
    {
        return $this->belongsTo('App\Models\Obra');
    }

    public function votos()
    {
        $voto = DB::table('puntuacion_review')
                  ->select(DB::raw('sum(voto) as votos'))
                  ->where('review_id', $this->id)
                  ->get();
    }



}
