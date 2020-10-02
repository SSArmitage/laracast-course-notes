<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Tweet;
use Faker\Generator as Faker;

$factory->define(Tweet::class, function (Faker $faker) {
    return [
        // need a user who created this tweet => build out a user to grab their user_id
        // reference a diff factory => calls the User factory
        // returns the primary key and sets it here
        'user_id' => factory(App\User::class),
        'body' => $faker->sentence()
    ];
});
