<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Model;
use Faker\Generator as Faker;
use App\Models\User;
use App\Models\PendentSearch;

$factory->define(PendentSearch::class, function (Faker $faker) {
    return [
      'busqueda' => $faker->sentence(3,false),
      'estado'=> 'resuelta',
    ];
});
