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
          $table->binary('avatar')->nullable(); // BLOB=
          $table->integer('puntos')->nullable(); // calculado por triggers
          $table->bigInteger('range_id')->unsigned()->nullable();
         //$table->bigInteger('role_id')->unsigned()->nullable();
          $table->rememberToken();
          $table->timestamps();
          //foreign keys
          $table->foreign('range_id')->references('id')->on('range');
          //$table->foreign('role_id')->references('id')->on('role');
        });
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
