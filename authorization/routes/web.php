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

// Route::get('/', function () {
//     return view('welcome');
// });

// // show contact page
// Route::get('/contact', 'ContactController@show');
// // submit email form
// Route::post('/contact', 'ContactController@store');
// // show payment screen
// // middleware('auth') here indicates that the user is required to be signed in
// Route::get('payments/create', 'PaymentsController@create')->middleware('auth');
// // submit payment form
// // middleware('auth') here indicates that the user is required to be signed in
// Route::post('payments', 'PaymentsController@store')->middleware('auth');
// // show notifcations page
// // user must be signed in
// Route::get('notifications', 'UserNotificationsController@show')->middleware('auth');


// authentication routes
Auth::routes();
// show the welcome page
Route::view('/', 'welcome');
// show the home page for a user
Route::get('/home', 'HomeController@index')->name('home');
// show all the conversations
Route::get('conversations', 'ConversationsController@index');
// show the form to create a conversation
Route::get('conversations/create', 'ConversationsController@create')->middleware('auth');
// store a conversation in the DB
Route::post('conversations', 'ConversationsController@store');
// store a reply as the best reply for a conversation
Route::post('/conversations/{conversation}/replies/{reply}/best', 'ConversationsBestReplyController@store');
// show the form to create a reply to a conversation
Route::get('conversations/{conversation}/replies/create', 'ConversationsController@replycreate')->middleware('auth');
// store a reply in the DB
Route::post('conversations/{conversation}/replies', 'ConversationsController@replystore');
// show a single conversation
// middleware applied to prevent 
Route::get('conversations/{conversation}', 
'ConversationsController@show')->middleware('can:view, conversation');

// LECTURE #5
Route::get('/welcome', function() {
    return view('welcome');
});
Route::get('/reports', function() {
    return 'Shhh... the secret reports!';
})->middleware('can:view_reports');


