<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ability extends Model
{
    protected $guarded = [];
    // this function gets all the roles that an ability belongs to
    // i.e. 'edit_content', 'delete_content'
    public function roles() {
        // b/c we have timestamps declared in the migration, you need to explcitly apply them
        return $this->belongsToMany(Role::class)->withTimeStamps();
    }
}
