<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Tiket;
use Faker\Generator as Faker;

$factory->define(Tiket::class, function (Faker $faker) {
    return [
        'price' => rand(100,250),
        'client_id' => $faker->numberBetween($min = 1, $max = 10),
    ];
});
