<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Film;
use App\Models\Score_Film;

class Score_Film extends Model
{
    //
    protected $table = 'score_film';
    protected $fillable = ['film_id','user_id','puntaje'];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function film()
    {
        return $this->belongsTo('App\Models\Film');
    }

    /*DENTRO DE BOOTS IRIAN LOS TRIGGERS DE ESTA CLASE (VALE PARA TODAS):
    LARAVEL TRAE POR DEFECTO
      Creating  |  created
      updating  | updated
      deleting | deleted
      saving  | saved
    */
    public static function boot()
   {
       parent::boot();

       self::created(function ($score_film) {
              $qScores =  Score_Film::where('film_id',$score_film->film_id)->count();
              $totalScore =  Score_Film::where('film_id',$score_film->film_id)->sum('puntaje');

              $film = Film::find($score_film->film_id);
              $film->puntaje = $totalScore/$qScores;
              $film->save();
           }
        ); 

   }

}
