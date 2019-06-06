<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

// Esta linea la agregue junto con la modificacion en el metodo boot()
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Esta es la longitud default que le da a los strings si uno no se la define.
        Schema::defaultStringLength(191);
    }
}
