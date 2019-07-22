<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewnessTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('newness', function (Blueprint $table) {
            $table->bigIncrements('id');
            $categorias = array('noticia', 'estreno', 'premio');
            $table->enum('categoria', $categorias);
            $table->string('autor', 100);
            $table->date('fecha'); // Fecha para mostrar (antes timestamp)
            $table->string('titulo', 100);
            $table->string('copete', 500);
            $table->text('cuerpo', 5000); // Descripcion. TEXT se supone que no sera comparado en un query
            $table->binary('imagen')->nullable(); // BLOB
            $table->string('epigrafe', 200)->nullable();
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
        Schema::dropIfExists('newness');
    }
}
