<?php

$factory->define(App\Contact::class, function (Faker\Generator $faker) {
    return [
        "company_id" => factory('App\ContactCompany')->create(),
        "category_id" => factory('App\Category')->create(),
        "name" => $faker->name,
        "phone" => $faker->name,
        "email" => $faker->name,
        "address" => $faker->name,
    ];
});
