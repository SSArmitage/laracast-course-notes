<?php

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

Route::get('/', function () {
    return view('welcome');
});

// standard authentication routes
// in the terminal run "php artisan route:list" to see al the routes
Auth::routes();

// no reference to authentication here in the routes file
// only logged in users have access to the /home route
// if a user visits /home, load the HomeController, the constructor references a middleware called "auth" => this is what prevents users from visiting home when not logged in
// before the user can make it to the index method and the home view, they must first go through the middlewear layer (auth) => you must be signed in to make it to the next layer
// middleware is also commonly referenced in the routes file itself via chaining onto the main route i.e.
// Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');
Route::get('/home', 'HomeController@index')->name('home');


// CSRF attacks lesson
Route::get('/logout', function() {
    auth()->logout();
    return 'You are now logged out';
});