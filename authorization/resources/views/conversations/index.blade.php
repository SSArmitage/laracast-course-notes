@extends('layouts.app')

@section('content')
    @foreach ($conversations as $conversation)
        <h2><a href="/conversations/{{ $conversation->id }}">{{ $conversation->title }}</a></h2>

        <!-- what is this? -->
         @continue($loop->last)

        <!-- what is this? -->
         <hr>

    @endforeach

    <!-- button to create a new conversation -->
    <form action="/conversations/create" method="GET">
        <button>New conversation</button>
    </form>

@endsection