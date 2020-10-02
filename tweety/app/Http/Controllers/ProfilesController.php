<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class ProfilesController extends Controller
{
    // this function displays a profile of a particular user
    // the $user will be passed in as the route wildcard value
    // by default, laravel is assuming that the route key name ($user) is the id if the user
    // to override this, go to the User model and override the getRouteKeyName() method
    // the name of the key (attribute in the DB) that should be used for route model binding (usually the primary key)
    public function show(User $user) {
        // return User::find($user);
        // return $user;

        // return the profile view and send through the user
        return view('profiles.show', [
            'user' => $user
        ]);
    }
}
