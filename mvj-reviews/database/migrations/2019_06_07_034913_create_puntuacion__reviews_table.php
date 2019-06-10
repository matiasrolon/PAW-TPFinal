<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePuntuacionReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('puntuacion__review', function (Blueprint $table) {
            $table->bigInteger('review_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();
            $table->primary(['review_id','user_id']);
            $table->boolean('voto'); // True = Like. False = Dislike.
            $table->timestamps(); // Fecha de creacion y actualizacion

            //foreign keys
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('review_id')->references('id')->on('review');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('puntuacion__review');
    }
}
