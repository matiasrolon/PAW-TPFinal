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
        Schema::create('tag__film', function (Blueprint $table) {
            $table->bigInteger('film_id')->unsigned();
            $table->string('tag_id', 100);
            $table->primary(['film_id', 'tag_id']);

            // Foregin Keys
            $table->foreign('film_id')->references('id')->on('film');
            $table->foreign('tag_id')->references('nombre')->on('tag');

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
        Schema::dropIfExists('tag__obra');
    }
}
