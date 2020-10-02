<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

// Faker library generates random fake data (You do not need to install this package if you are using laravel 5 or higher)
// Model Factory lets us define a pattern used in generating fake data
// Laravel provides a $factory global object which we can extend to define our factories
// the define() method being called on the $factory object takes in two parameters. The first one is an identifier (model FQN), used to later reference the factory. The second parameter is a closure which takes in Faker\Generator class and returns an array of users.
$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),
    ];
});
