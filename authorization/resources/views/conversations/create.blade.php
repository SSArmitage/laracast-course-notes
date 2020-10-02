@extends('layouts.app')

@section('content')
   <form action="/conversations" method="POST">
    @csrf

    <label for="title">Title</label>
    <input type="text" name="title" id="title">

    <label for="body">Body</label>
    <input type="text" name="body" id="body">

    <button type="submit">Send</button>

   </form>

@endsection