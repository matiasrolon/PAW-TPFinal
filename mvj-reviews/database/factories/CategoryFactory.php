<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Award;
use App\Models\Category;
use Faker\Generator as Faker;

$factory->define(Category::class, function (Faker $faker) {
    return [
      'nombre'=> $faker->sentence(3, false),
      'descripcion'=> $faker->sentence(10, false),
      'award_id'=> Award::all()->random()->id
    ];
});
