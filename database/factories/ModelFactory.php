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
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'email_address' => $faker->safeEmail,
    ];
});

$factory->define(App\Models\TransactionType::class, function (Faker\Generator $faker) {
    return [
        'description' => $faker->name,
        'is_positive' => 1,
    ];
});

$factory->define(App\Models\Invoice::class, function (Faker\Generator $faker) {
    return [
        'client_id' => 1,
        'billed_via_id' => 1,
    ];
});

