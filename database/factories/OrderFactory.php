<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Order::class, function (Faker $faker) {
    return [
        'notes' => $faker->text
    ];
});
