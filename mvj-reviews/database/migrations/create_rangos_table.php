<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRangosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rango', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string('nombre',50);
            $table->string('descripcion',100);
            $table->BigInteger('puntaje_desde');
            $table->BigInteger('puntaje_hasta');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rango');
    }
}
