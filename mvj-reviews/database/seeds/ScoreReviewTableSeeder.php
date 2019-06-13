<?php

use Illuminate\Database\Seeder;
use App\Models\Review;
use App\Models\User;
use App\Models\Score_Review;

class ScoreReviewTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::find(2);
        $review = Review::find(1);
        $score_review = new Score_Review();
        $score_review->user_id = $user->id;
        $score_review->review_id = $review->id;
        $score_review->voto = true;
        $score_review->save();

        $user = User::find(2);
        $review = Review::find(5);
        $score_review = new Score_Review();
        $score_review->user_id = $user->id;
        $score_review->review_id = $review->id;
        $score_review->voto = false;
        $score_review->save();

        $user = User::find(6);
        $review = Review::find(3);
        $score_review = new Score_Review();
        $score_review->user_id = $user->id;
        $score_review->review_id = $review->id;
        $score_review->voto = true;
        $score_review->save();

        $user = User::find(5);
        $review = Review::find(2);
        $score_review = new Score_Review();
        $score_review->user_id = $user->id;
        $score_review->review_id = $review->id;
        $score_review->voto = true;
        $score_review->save();

        $user = User::find(2);
        $review = Review::find(3);
        $score_review = new Score_Review();
        $score_review->user_id = $user->id;
        $score_review->review_id = $review->id;
        $score_review->voto = true;
        $score_review->save();

        $user = User::find(4);
        $review = Review::find(3);
        $score_review = new Score_Review();
        $score_review->user_id = $user->id;
        $score_review->review_id = $review->id;
        $score_review->voto = false;
        $score_review->save();

        //review id=3 --> positivos 2 | negativos1
    }
}
