<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Message::class, function (Faker $faker) {
    return [
        'sender_id' => function () use ($faker) {
            $userState = $faker->randomElement(['student', 'company']);

            return factory(\App\Models\User::class)->state($userState)->create()->id;
        },
        'recipient_id' => function () use ($faker) {
            $userState = $faker->randomElement(['student', 'company']);

            return factory(\App\Models\User::class)->state($userState)->create()->id;
        },
        'subject' => $faker->sentence,
        'body' => $faker->paragraph,
        'read_at' => null,
    ];
});
