<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGeneroObraTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('genero__obra', function (Blueprint $table) {
            $table->bigInteger('genero_id')->unsigned();
            $table->bigInteger('obra_id')->unsigned();
            $table->primary(['genero_id', 'obra_id']);

            // Foreign Keys
            $table->foreign('genero_id')->references('id')->on('genero');
            $table->foreign('obra_id')->references('id')->on('obra');

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
        Schema::dropIfExists('genero__obra');
    }
}
