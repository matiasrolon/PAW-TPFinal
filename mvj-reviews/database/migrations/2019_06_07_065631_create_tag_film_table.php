<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTagFilmTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tag_film', function (Blueprint $table) {
            $table->bigInteger('film_id')->unsigned();
            $table->string('tag_id', 100);
            $table->primary(['film_id', 'tag_id']);

            // Foregin Keys
            // Si se eliminar el film o el tag, se elimina la relacion entre ellos
            $table->foreign('film_id')->references('id')->on('film')->onDelete('cascade');
            $table->foreign('tag_id')->references('nombre')->on('tag')->onDelete('cascade');

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
        Schema::dropIfExists('tag_film');
    }
}
