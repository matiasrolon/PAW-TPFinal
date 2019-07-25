<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Award extends Model
{
  protected $table = 'Award';

  protected $fillable = ['nombre','descripcion','fecha_realizacion','pais','fuente','portada','autor'];

  public function categories(){
       return $this->hasMany('App\Models\Category');
   }
}
