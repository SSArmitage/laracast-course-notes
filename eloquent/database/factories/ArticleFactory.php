<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Article;
use Faker\Generator as Faker;

// by default adds the parent Model::class, need to change to the specific model you want to create the factory for
$factory->define(Article::class, function (Faker $faker) {
    // whats the basic blueprint for an article goes here
    return [
        // need a user who created this article => build out a user to grab their user_id
        // reference a diff factory => calls the User factory
        // returns the primary key and sets it here (how does it know to return the primary key???)
        'user_id' => factory(\App\User::class),
        'title' => $faker->sentence,
        'excerpt' => $faker->sentence,
        'body' => $faker->paragraph
    ];
});
