<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Film_Artist extends Model
{
    //
    protected $table = 'film_artist';

    public function film()
    {
        return $this->belongsTo('App\Models\Film');
    }

    public function artist()
    {
        return $this->belongsTo('App\Models\Artist');
    }

    public function function()
    {
        return $this->belongsTo('App\Models\Function');
    }
}
