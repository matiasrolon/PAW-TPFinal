<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Film extends Model
{
    protected $table = 'film';
    protected $fillable = ['titulo','fecha_estreno','pais','sinopsis','duracion_min','categoria','fecha_finalizacion','puntaje'];

    public function tags(){
      return $this->belongsToMany('App\Models\Tag', 'tag_film', 'film_id', 'tag_id');
    }

    public function genres(){
      return $this->belongsToMany('App\Models\Genre', 'genre_film', 'film_id', 'genre_id');
    }

    public function artistsFunction(){
      return $this->hasMany('App\Models\Film_Artist', 'film_id', 'id');
    }
}
