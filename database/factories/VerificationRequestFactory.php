<?php

use App\Models\User;
use Faker\Generator as Faker;

/* @var $factory \Illuminate\Database\Eloquent\Factory */
$factory->define(App\Models\VerificationRequest::class, function (Faker $faker) {
    return [
        'company_id' => factory(User::class)->state('company'),
        'message' => $faker->paragraph,
        'attachment' => $faker->imageUrl(),
    ];
});
