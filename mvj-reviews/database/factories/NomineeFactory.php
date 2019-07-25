<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Nominee;
use App\Models\Category;
use App\Models\Film;
use Faker\Generator as Faker;

$factory->define(Nominee::class, function (Faker $faker) {
    return [
      'nombre'=> $faker->sentence(3, false),
      'descripcion'=> Film::All()->random()->titulo,
      'resultado'=>'nominado',
      'category_id'=>Category::All()->random()->id
    ];
});
