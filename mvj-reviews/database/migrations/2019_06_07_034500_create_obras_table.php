<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateObrasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('obra', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string('titulo');
            $table->date('fecha_estreno');
            $table->string('sinopsis',300);
            $table->bigInteger('anio');
            $table->string('pais',30)->nullable();
            $table->datetime('duracion');
            $table->string('categoria');//pelicula / serie / corto / etc
            $table->date('fecha_finalizacion')->nullable();
            $table->double('puntaje');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('obra');
    }
}
