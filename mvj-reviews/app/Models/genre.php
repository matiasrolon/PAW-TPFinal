<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    //
    protected $table = 'genre';
    protected $fillable = ['nombre'];

    public function films(){
      return $this->belongsToMany('App\Models\Film', 'genre_film', 'genre_id', 'film_id');
    }
}
