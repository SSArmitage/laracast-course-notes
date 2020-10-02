<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    // this function gets the user of a project
    // when you call user as a property i.e. $project->user, you are still ultimately calling this method
    public function user() {
        // this is being translated into the appropriate SQL query
        // i.e. select * from user where project_id = id of the current project
        // searches through the users table to find the user with the id that matches the current project's project_id
        // this $project belongs to this user (refernce the associated User model)
        // returns the user that owns this project
        return $this->belongsTo(User::class);
    }
}