<?php

use App\Models\Jobpost;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(App\Models\Application::class, function (Faker $faker) {
    return [
        'user_id' => function () {
            return factory(User::class)->state('student')->create()->id;
        },
        'jobpost_id' => function () {
            return factory(Jobpost::class)->create()->id;
        },
        'accepted' => false,
    ];
});
