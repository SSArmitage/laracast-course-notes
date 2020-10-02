<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

// the Article model is used to communicate with the database
// how laravel makes the database connection to a particular table:
// /vendor/laravel/framework/src/Illuminate/Database/Eloquent/Model.php
// All Eloquent models extend Illuminate\Database\Eloquent\Model class
// Eloquent is an ORM library
// The Eloquent ORM (object-relational mapping) included with Laravel provides a beautiful, simple ActiveRecord implementation for working with your database. EACH DATABASE TABLE HAS A CORRESPONDING "MODEL" which is used to interact with that table. Models allow you to query for data in your tables, as well as insert new records into the table.
// ORM is a technique that lets you query and manipulate data from a database using an object-oriented paradigm. When talking about ORM, most people are referring to a library that implements the Object-Relational Mapping technique.
// An ORM library is a completely ordinary library written in your language of choice that encapsulates the code needed to manipulate the data, so you don't use SQL anymore; you interact directly with an object in the same language you're using.
// ORM abstracts the DB system => the mechanical SQL part is taken care of automatically via the ORM library.
// Make sure to configure a database connection in config/database.php.
class Article extends Model
{
    // *** protection against "mass assignment" vulnerabilities (2 ways) ***
    // specify (blacklist) which columns cannot be mass assigned using the $gaurded property
     // if you dont need laravel to protect, can have $guarded = [];
    // All columns are mass assignable
    // You can either choose $fillable or $guarded but not both
    protected $guarded = [];
    

    public function path() {
        // return a string that represents the path to a specific article
        // string = route name
        // route to show a single article = '/articles/{article}' => 
        // also = route('articles.show', $article)
        // $this represents the current article instance
        return route('articles.show', $this);
    }

    // this functions grabs the user of a specific article
    // eloquent is referring to the foreign key in the articles table as "user_id", so if you change "user" to "author", this wont work anymore
    public function user() {
        // this article belongs to this user (refernce the associated User model)
         // can set the foreign key here as the second argument
        return $this->belongsTo(User::class);
    }

    // an article has many TAGS
    // i.e. article = Learn Laravel, tags = php, laravel, work, education
    // but the tag does not belongTo the article - each tag can belong to many articles
    // Many to Many relationship
    // to make this relationship work, you need 3 different database tables! => 1. articles, 2. tags, 3. pivot table (an intermediate linking table, used to create the eloquent association)
    // fetch the tags for an article
    public function tags() {
        // this article belongs to many tags
        return $this->belongsToMany(Tag::class)->withTimestamps();
    }
}
