<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $guarded = [];
    // this function gets all the abilities of a role
    public function abilities() {
        // return $this->hasMany(App\Ability::class);
         // b/c we have timestamps declared in the migration, you need to explcitly apply them
        return $this->belongsToMany(Ability::class)->withTimeStamps();
    }

    // this function adds an ability to a role
    public function allowTo($ability) {
        // excepting an ability insatnce here, but if a strng is passed in (if you dont have access to an Ability instance)... find the Ability class to get instance
        
        // whereName() => ??
        // firstOrFail() => ??
        if (is_string($ability)) {
            $ability = App\Role::whereName($ability)->firstOrFail;
        }
        // $this->abilities()->save($ability);
        // sync allows you to continue to add roles without replacing them or removing the old ones
        $this->abilities()->sync($ability, false);
    }
}
