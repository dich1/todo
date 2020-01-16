<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Commit;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(Commit::class, function (Faker $faker) {
    return [
        'user_id' => 3,
        'limit' => $faker->date($format = '2019-12-01'),
        'status' => false,
    ];
});
