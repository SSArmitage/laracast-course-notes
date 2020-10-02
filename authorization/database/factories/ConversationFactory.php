<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Conversation;
use App\User;
use Faker\Generator as Faker;
// $faker = Faker\Factory::create();

// Faker is a PHP library that generates random fake data (You do not need to install this package if you are using laravel 5 or higher)
// Model Factory lets us define a pattern used in generating fake data
// Laravel provides a $factory global object which we can extend to define our factories
// the define() method being called on the $factory object takes in two parameters. The first one is an identifier (model FQN), used to later reference the factory. The second parameter is a closure which takes in Faker\Generator class and returns an array of users.
$factory->define(Conversation::class, function($user, Faker $faker) {
    return [
        'title' => $faker->words($nb = 3, $asText = false), 
        'body' => $faker->paragraph($nbSentences = 3, $variableNbSentences = true),
        'user_id' => function() {
            return factory(App\User::class)->create()->id;
        }
    ];
});
