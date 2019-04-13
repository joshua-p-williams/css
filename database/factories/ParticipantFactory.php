<?php

$factory->define(App\Participant::class, function (Faker\Generator $faker) {
    return [
        "team_id" => factory('App\ParticipantTeam')->create(),
        "category_id" => factory('App\Category')->create(),
        "name" => $faker->name,
        "phone" => $faker->name,
        "email" => $faker->name,
        "address" => $faker->name,
    ];
});
