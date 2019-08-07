<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
          $table->bigIncrements('id');
          $table->string('nombre');
          $table->string('username')->unique();
          $table->string('email')->unique();
          $table->timestamp('email_verified_at')->nullable();
          $table->string('password');
          $table->string('estado');
          $table->date('fecha_nacim')->nullable();
          $table->string('biografia', 500)->nullable();
          $table->string('genero_fav', 50)->nullable();
          $table->string('pelicula_fav', 50)->nullable();
          $table->string('serie_fav', 50)->nullable();
          //$table->binary('avatar')->nullable(); // BLOB=
          $table->integer('puntos'); // calculado por triggers
          $table->bigInteger('range_id')->unsigned();
          $table->rememberToken();
          $table->timestamps();
          //foreign keys
          $table->foreign('range_id')->references('id')->on('range');
        });

        DB::statement("ALTER TABLE users ADD avatar MEDIUMBLOB");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
