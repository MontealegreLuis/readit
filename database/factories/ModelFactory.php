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

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});

$factory->define(\CodeUp\ReadIt\Links\LinkInformation::class, function (Faker\Generator $faker) {
    $user = factory(App\User::class)->create();
    return [
        'title' => $faker->sentence(8),
        'url' => $faker->url,
        'votes' => $faker->numberBetween(1, 1800),
        'readitor_id' => $user->id,
        'name' => $user->name,
    ];
});
