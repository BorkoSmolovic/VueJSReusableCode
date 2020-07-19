<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Evidention;
use Faker\Generator as Faker;

$factory->define(Evidention::class, function (Faker $faker) {
    $partner_id = rand(1, 658);
    return [
        'event_name' => substr($faker->text, 0, 50),
        'date' => $faker->date(),
        'city_id' => rand(1, 30),
        'description' => substr($faker->text, 0, 20),
        'contract_id' => rand(1, 9),
        'is_commercial' => rand(0, 1),
        'user_id' => rand(4, 8)
    ];
});
