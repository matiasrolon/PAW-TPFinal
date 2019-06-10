<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Puntuacion_Obra extends Model
{
    //
    protected $table = 'puntuacion_obra';

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function obra()
    {
        return $this->belongsTo('App\Models\Obra');
    }
}
