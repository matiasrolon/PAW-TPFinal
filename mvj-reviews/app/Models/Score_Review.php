<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Review;
use App\Models\User;

class Score_Review extends Model
{
    //
    protected $table = 'score_review';
    protected $fillable = ['user_id','review_id','voto'];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function review()
    {
        return $this->belongsTo('App\Models\Review');
    }

   public static function boot()
    {
       parent::boot();

       self::created(function ($score_review) { //actualizo puntaje de usuario y votos de Review
              $review = Review::find($score_review->review_id);
              $user = User::find($score_review->user_id);
              if ($score_review->voto){ // true = like.
                $review->increment('positivos');
                $user->increment('puntos');
              }else{
                $review->decrement('negativos');
                $user->decrement('puntos');
              }
              $review->save();
              $user->save();//update de usuario.
           }
        );

   }

}
