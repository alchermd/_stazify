<?php

use Faker\Generator as Faker;
use Illuminate\Support\Carbon;

/* @var $factory \Illuminate\Database\Eloquent\Factory */
$factory->define(App\Models\Jobpost::class, function (Faker $faker) {
    $qualifications = [
        $faker->sentence,
        $faker->sentence,
        $faker->sentence,
    ];

    return [
        'user_id' => function () {
            return factory(\App\Models\User::class)->state('company')->create()->id;
        },
        'title' => $faker->sentence,
        'description' => $faker->paragraphs(3, true),
        'qualifications' => json_encode($qualifications),
        'deadline' => Carbon::now()->addMonth($faker->randomDigit(1, 12)),
    ];
});
