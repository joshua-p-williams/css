<?php

$factory->define(App\Event::class, function (Faker\Generator $faker) {
    return [
        "name" => $faker->name,
        "use_in_tb_1" => $faker->boolean,
        "use_in_tb_2" => $faker->boolean,
        "use_in_tb_3" => $faker->boolean,
        "use_in_tb_4" => $faker->boolean,
    ];
});
