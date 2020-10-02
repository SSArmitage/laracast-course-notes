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

    // this function gets all the articles of a given user
    public function articles() {
        // this $user has many articles (refernce the associated Article model)
        // this is being translated into the appropriate SQL query
        // i.e. select * from articles where user_id = id of the current user instance (give me all articles scoped to this $user)
        // articles table needs to have a user_id column => this creates the link between the Article and the User
        return $this->hasMany(Article::class);
    }

    // this function gets all the projects of a user
    public function projects() {
        // this $user has many projects (refernce the associated Project model)
        // this is being translated into the appropriate SQL query
        // i.e. select * from projects where user_id = id of the current user instance (give me all projects scoped to this $user)
        // projects table needs to have a user_id column => this creates the link between the Project and the User
        return $this->hasMany(Project::class);
    }
}

// give me the users projects:
// $user->projects;
// execute an SQL query: select * from projects where user_id = $user->id (id of the current user)
// this query will be returned as an eloquent collection and then assigned to this "projects" property ($user->projects)
// eloquent collection => here will be a collection of projects you can iterate over. Collections have a bunch of functionality i.e. first(), last(), etc
// even though $user->articles() is a method, when you want to access a relationship, or access a record/collection for that relationship, you call it as a property (why???)
// you can grab the first project: $user->projects->first();
// when you go to access this projects property on the $user, 