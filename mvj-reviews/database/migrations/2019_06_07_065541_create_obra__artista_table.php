<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateObraArtistaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('obra__artista', function (Blueprint $table) {
            $table->bigInteger('obra_id')->unsigned();
            $table->bigInteger('artista_id')->unsigned();
            $table->bigInteger('rol_id')->unsigned();
            $table->primary(['obra_id', 'artista_id', 'rol_id']);

            // Foreign Keys
            $table->foreign('obra_id')->references('id')->on('obra');
            $table->foreign('artista_id')->references('id')->on('artista');
            $table->foreign('rol_id')->references('id')->on('rol');

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
