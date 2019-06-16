<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    //
    protected $table = 'review';
    protected $fillable = ['film_id','user_id','titulo','descripcion','positivos','negativos','puntaje_total'];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function film()
    {
        return $this->belongsTo('App\Models\Film');
    }

    public static function boot()
   {
       parent::boot();

       self::creating(function ($review) { //antes de guardarlo inserto sus puntos iniciales
            // $review->created_at = date("Y-m-d H:i:s"); //probando funcion date.
             $review->positivos = 0;
              $review->negativos= 0;
              $review->puntaje_total= 0;
           }
        );

   }

}
