<?php

// listens for any DB queries and dumps them + the bindings
// DB::listen(function($query) {
//     var_dump($query->sql, $query->bindings);
// });

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// route for welcome page
Route::get('/', function () {
    return view('welcome');
});

// route apply the auth middleware to this group (route grouping)
// alternativle can add the auth middleware in the controller
// so if a user is not logged in and tries to access the /tweets endpoint, they will be re0directed to the login page
Route::middleware('auth')->group(function() {
    // display the tweets (timeline)
    // techincally the "home page" so add the name('home')
    // when the user logs in (via the LoginController), laravel will re-direct to the HOME = '/tweets'
    // ->name('home') => allows you to use the route name 'home' (can be referenced as 'home')
    Route::get('/tweets', 'TweetController@index')->name('home');
    // save a new tweet to the DB
    Route::post('/tweets', 'TweetController@store');
});

// route to view a profile of a particular user
// ->name('profile') => allows you to use the route name 'profile' (can be referenced as 'profile')
// in the view, can route to this endpoint via: 
// href={{ route('profile', $tweet->user->name) }}
Route::get('/profiles/{user}', 'ProfilesController@show')->name('profile');

// authroization routes
Auth::routes();

// ->name('home') => allows you to use the route name 'home' (can be referenced as 'home')
// Route::get('/home', 'HomeController@index')->name('home');
