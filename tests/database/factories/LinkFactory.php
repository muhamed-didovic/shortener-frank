<?php

use MuhamedDidovic\Shortener\Link;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(Link::class, function (Faker $faker) {
    return [
        'original_url' => $faker->url
    ];
});
