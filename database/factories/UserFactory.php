<?php

use Faker\Generator as Faker;

/* @var $factory \Illuminate\Database\Eloquent\Factory */
$factory->define(App\Models\User::class, function (Faker $faker) {
    return [
        'email' => $faker->unique()->safeEmail,
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'remember_token' => str_random(10),
        'address' => 'Somewhereville, CA',
        'about' => 'All about me!',
        'contact_number' => '09123456789',
        'avatar_url' => "https://api.adorable.io/avatars/285/{$faker->word}@adorable.png",
        'email_verified_at' => \Carbon\Carbon::now()->toDateTimeString(),
        'wants_email_notifications' => true,
        'profile_views' => 0
    ];
});

$factory->state(\App\Models\User::class, 'student', function (Faker $faker) {
    return [
        'account_type' => 1,
        'first_name' => 'John',
        'last_name' => 'Doe',
        'age' => $faker->numberBetween(15, 25),
        'resume_url' => storage_path('test/files/resume.pdf'),
        'course_id' => 1,
        'school' => 'School of Hard Rock',
    ];
});

$factory->state(\App\Models\User::class, 'company', function () {
    return [
        'account_type' => 2,
        'company_name' => 'ACME Web Services',
        'website' => 'https://acme.io',
        'industry_id' => 1,
    ];
});
