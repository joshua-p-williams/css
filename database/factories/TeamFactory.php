<?php

$factory->define(App\Team::class, function (Faker\Generator $faker) {
    return [
        "name" => $faker->name,
        "category_id" => factory('App\Category')->create(),
        "primary_contact_name" => $faker->name,
        "primary_contact_phone" => $faker->name,
        "primary_contact_email" => $faker->safeEmail,
        "state" => $faker->name,
        "county" => $faker->name,
    ];
});
