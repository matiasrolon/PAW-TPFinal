<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PendentSearch extends Model
{
        protected $table = 'pendent_search';
        protected $fillable = ['busqueda','estado','cant_busquedas'];
        //cant_busquedas es para luego poder dar un orden de prioridades si asi se quiere.

        public static function boot()
       {
           parent::boot();

           self::creating(function ($pendent_search) {
                  $pendent_search->estado = 'pendiente';
                  $pendent_search->cant_busquedas = 1;
               }
            );

       }
}
