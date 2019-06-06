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
            // Tuve que agregar las longitudes de los strings para que no de error
            // Al ejecutar php artisan migrate
            $table->bigIncrements('id');
            $table->string('username', 100); //Antes era name
            $table->string('email', 100)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password', 32);
            $table->rememberToken(); //Creo que es para las sesiones. Segun la documentacion de Lrvl es VARCAHR(100)
            $table->timestamps(); //Agrega los campos de fecha de alta y fecha de actualizacion

            // Ademas agrego los cambios propuestos
            $table->string('nombre', 100);
            $table->date('fecha_nacim');
            $table->string('biografia', 500);
            $table->string('genero_fav', 50);
            $table->string('pelicula_fav', 50);
            $table->string('serie_fav', 50);
            $table->binary('avatar'); // BLOB
            // Calculado por triggers.
            $table->integer('puntos');
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
