<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('film', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('titulo', 100);
            $table->date('fecha_estreno');
            $table->string('sinopsis',500);
            $table->string('pais',30)->nullable();
            $table->double('duracion_min'); // Duracion en minutos
            $table->string('categoria', 20);// Pelicula / serie / corto / etc
            $table->date('fecha_finalizacion')->nullable();
            $table->double('puntaje'); //Calculado con triggers
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
        Schema::dropIfExists('film');
    }
}
