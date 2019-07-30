<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
  protected $table = 'Category';

  protected $fillable = ['nombre','descripcion','award_id'];

  public function nominees(){
       return $this->hasMany('App\Models\Nominee');
   }
}
