<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilmArtistTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('film__artist', function (Blueprint $table) {
            $table->bigInteger('film_id')->unsigned();
            $table->bigInteger('artist_id')->unsigned();
            $table->bigInteger('function_id')->unsigned();
            $table->primary(['film_id', 'artist_id', 'function_id']);

            // Foreign Keys
            $table->foreign('film_id')->references('id')->on('film');
            $table->foreign('artist_id')->references('id')->on('artist');
            $table->foreign('function_id')->references('id')->on('function');

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
        Schema::dropIfExists('obra__artista');
    }
}
