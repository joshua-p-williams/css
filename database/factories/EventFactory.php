<?php

$factory->define(App\Event::class, function (Faker\Generator $faker) {
    return [
        "name" => $faker->name,
    ];
});
