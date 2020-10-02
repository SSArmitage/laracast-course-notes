<?php

namespace App\Http\Controllers;

class PostsController {
    public function show($postid) {
        // return 'hello';


    // this associative array simulates a database
    $posts = [
        'my-first-post' => 'Hello, this is my first!',
        'my-second-post' => 'This is my second :D'
    ];

    // if the wildcard ($postid) is not a key in the $posts array...
    if (! array_key_exists($postid, $posts)) {
        abort(404, 'Sorry that post was not found');
    }

    // otherwise, if it is...
    return view('post', [
        'post' => $posts[$postid]
    ]);
    }
}