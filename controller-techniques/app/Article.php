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
    // Need to overwrite a method called "getRouteKeyName"
    // return the name of the column you want to query by i.e. 'slug'
    // If you would like model binding to use a default database column other than id when retrieving a given model class, you may override the getRouteKeyName method on the Eloquent model
    // public function getRouteKeyName() {
    //     return 'slug';
    // }
    // now laravel would do a query like this: 
    // Article::where('slug', $article)->first();
    // where the slug is equal to the wildcard

    // *** protection against "mass assignment" vulnerabilities (2 ways) ***
    // 1. add property called $fillable and explicitly specify (whitelist) all the values that can be mass assigned via create()
    // Any input field other than these passed to create() method will throw MassAssignmentException
    protected $fillable = ['title', 'excerpt', 'body'];

    // 2. you can also specify (blacklist) which columns cannot be mass assigned using the $gaurded property
    // i.e. protected $guarded = ['is_admin'];
     // if you dont need laravel to protect, can have $guarded = [];
    // All columns other than is_admin will now be mass assignable
    // You can either choose $fillable or $guarded but not both

    // WHY THIS IS IMPORTANT:
    // there are certain things you should never allow the user to change, admin status, subscription status, account active or not, you should be in controll of these
    // but if you pass everything from the request , this is where a user could sneak in a malicous input
    // consider that we have an "is_admin" column on users table with true/false value
    // A malicious user can inject their own HTML
    // i.e.  <input type="hidden" name="is_admin" value="1" />
    // With Mass Assignment, "is_admin" will be assigned true and the user will have Admin rights on website, which you don't want!

    public function path() {
        // return a string that represents the path to a specific article
        // string = route name
        // route to show a single article = '/articles/{article}' => 
        // also = route('articles.show', $article)
        // $this represents the current article instance
        return route('articles.show', $this);
    }
}
