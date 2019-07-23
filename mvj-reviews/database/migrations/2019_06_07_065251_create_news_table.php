<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->binary('portada')->nullable(); // BLOB, por ahora nullable, puede ser propia o externa
            $table->string('autor', 100);
            $table->date('fecha'); // Fecha para mostrar
            $table->string('titulo', 100);
            $table->string('copete', 500);
            $table->text('cuerpo', 5000); // Descripcion. TEXT se supone que no sera comparado en un query
            $table->string('fuente')->nullable();
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
        Schema::dropIfExists('news');
    }
}
