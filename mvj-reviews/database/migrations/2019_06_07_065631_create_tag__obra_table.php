<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTagObraTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tag__obra', function (Blueprint $table) {
            $table->bigInteger('obra_id')->unsigned();
            $table->string('tag_id', 100);
            $table->primary(['obra_id', 'tag_id']);

            // Foregin Keys
            $table->foreign('obra_id')->references('id')->on('obra');
            $table->foreign('tag_id')->references('nombre')->on('tag');

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
        Schema::dropIfExists('tag__obra');
    }
}
