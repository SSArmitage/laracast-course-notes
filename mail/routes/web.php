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

// show contact page
Route::get('/contact', 'ContactController@show');
// submit email form
Route::post('/contact', 'ContactController@store');
// show payment screen
// middleware('auth') here indicates that the user is required to be signed in
Route::get('payments/create', 'PaymentsController@create')->middleware('auth');
// submit payment form
// middleware('auth') here indicates that the user is required to be signed in
Route::post('payments', 'PaymentsController@store')->middleware('auth');
// show notifcations page
// user must be signed in
Route::get('notifications', 'UserNotificationsController@show')->middleware('auth');
// 
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
