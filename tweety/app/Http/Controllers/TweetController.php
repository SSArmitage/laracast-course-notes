<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tweet;

class TweetController extends Controller
{
    // this function displays all the tweets (timeline)
    public function index() {
        // load the homepage, passing in the user's tweets
        // auth()->user()->timeline() => grabs the current user, then calls the timeline() method on the user instance (this will grab all the tweets that should be displayed on the user's timeline)
        return view('tweets.index', [
            'tweets' => auth()->user()->timeline()
        ]);
    }

    // this function saves a new tweet to the DB
    public function store() {
        // validate the request
        // when you perform validation, the validated attributes will be saved as an array
        $attributes = request()->validate(['body'=>'required|max:255']);
        // persist the tweet
        Tweet::create([
            'user_id' => auth()->id(),
            // 'body' => request('body')
            'body' => $attributes['body']
        ]);
        // redirect back to homepage
        return redirect('/home');
    }
}
