<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(App\Partner::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->name(),
        'address' => $faker->unique()->streetAddress,
        'phone' => $faker->phoneNumber,
        'city_id' => rand(1, 9),
        'address' => $faker->streetAddress,
        'pib' => $faker->ean8,
        'pdv' => $faker->ean8,
        'partner_type_id' => rand(1, 2),
        'tax_area_id' => rand(1, 6),
        'user_id' => 1,
    ];
});
