<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Range extends Model
{
    //
    protected $fillable = [
        'nombre', 'descripcion','puntaje_desde','puntaje_hasta',
    ];
    protected $table = 'range';
}
