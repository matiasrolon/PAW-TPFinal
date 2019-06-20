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
    protected $primaryKey = 'id';

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

       self::updated(function ($score_review) {
           $votoAnt = $score_review->getOriginal('voto');
           $review = Review::find($score_review->review_id);
           $user = User::find($review->user_id);
           if (($score_review->voto)&&(!$votoAnt)){ // nuevo=like / viejo=dislike
             //corrige viejo
             $review->decrement('negativos');
             $user->increment('puntos');
             //aplica nuevo
             $review->increment('positivos');
             $user->increment('puntos');
           }else{
               if ((!$score_review->voto)&&($votoAnt)){ // nuevo=dislike / viejo=like
                 //corrige viejo
                 $review->decrement('positivos');
                 $user->decrement('puntos');
                 //aplica nuevo
                 $review->increment('negativos');
                 $user->decrement('puntos');
               }
           }
           $review->puntaje_total = ($review->positivos) - ($review->negativos);
           $review->save();//updated de review.
           $user->save();//update de usuario.
         }
      );

       self::created(function ($score_review) { //actualizo puntaje de usuario y votos de Review
              $review = Review::find($score_review->review_id);
              $user = User::find($review->user_id);
              if ($score_review->voto){ // true = like.
                $review->increment('positivos');
                $user->increment('puntos');
              }else{
                $review->increment('negativos');
                $user->decrement('puntos');
              }
              $review->puntaje_total = ($review->positivos) - ($review->negativos);

              $review->save();
              $user->save();//update de usuario.
           }
        );

   }

}
