<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAwardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('award', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string('nombre',100);
            $table->string('descripcion',500);
            $table->date('fecha_realizacion');
            $table->string('pais');
            //$table->binary('portada')->nullable();
            $table->string('autor',100);
            $table->string('fuente',100);
        });
      //ya que eloquent solo tiene binary, que lo mapea con un BLOB comun. (Menos tamaño)
       DB::statement("ALTER TABLE award ADD portada MEDIUMBLOB");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('award');
    }
}
