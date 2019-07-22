<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Newness extends Model
{
    //
    protected $table = 'newness';
      protected $fillable = ['autor','categoria','cuerpo','copete','imagen','epigrafe','titulo','fecha'];
}
