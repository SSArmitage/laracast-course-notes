<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Article;

class ArticlesController extends Controller
{
    // show => show a specific resource (i.e. a specific article)
    public function show($articleId) {
        // $articleId gets passed in (query value grabbed from the request URI) from the router instance => wildcard value in the route
        // dd($articleId);
        // var_dump(Article);

        $article = Article::find($articleId);
        // pass in the $article to the view "show"
        return view('articles.show', ['article' => $article]);
    }

    // index => renders a list of a resource (i.e. list of articles)
    public function index() {
        // grab the articles in descending order
        $articles = Article::latest()->get();
        // pass in the list of $articles to the view "index"
        return view('articles.index', ['articles' => $articles]);
    }
}
