<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Score_Film extends Model
{
    //
    protected $table = 'score_film';

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function film()
    {
        return $this->belongsTo('App\Models\Film');
    }
}
