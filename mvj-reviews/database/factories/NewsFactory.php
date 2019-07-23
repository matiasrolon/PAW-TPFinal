<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Model;
use App\Models\News;
use Faker\Generator as Faker;

$factory->define(News::class, function (Faker $faker) {
    return [
         'autor'=> $faker->name,
         'fecha'=> $faker->date($format = 'Y-m-d', $max = 'now'),
         'titulo'=> $faker->sentence(6),
         'copete'=> $faker->sentence(20),
         'cuerpo' => $faker->sentence(100),
         'portada'=> file_get_contents('https://image.flaticon.com/icons/png/512/14/14711.png'),
         'fuente'=> $faker->url
    ];
});
