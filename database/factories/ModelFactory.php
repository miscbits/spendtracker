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

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'is_admin' => 0,
        'remember_token' => str_random(10),
    ];
});

$factory->define(\App\Purchase::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'cost' => $faker->numberBetween(10,2000),
    ];
});

$factory->define(\App\Item::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
    ];
});

$factory->define(\App\Type::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
    ];
});
