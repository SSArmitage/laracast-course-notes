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

    // route notification for nexmo (specify which phone number to send the notification sms -to)
      public function routeNotificationForNexmo($notification)
    {
        // return $this->phone_number;
        return '16479383269';
    }

    // this function gets all the conversations of a given user
    public function conversations() {
        // this $user has many conversations (refernce the associated Article model)
        // this is being translated into the appropriate SQL query
        // i.e. select * from conversations where user_id = id of the current user instance (give me all articles scoped to this $user)
        // articles table needs to have a user_id column => this creates the link between the Article and the User
        return $this->hasMany(Conversation::class);
    }

     // this function gets all the conversations of a given user
    public function replies() {
        // this $user has many conversations (refernce the associated Article model)
        // this is being translated into the appropriate SQL query
        // i.e. select * from conversations where user_id = id of the current user instance (give me all articles scoped to this $user)
        // articles table needs to have a user_id column => this creates the link between the Article and the User
        return $this->hasMany(Reply::class);
    }

    // this function gets all the roles of a user
    public function roles() {
         // b/c we have timestamps declared in the migration, you need to explcitly apply them
        return $this->belongsToMany(Role::class)->withTimeStamps();
    }

    // this function assigns a role to a user
    // accepts a $role object
    public function assignRole($role) {
        // excepting a role insatnce here, but if a strng is passed in (if you dont have access to a Role instance)... find the Role to get an instance
        // i.e. 'manager' gets passed in
        // whereName() => ??
        // firstOrFail() => ??
        if (is_string($role)) {
            $role = App\Role::whereName($role)->firstOrFail;
        }


        // $this->roles()->save($role);
        // instead of using save() can use sync()
        // replace all of the existing records in the pivot table with this collections, and any that are not included in this collection but are in the DB will be dropped. If you d/n want to drop anything, set 2nd paramenter as false. so not it will just add new records
        $this->roles()->sync($role, false);
    }

    // this function gets all the abilities of a user (NOT AN ELOQUENT RELATIONSHIP - getting the abilities via the roles of the user)
    // since this is not an eloquent relationship, you must call this method in the normal way i.e. $user->abilities()
    public function abilities() {
        return $this->roles->map->abilities->flatten()->pluck('name')->unique();
    }
}
