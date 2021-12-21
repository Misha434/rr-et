<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Script;
use Faker\Generator as Faker;
use Illuminate\Support\Carbon;

$factory->define(Script::class, function (Faker $faker) {
    return [
        'content' => $faker->realText(90),
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
    ];
});
