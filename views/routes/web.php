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

// route that accepts a wildcard value (wildcard available in callback fxn/closure)
// when this route is requested, do this (callback fxn)
// Route::get('/post/{postid}', function ($postid) {
//     // user makes a request to the homepage, in response we are loading a view (html portion of code base)
//     // return $postid;

//     // this associative array simulates a database
//     $posts = [
//         'my-first-post' => 'Hello, this is my first!',
//         'my-second-post' => 'This is my second :D'
//     ];

//     // if the wildcard ($postid) is not a key in the $posts array...
//     if (! array_key_exists($postid, $posts)) {
//         abort(404, 'Sorry that post was not found');
//     }

//     // otherwise, if it is...
//     return view('post', [
//         'post' => $posts[$postid]
//     ]);
// });

// up to this point, have been using a closure to handle the routes logic (good for small projects)... but will usually use a controller for this (route to a controller)
Route::get('/post/{postid}', 'PostsController@show');

Route::get('/contact', function () {
    // user makes a request to the homepage, in response we are loading a view (html portion of code base)
    return view('contact');
});

Route::get('/about', function () {
    // user makes a request to the homepage, in response we are loading a view (html portion of code base)

    // ARTICLES QUERY
    // *** would normally do this in a dedicated controller ***
    // fetch all of the articles in the about section
    // take(3) => grabs the 3 most recent articles 
    // latest() => helper method that updates the SQL query => tells it to "order by the created_at in descending order" => organizes items in descending order, by the "created_at" timestamp, so that the newest one is at the top
    // can also include an argument in latest() to change how the items are ordered i.e. latest('updated_at')
    // get() => get the results
    $articles = App\Article::take(3)->latest()->get();
    // return $articles;

    // pass the $articles to the view
    return view('about', [
        'articles' => $articles
    ]);
});

// route to show a single article
// user makes a request to a specific article's page (using the wildcard {article}), in response we are calling the get() method on the Route class and passing in the path and the associated controller + controller method
Route::get('/articles/{article}', 'ArticlesController@show');

// route to show all the articles
Route::get('/articles', 'ArticlesController@index');

// Also....
// route to create an article
// route to persist/save an article
// route to edit an existing article
// route to update an existing article
// route to delete an article
// 7 RESTful controller actions

