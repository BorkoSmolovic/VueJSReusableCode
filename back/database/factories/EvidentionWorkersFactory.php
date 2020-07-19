<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\EvidentionWorker;
use Faker\Generator as Faker;

$factory->define(EvidentionWorker::class, function (Faker $faker) {
    return [
        'evidention_id' => rand(1, 400),
        'worker_id' => rand(1, 5),
        'worker_type_id' => rand(1, 4),
        'salary' => rand(1,4),
        'user_id' => 1
    ];
});
