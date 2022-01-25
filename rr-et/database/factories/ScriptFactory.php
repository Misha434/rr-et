<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Script;
use Faker\Generator as Faker;
use Illuminate\Support\Carbon;

$factory->define(Script::class, function (Faker $faker) {
    return [
        'content' => $faker->realText(90),
        'user_id' => rand(1, 21),
        'category_id' => rand(1, 4),
        'created_at' => $faker->dateTimeBetween($startDate = '-3 week', $endDate = 'now'),
        'updated_at' => Carbon::now(),
    ];
});
