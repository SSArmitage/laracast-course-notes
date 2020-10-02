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
    // user makes a request to the homepage, in response we are loading a view (html portion of code base)
    return view('welcome');
});

Route::get('/welcome', function () {
    // user makes a request to the homepage, in response we are loading a view (html portion of code base)
    // return 'Helloooooo';

    // if you return a php, laravel wil automatically convert it to JSON
    // useful when building APIs
    return ['foo' => 'bar'];
});

Route::get('/test', function() {
    // fetch data using the request helper function request()
    // The request function returns the current request instance or obtains an input item (provide the key you are looking for)
    // $request = request('');
    $value = request('name');;
    // return $value;

    // pass data ($value) to the view as the second argument of this function
    return view('test', [
        'value' => $value
        ]);
});