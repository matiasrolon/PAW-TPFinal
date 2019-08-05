
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
            $table->bigInteger('positivos');
            $table->bigInteger('negativos');
            $table->bigInteger('puntaje_total');
            $table->timestamps(); // Created_at: fecha de alta | updated_at: ult. modificacion
            $table->BigInteger('user_id')->unsigned();
            $table->BigInteger('film_id')->unsigned();

            //foreign keys
            // Si se borra el film o el usuario que hizo la review, la review tambien se borra.
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('film_id')->references('id')->on('film')->onDelete('cascade');

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
