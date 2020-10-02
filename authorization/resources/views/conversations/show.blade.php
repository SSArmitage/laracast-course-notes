@extends('layouts.app')

@section('content')
    <!-- this link routes the user back to the "/conversations" endpoint -->
    <p><a href="/conversations">Back</a></p>

    <div style="border:2px solid blue;padding:10px">
        <h1>{{ $conversation->title }}</h1>
    
        <!-- this is an eloquent relationship: a user can have many articles, but an article can onle have one user -->
        <!-- need to add eloquent relationships to the User (User->conversation => $this->hasMany()) & Conversation (Conversation->user => $this->belongsTo()) -->
        <!-- need to add foreign key to the conversations table (related to the id of the users table) -->
        <p class="text-muted">Posted by: {{ $conversation->user->name }}</p>
    
        <div>
            {{ $conversation->body }}
        </div>
    </div>

    @include ('conversations.replies')

@endsection