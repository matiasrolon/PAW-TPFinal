<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Model;
use App\Models\Review;
use App\Models\User;
use App\Models\Film;
use Faker\Generator as Faker;

$factory->define(Review::class, function (Faker $faker) {
    return [
        'titulo' => $faker->sentence(4,false),
        'descripcion' => $faker->sentence(50,false),
        'user_id' =>User::All()->random()->id,
        'film_id' =>Film::All()->random()->id
    ];
});
