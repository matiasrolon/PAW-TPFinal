
<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScoreFilmTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('score_film', function (Blueprint $table) {
          $table->bigIncrements('id');
          $table->bigInteger('film_id')->unsigned();
          $table->bigInteger('user_id')->unsigned();
          //$table->primary(['film_id','user_id']);
          $table->tinyInteger('puntaje'); // 1 a 10
          $table->timestamps(); //Fecha de alta y actualizacion

          //foreign keys
          $table->foreign('user_id')->references('id')->on('users');
          $table->foreign('film_id')->references('id')->on('film');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('score_film');
    }
}
