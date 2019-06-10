<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Film extends Model
{
    //
    protected $table = 'film';

    public function tags(){
      return $this->belongsToMany('App\Models\Tag', 'tag_film', 'tag_id', 'film_id');
    }

    public function genres(){
      return $this->belongsToMany('App\Models\Genre', 'genre_film', 'genre_id', 'film_id');
    }

    public function artistsFunction(){
      return $this->hasMany('App\Models\Film_Artist', 'film_id', 'id');
    }
}
