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
            $table->string('sinopsis',1000);
            $table->string('pais',30)->nullable();
            $table->double('duracion_min')->nullable();
            $table->string('categoria', 20);// Pelicula / serie / corto / etc
            $table->date('fecha_finalizacion')->nullable();
          //  $table->binary('poster')->nullable();
            $table->string('trailer',300)->nullable();
            $table->double('puntaje'); //Calculado con triggers
            $table->timestamps();
        });
       DB::statement("ALTER TABLE film ADD poster MEDIUMBLOB");
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
