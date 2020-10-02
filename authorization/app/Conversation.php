<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    // All fields inside $fillable array can be mass-assigned 
    protected $fillable = ['title', 'body', 'user_id'];
    
    public function user() {
        // returns the user that owns this conversation
        return $this->belongsTo(User::class);
    }

    public function replies() {
        // returns all the replies that belong to this conversation
        return $this->hasMany(Reply::class);
    }

    // function to set the best reply of a conversation
    public function setBestReply(Reply $reply) {
        $this->best_reply_id = $reply->id;
        $this->save();
    }
    
}
