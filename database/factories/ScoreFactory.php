<?php

$factory->define(App\Score::class, function (Faker\Generator $faker) {
    return [
        "event_id" => factory('App\Event')->create(),
        "team_id" => factory('App\Team')->create(),
        "participant_id" => factory('App\Participant')->create(),
        "score" => $faker->randomNumber(2),
    ];
});
