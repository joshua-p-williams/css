<?php

$factory->define(App\Score::class, function (Faker\Generator $faker) {
    return [
        "event_id" => factory('App\Event')->create(),
        "company_id" => factory('App\ContactCompany')->create(),
        "contact_id" => factory('App\Contact')->create(),
        "score" => $faker->randomNumber(2),
    ];
});
