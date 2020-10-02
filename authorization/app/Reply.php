<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    // All fields inside $fillable array can be mass-assigned 
    protected $fillable = ['body'];

    // this function gets the user of a given reply
    public function user() {
        // returns the user that owns this reply
        return $this->belongsTo(User::class);
    }

    // this function gets the conversation of a given reply
    public function conversation() {
        // returns the conversation that owns this reply
        return $this->belongsTo(Conversation::class);
    }

    // function that checks whether a reply is the "best reply"
    public function isBest() {
        return $this->id === $this->conversation->best_reply_id;
    }
}
