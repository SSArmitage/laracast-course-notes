<?php

namespace App\Http\Controllers;

use App\Post;

class PostsController {
    public function show($slug) {
        // $slug here represents the postid
        // $slug gets passed in from the Router, it is the query string of the request

        // using DB class (in the global namespace) I want to select from the "posts" table, where a slug column is equal to what we fetched from the URI ($slug), and give me the first result
        // without the "\" would assume the DB is in the current namespace (could also import in the class using => use DB)
        // DB is a query builder
        // $post = \DB::table('posts')->where('slug', $slug)->first();
        // usually use eloquent instead of a query builder
        // firstOrFail => give me the first post that matches this criteria, or throw a model not found exception that will generate a 404
        $post = Post::where('slug', $slug)->firstOrFail();
        
        // dump die => inspect variable and kill execution
        // dd($post);

        // if the wildcard ($postid) is not a key in the $posts array...
        // if (! $post) {
        //     abort(404, 'Sorry that post was not found');
        // }

        // otherwise, if it is...
        return view('post', [
            'post' => $post
        ]);

        // // can make it inline
        // return view('post', [
        //     'post' => Post::where('slug', $slug)->firstOrFail();
        // ]);
    }
}