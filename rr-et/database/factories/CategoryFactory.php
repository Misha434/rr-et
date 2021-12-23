<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Category;
use Faker\Generator as Faker;
use Illuminate\Support\Carbon;

$factory->define(Category::class, function (Faker $faker) {
    return [
        'name' => $faker->countryCode(),
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
    ];
});
