<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Model;
use App\Models\Newness;
use Faker\Generator as Faker;

$factory->define(Newness::class, function (Faker $faker) {
    return [
         'categoria'=> $faker->randomElement(['noticia','estreno', 'premio']),
         'autor'=> $faker->name,
         'fecha'=> $faker->date($format = 'Y-m-d', $max = 'now'),
         'titulo'=> $faker->sentence(6),
         'copete'=> $faker->sentence(20),
         'cuerpo' => $faker->sentence(100),
         'imagen'=> file_get_contents('https://image.flaticon.com/icons/png/512/14/14711.png'),
         'epigrafe'=>$faker->sentence(10)
    ];
});
