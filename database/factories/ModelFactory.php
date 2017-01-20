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

$factory->define(App\Models\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->safeEmail,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Models\BilledVia::class, function (Faker\Generator $faker) {
    return [
        'billed_via' => $faker->name
    ];
});

$factory->define(App\Models\Client::class, function (Faker\Generator $faker) {
    return [
        'last_name' => $faker->name,
        'email_address' => $faker->safeEmail,
    ];
});

