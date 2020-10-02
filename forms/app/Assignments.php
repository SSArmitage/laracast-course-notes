<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

// Assignments class extends from the Model class
class Assignments extends Model
{
    // this method will mark an assignment as complete
    public function complete() {
        $this->completed = true;
        $this->save();
    }
}
