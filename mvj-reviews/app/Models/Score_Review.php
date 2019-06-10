<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Score_Review extends Model
{
    //
    protected $table = 'score_review';

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function review()
    {
        return $this->belongsTo('App\Models\Review');
    }
}
