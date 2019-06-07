<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Obra extends Model
{
    //
    protected $table = 'obra';

    public function tags(){
      return $this->belongsToMany('App\Models\Tag', 'tag_obra', 'tag_id', 'obra_id');
    }

    public function generos(){
      return $this->belongsToMany('App\Models\Genero', 'genero_obra', 'genero_id', 'obra_id');
    }

    public function artistasRol(){
      return $this->hasMany('App\Models\Obra_Artista', 'obra_id', 'id');
    }
}
