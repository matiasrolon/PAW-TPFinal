
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
        Schema::create('puntuacion__obra', function (Blueprint $table) {
          $table->bigInteger('obra_id')->unsigned();
          $table->bigInteger('user_id')->unsigned();
          $table->primary(['obra_id','user_id']);
          $table->tinyInteger('puntaje'); // 1 a 10
          $table->timestamps(); //Fecha de alta y actualizacion

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
        Schema::dropIfExists('puntuacion__obra');
    }
}
