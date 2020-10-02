<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Article;

// this function contains the 7 restful controller action (most applcations are glorified CRUD applications- create, read, update, delete)
class ArticlesController extends Controller
{
    // 1. index => renders a list of a resource (i.e. list of articles)
    public function index() {
        // grab the articles in descending order
        $articles = Article::latest()->get();
        // pass in the list of $articles to the view "index"
        return view('articles.index', ['articles' => $articles]);
    }

    // 2. show => show a single resource (i.e. a specific article)
    public function show($articleId) {
        // $articleId gets passed in (query value grabbed from the request URI) from the router instance => wildcard value in the route
        $article = Article::find($articleId);
        // pass in the $article to the view "show"
        return view('articles.show', ['article' => $article]);
    }

    // 3. create => shows a view to create a new resource (i.e. form that allows user to create a new article)
    public function create() {
        return view('articles.create');
    }

    // 4. store => persist the new resource (handles the "create" form submission)
    public function store() {
        // request() => The request function (helper fxn) returns the current request instance
        // all() => You can retrieve all of the input data as an array using the all method
        // dump(request()->all());

        // Server-side validation
        // prevents malicous input from reaching the SQL query (if not stopped/validated, app will try to build up the SQL query (with the given inputs) that runs against the database)
        // can set fields as required
        // if any validation fails here, laraval will re-direct back to the previous page and populate an $errors variable as an object that you can use to provide the user with error info
        request()->validate([
            'title' => ['required', 'min:3'],
            'excerpt' => 'required',
            'body' => ['required', 'max:255']
        ]);

        // sending form data for new article to the database
        // create instance of Article (model)
        $article = new Article;
        $article->title = request('title');
        $article->excerpt = request('excerpt');
        $article->body = request('body');
        // persist the data
        $article->save();

        // redirect
        return redirect('/articles');
    }

    // 5. edit => show a view to edit an existing resource (i.e. form that allows user to edit)
    // the wildcard parameter from the sub-domain gets passed in as an argument
    public function edit($articleId) {
        // grab the article to be edited (using the passed in $articleId)
        $article = Article::find($articleId);
        return view('articles.edit', [ 'article' => $article]);
    }

    // 6. update => persist update to resource (handles the "edit" form submission)
    public function update($articleId) {
        // Server-side validation
        request()->validate([
            'title' => ['required', 'min:3'],
            'excerpt' => 'required',
            'body' => ['required', 'max:255']
        ]);

         // grab the article to be edited (using the passed in $articleId)
        $article = Article::find($articleId);

        // set the properties with the new values
        $article->title = request('title');
        $article->excerpt = request('excerpt');
        $article->body = request('body');
        // persist the data
        $article->save();

         // redirect
        return redirect('/articles/'.$articleId);
    }

    // 7. destroy => destroy/delete the resource
    public function destroy() {

    }
}
