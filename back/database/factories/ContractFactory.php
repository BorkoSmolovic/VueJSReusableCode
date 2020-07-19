<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Contract;
use Faker\Generator as Faker;

$factory->define(Contract::class, function (Faker $faker) {
    $number_od_recordings = rand(5, 15);
    return [
        'dateFrom' => '2019-09-01',
        'dateTo' => '2019-12-31',
        'number_of_recordings' => $number_od_recordings,
        'recordings_remaining' => $number_od_recordings,
        'user_id' => 1
    ];
});
