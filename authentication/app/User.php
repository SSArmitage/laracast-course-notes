<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
// Auth/User extends Model  => Authenticatable
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

// The User class (app/User) by default extends Illuminate\Foundation\Auth\User as Authenticable, and thhis class already extends the Model class
class User extends Authenticatable //where Authenticatable === Auth/User
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
}
