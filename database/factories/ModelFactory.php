<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\User::class, function ($faker) {
    return [
        'name' => $faker->name,
        'surname' => $faker->lastName,
        'email' => $faker->email,
        'password' => str_random(10),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Game::class, function ($faker) {
    return [
        'title' => $faker->unique()->colorName
    ];
});

$factory->define(App\Score::class, function ($faker) {
    return [
        'user_id' => $faker->numberBetween($min = 1, $max = 50),
        'game_id' => $faker->numberBetween($min = 1, $max = 3),
        'score' => $faker->numberBetween($min = 0, $max = 1000)
    ];
});