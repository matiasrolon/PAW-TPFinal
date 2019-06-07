<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePuntuacionObrasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('puntuacion__obras', function (Blueprint $table) {
          $table->timestamps();
          $table->date('fecha');
          $table->integer('puntaje');
          $table->bigInteger('obra_id')->unsigned();
          $table->bigInteger('user_id')->unsigned();
          $table->primary(['obra_id','user_id']);
          //foreign keys
          $table->foreign('user_id')->references('id')->on('user');
          $table->foreign('obra_id')->references('id')->on('obra');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('puntuacion__obras');
    }
}
