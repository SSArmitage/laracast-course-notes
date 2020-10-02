<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Conversation;
use App\Reply;

class ConversationsController extends Controller
{
    public function index() {
        // grab the conversations from the database
        $conversations = Conversation::all();
        // render the view and pass in the conversations
        return view('conversations.index', [
            'conversations' => $conversations
        ]);
    }

    // pass in a $conversation (ensure it is an instance of the Conversation class - type hinting)
    public function show(Conversation $conversation) {
        // check that the user is authorized to see this conversation (they must have created it to view it) => added a view() method on the ConversationPolicy + a middleware on the route to do the authorization
        $this->authorize('view', $conversation);
        // render the view and pass in the conversation
        return view('conversations.show', [
            'conversation' => $conversation
        ]);
    }

    public function create() {
        return view('conversations.create');
    }

    public function store() {
        // Server-side validation
        // $validatedAttributes = $this->validateConversation();
        // // validate request, and then pass those validated attributes into the create method
        // Conversation::create($validatedAttributes);

        $conversation = new Conversation(request(['title', 'body']));
        // then set the user who wrote the message
        // in the future will use auth()->id() (set the user_id to who ever is curretnly signed in)
        $conversation->user_id = auth()->id(); 
        // persist 
        $conversation->save();
        // return redirect(route('conversations.index'));
        // return view('conversations.index');
        // grab the conversations from the database
        $conversations = Conversation::all();
        // render the view and pass in the conversations
        return view('conversations.index', [
            'conversations' => $conversations
        ]);
    }

    public function replycreate($conversationId) {
        // pass in the current conversation id (from the wildcard)
        return view('conversations.replycreate', [
            'conversationId' => $conversationId
        ]);
    }

     public function replystore($conversationId) {
        // create a new reply object, storing the user create input values on the new reply object
        $reply = new Reply(request(['body']));
        $reply->user_id = auth()->id();
        $reply->conversation_id = $conversationId;
        $reply->save();
        // grab the current conversation from the DB (using the conversation id passed in)
        $conversation = Conversation::find($conversationId);
        // return redirect(route('conversations.show'));
        return view('conversations.show', [
            'conversation' => $conversation
        ]);
    }

    // this function will validate that the request inputs match the following (validate user input data)
    protected function validateConversation() {
        // you can pass in a validation rule as a single delimited "|" string OR as arrays of rules
        // i.e. 'required|email' vs ['required', 'email']
        return request()->validate([
            'title' => ['required', 'min:3'],
            'body' => ['required', 'max:255']
        ]);
    }
}
