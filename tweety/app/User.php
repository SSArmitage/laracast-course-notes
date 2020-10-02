<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // function that grabs all the tweets to display on the current user's timeline
    public function timeline() {
        // want:
        // all of the current user's tweets
        // all of the tweets from everyone the current user follows
        // listed in descending order, by date

        // grab the users that the person follows, and just take their id's
        // ->follows grabs all the users that the person follows (returns the relationship instance for each person, creates a collection of all those instances)
        // ->follows() does not return the relationship instances (better for perfromance) 
        // ->follows()->pluck('id') => only get the ids, and not the collection of users and then the id's
        $ids = $this->follows->pluck('id');
        // add the current user's id to this collectiond of id's
        $ids->push($this->id);
        // from the tweets table, grab the items (tweets) that have a 'user_id' that belongs to the $ids array, sort them, and return the results 
        return Tweet::whereIn('user_id', $ids)->latest()->get();
    }

    // this function grabs all the tweets of a particular user
    public function tweets() {
        return $this->hasMany(Tweet::class);
    }

    // this function grabs the user's unique avatar (custom accessor - getter)
    public function getAvatarAttribute($size) {
        return "https://api.adorable.io/avatars/"."200"."/{{ $this->email }}";
    }

    // function that gets all the people that the user follows (the user belongs to/follows many other users)
    public function follows() {
        // be explicit that the table name is 'follows' (otherwise you get an exception b/c laravel is trying to guess the name of the table incorrectly)
        // also, b/c we are using custom column names, need to specifiy the $foreignPivotKey ('user_id') and the $relatedPivotKey ('following_user_id')
        return $this->belongsToMany(User::class, 'follows', 'user_id', 'following_user_id');
    }

    // function to follow a user (create a new follow relationship)
    public function follow(User $user) {
        // delegate to the follow replationship + save the new user they are following
        // grab the users they are following and add a new user
        return $this->follows()->save($user);
    }

    // this function returns the name of the key (attribute in the DB) that should be used for route model binding (usually the primary key)
    public function getRouteKeyName() {
        return 'name';
    }
}
