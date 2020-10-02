<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Reply;
use App\User;

class ConversationsBestReplyController extends Controller
{
    public function store($conversatiodId, $replyId) {
        // authorize that the current user has permission to set the "best reply" for the conversation
        // grab the reply associated with the id
        $reply = Reply::find($replyId);
        $conversation = $reply->conversation;
        // $this->authorize('update-conversation', $reply->conversation);
        // ** what is "this" here referring to? **
        // $this -> ConversationsBestReplyController instance
        // authorize(abilityName, associatedModel) => authorize an ability
        // i.e. here we are checking if the current user is authorized to "update" the "conversation" (set a best reply)
        $this->authorize('update', $reply->conversation);
        // if they do have permission, set the reply in the DB to be the id of the current reply
        // $reply->conversation->best_reply_id = $reply->id;
        // $reply->conversation->save();
        $reply->conversation->setBestReply($reply);

        // the redirect back to the conversation page
        // return back();
        // return redirect(route("/conversations/$conversatiodId"));
         return view('conversations.show', [
            'conversation' => $conversation
        ]);
    }
}
