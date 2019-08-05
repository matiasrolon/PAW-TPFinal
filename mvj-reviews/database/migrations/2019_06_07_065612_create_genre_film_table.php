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
        Schema::create('genre_film', function (Blueprint $table) {
            $table->bigInteger('genre_id')->unsigned();
            $table->bigInteger('film_id')->unsigned();
            $table->primary(['genre_id', 'film_id']);

            // Foreign Keys
            // Si se borra el film o el genero, se elimina la asociacion film-genero
            $table->foreign('genre_id')->references('id')->on('genre')->onDelete('cascade');
            $table->foreign('film_id')->references('id')->on('film')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('genre_film');
    }
}
