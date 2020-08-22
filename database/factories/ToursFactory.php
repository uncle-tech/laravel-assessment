<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
namespace Tests\Feature;
use App\User;
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

$factory->define(App\Tours::class, function (Faker $faker) {
    return [
        'start' => $faker->date($format = 'Y-m-d H:i:s', $max = 'now'),
        'end' => $faker->date($format = 'Y-m-d H:i:s', $max = 'now'),
        'price' => numberBetween($min = 0, $max = 1000000)
    ];
});
