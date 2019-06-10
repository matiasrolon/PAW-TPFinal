
<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('review', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('titulo', 50);
            $table->string('descripcion', 2000);
            $table->timestamps(); // Fecha de alta y actualizacion
            $table->BigInteger('user_id')->unsigned();
            $table->BigInteger('film_id')->unsigned();

            //foreign keys
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('film_id')->references('id')->on('film');

            //Otra forma de declarar foreignkey
            /*
            $table->BigInteger('user_id')->unsigned;

            $table->foreign('type_id')
                        ->references('id')
                        ->on('message_types')
                        ->onDelete('cascade');
            */
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('review');
    }
}
