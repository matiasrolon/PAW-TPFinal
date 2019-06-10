<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGenreFilmTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('genre__film', function (Blueprint $table) {
            $table->bigInteger('genre_id')->unsigned();
            $table->bigInteger('film_id')->unsigned();
            $table->primary(['genre_id', 'film_id']);

            // Foreign Keys
            $table->foreign('genre_id')->references('id')->on('genre');
            $table->foreign('film_id')->references('id')->on('film');

            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('genero__obra');
    }
}
