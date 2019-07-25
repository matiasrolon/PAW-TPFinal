<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nominee extends Model
{
  protected $table = 'Nominee';

  protected $fillable = ['nombre','descripcion','resultado','category_id'];

}
