<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePasswordResetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('password_resets', function (Blueprint $table) {
            // Nuevamente tuve que agregar las longitudes de los strings para que no de error
            // Al ejecutar php artisan migrate
            $table->string('email', 100)->index();
            
            /* Si no lo toco, va a usar el que configure como default (191) en AppServiceProvider.php
            porque desconozco la longitud del token generado */
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('password_resets');
    }
}
