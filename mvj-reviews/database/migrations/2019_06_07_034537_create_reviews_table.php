
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
            $table->timestamps();
            $table->string('titulo', 100);
            $table->string('Descripcion', 300);
            $table->date('fecha');
            $table->BigInteger('user_id')->unsigned();
            $table->BigInteger('obra_id')->unsigned();
            //foreign keys
            $table->foreign('user_id')->references('id')->on('user');
            $table->foreign('obra_id')->references('id')->on('obra');

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
