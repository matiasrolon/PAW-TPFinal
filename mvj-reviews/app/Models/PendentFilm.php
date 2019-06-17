<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PendentFilm extends Model
{
        protected $table = 'pendentFilm';
        protected $fillable = ['busqueda','user_id'];
}
