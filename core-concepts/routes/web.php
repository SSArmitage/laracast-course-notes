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
    // if you return a php, laravel wil automatically convert it to JSON
    // useful when building APIs
    return ['foo' => 'bar'];
});

Route::get('/test', function() {
    // fetch data using the request helper function request()
    // The request function returns the current request instance or obtains an input item (provide the key you are looking for)
    // $request = request('');
    $value = request('name');;

    // pass data ($value) to the view as the second argument of this function
    return view('test', [
        'value' => $value
        ]);
});

// route that accepts a wildcard value
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


// user makes a request to a specific article's page (using the wildcard {article}), in response we are calling the get() method on the Route class and passing in the path and the associated controller + controller method

// **** 7 RESTful controller actions ****
// NOTE: order matters here i.e. if '/articles/{article}' route is declared above the '/articles/create' route, '/articles/{article}' will take precedence and a request with '/articles/create' will initiate the '/articles/{article}' route, where create = {article}. In order to avoid this, place the wildcard route after

// route to create a new article => should display a form to create a new article
Route::get('/articles/create', 'ArticlesController@create');
// route to persist/save an article 
// listen for a POST request to '/articles' & that will hit an ArticlesController & a store method
// make POST request to endpoint
Route::post('/articles', 'ArticlesController@store');
// route to show a single article
// named routes => after you declare the route you give it a name() => can reference the URI by using the name
Route::get('/articles/{article}', 'ArticlesController@show')->name('articles.show');
// route to show all the articles
Route::get('/articles', 'ArticlesController@index')->name('articles.index');
// route to edit an existing article => should display a form to edit an existing article
// because of the {}/wildcard/subdomain of the URI, it passes whatever is inside (wildcard parameter) to the controller 
Route::get('/articles/{article}/edit', 'ArticlesController@edit');
// route to update an existing article
Route::put('/articles/{article}', 'ArticlesController@update');
// route to delete an article
Route::delete('/articles/{article}', 'ArticlesController@destroy');


// combine an HTTP verb + URI structure to handle any operation
// use request type (GET, POST, UPDATE, DELETE) to channel incoming requests (communicate intent)
// approximately match up with CRUD (create, read, update, delete)

// GET => reading resource
// PUT => updating existing resource
// POST => saving new resource
// DELETE => remove an existing resource

// ----------------------------------------------- //
// *** service container practice ***
Route::get('/service', function() {
    // *** NOTE: the following would noramlly go in a "service provider"
    // instantiate a new container
    $container = new App\Container();
    // storing things in the container
    // bind(key, data) 
    // here binding a function (so the key will be a property on the container and the fxn will be a method on the container that returns an Example instance )
    // can add configuration in the ()
    $container->bind('example', function() {
        // instantiate the Example.php class
        return new App\Example();
    });
    // resolve example object instance out of the container, and can use it's properties/methods
    $example = $container->resolve('example');
    $example->go();
    // dd($example);
    // ddd() => laravel helper fxn (Dump, Die, Debug)
    // ddd($container);
});
// ----------------------------------------------- //
// *** facade practice ***
Route::get('/facade', 'PagesController@home');