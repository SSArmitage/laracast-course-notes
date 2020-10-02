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
    // Article => model name
    // $article => instance of article (wildcard used to grab the article from the database)
    // NOTE: if you dont want to search the database based on the primary key, and instead want to use a slug like /articles/get-to-know-us (get-to-know-us would be the column title in the database), you need to go to the associated model i.e. Article and overwrite a method called "getRouteKeyName"
    public function show(Article $article) {
        // laravel captures the wildcard value (passed into the router), and knows the article #, next when you request an article instance here ($article) laravel knows that the matching wildcard variable is the one it captured, and it runs a SQL query as follows:
        //  Article::where('id', 1)-> first()
        // meaning: give me an article where it's id (primary key) is the wildcard=1, and give me the first result. That result ($article) is passed to the show() method
        // this happens behind the scenes automatically
        // NOTE: wildcard name is important => needs to match the controller fxn parameter

        // instead of ['article' => $article] can put compact('article')
        // The compact() function creates an array from variables and their values
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
        // $validatedAttributes = request()->validate([
        //     'title' => ['required', 'min:3'],
        //     'excerpt' => 'required',
        //     'body' => ['required', 'max:255']
        // ]);
        // instead of the above, can make the validation a method, and call it here
        $validatedAttributes = $this->validateArticle();

        // sending form data for new article to the database
        // assigning each input manually to our model and then saving to database.
        // create instance of Article (model)
        // $article = new Article;
        // $article->title = request('title');
        // $article->excerpt = request('excerpt');
        // $article->body = request('body');
        // // persist the data
        // $article->save();

        // Instead of the above can use the create() method to create the article instance, assign the properties, and save it
        // assigns the properties to the Article model (instance of the Article class) all at once, instead of one at a time
        // Article::create([
        //     'title' => request('title'),
        //     'excerpt' => request('excerpt'),
        //     'body' => request('body')
        // ]);
        // this will result in a mass assignment error: "Add [title] to fillable property to allow mass assignment on [App\Article]
        // laravel protects you against "mass assignment" vulnerabilities (when an unexpected and undeclared parameter is passed from the request and changes a record in your database table)
        // to fix this need to go to the Article model

        // to reduce duplication of properties...
        // after the validation is successful it will return the validated attributes from the fxn call => this array is EXACTLY what we want to pass into the create() method! So you can put that directly into the create() method
        // so... validate request, and then pass those validated attributes into the create method
        Article::create($validatedAttributes);

        // redirect
        // return redirect('/articles');
        // return redirect(route('articles.index'));
        return redirect($article->path());
    }

    // 5. edit => show a view to edit an existing resource (i.e. form that allows user to edit)
    public function edit(Article $article) {
        
        return view('articles.edit', [ 'article' => $article]);
    }

    // 6. update => persist update to resource (handles the "edit" form submission)
    public function update(Article $article) {
        // Server-side validation
        // $validatedAttributes = request()->validate([
        //     'title' => ['required', 'min:3'],
        //     'excerpt' => 'required',
        //     'body' => ['required', 'max:255']
        // ]);
        // instead of the above, can make the validation a method, and call it here
        $validatedAttributes = $this->validateArticle();

        // set the properties with the new values
        // here do not call the Article::create() method b/c the article has already been created, instead want to update() the existing article
        // update() => assigns the attributes and persist it to the database
        $article->update($validatedAttributes);

        // redirect
        // return redirect('/articles/'.$article->id);
        // instead of hard coding the redirect use a named route
        // return redirect(route('articles.show', $article));
        // use path() method on the article instance
        return redirect($article->path());
    }

    // 7. destroy => destroy/delete the resource
    public function destroy() {

    }

    // this function will validate that the request inputs match the following (validate user input data)
    // how to validate the incoming request from your users
    // if you add a new field to your form, you just need to update this method 
    protected function validateArticle() {
        // return the validated attributes
        // request() =>
        // validate() =>
        return request()->validate([
            'title' => ['required', 'min:3'],
            'excerpt' => 'required',
            'body' => ['required', 'max:255']
        ]);
    }
}
