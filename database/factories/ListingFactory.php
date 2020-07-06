<?php

/** @var Factory $factory */

use App\Listing;
use App\User;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Listing::class, function (Faker $faker) {
    return [
        'user_id' => factory(User::class),
        'title' => $faker->sentence(1),
        'description' => $faker->sentence,
        'currency' => $faker->sentence(1)
    ];
});
