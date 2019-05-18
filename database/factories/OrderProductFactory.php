<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\OrderProduct::class, function (Faker $faker) {
    return [
        'price' => $faker->randomFloat(2, 0, 99999),
        'quantity' => $faker->randomNumber()
    ];
});
