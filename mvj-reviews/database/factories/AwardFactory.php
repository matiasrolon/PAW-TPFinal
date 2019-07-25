<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Award;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(Award::class, function (Faker $faker) {
    return [
        'nombre'=> $faker->sentence(3),
        'descripcion'=> $faker->sentence(10),
        //'fecha_realizacion'=> $faker->date($format = 'Y-m-d', $max = '+2 years'),
        'fecha_realizacion'=> $faker->dateTimeBetween('-2 years', '+2 years'),
        'pais'=>$faker->country,
        'portada'=> file_get_contents('https://image.freepik.com/vector-gratis/diseno-ilustracion-vector-icono-trofeo-premio-cine_24877-18680.jpg'),
        'fuente'=>$faker->domainName,
        'autor'=> User::all()->random()->username,
    ];
});
