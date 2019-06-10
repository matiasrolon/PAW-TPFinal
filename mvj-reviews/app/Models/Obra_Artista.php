<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Obra_Artista extends Model
{
    //
    protected $table = 'obra_artista';

    public function obra()
    {
        return $this->belongsTo('App\Models\Obra');
    }

    public function artista()
    {
        return $this->belongsTo('App\Models\Artista');
    }

    public function rol()
    {
        return $this->belongsTo('App\Models\Rol');
    }
}
