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
use App\User;
use CodeUp\ReadIt\Links\LinkInformation;
use CodeUp\ReadIt\Links\Vote;
use CodeUp\ReadIt\Links\VoteInformation;

$factory->define(User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});

$factory->define(LinkInformation::class, function (Faker\Generator $faker) {
    $user = factory(User::class)->create();
    return [
        'title' => $faker->sentence(8),
        'url' => $faker->url,
        'votes' => $faker->numberBetween(1, 1800),
        'readitor_id' => $user->id,
        'name' => $user->name,
        'posted_at' => DateTime::createFromFormat('Y-m-d H:i:s', '2015-11-27 13:20:02')->getTimestamp()
    ];
});

$factory->define(VoteInformation::class, function () {
    /** @var LinkInformation $link */
    $link = factory(LinkInformation::class)->make();
    $link = (new \App\Repositories\LinksRepository())->add($link);
    return [
        'link_id' => $link->id(),
        'readitor_id' => $link->readitor()->id(),
    ];
});

$factory->defineAs(VoteInformation::class, 'upvote', function() use ($factory) {
    $vote = $factory->raw(VoteInformation::class);
    return array_merge($vote, ['type' => Vote::POSITIVE]);
});

$factory->defineAs(VoteInformation::class, 'downvote', function() use ($factory) {
    $vote = $factory->raw(VoteInformation::class);
    return array_merge($vote, ['type' => Vote::NEGATIVE]);
});
