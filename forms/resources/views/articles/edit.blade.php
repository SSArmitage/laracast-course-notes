@extends ('layout')

@section ('content')
    <div class="wrapper">
        <div id="page" class="container">
            <h1>Update Article</h1>
            <!-- want to do a PUT request to save the edit to an excisting article, but browsers only understand GET and POST, so need to use a POST request but add something to the request to let laravel know that we actually want a PUT request => add a "method" directive => @method('PUT') -->
            <!-- expands out to:
            <input type="hidden" name="_method" value="PUT"> 
            -->
            <!-- laravel detects this and routes accordingly -->
            <!-- this occurs for PUT, PATCH, DELETE -->
            <form method="POST" action="/articles/{{$article->id}}">
            <!-- cross-site request forgery (crsf directive) -->
            <!-- expands out to a hidden input with a name="token" and a value="some unique string that will be verified on your server" -->
            <!-- 
                <input type="hidden" name="token" value="uniqueString">
             -->
            <!-- protects you from malicious users on other servers faking form requests to your server -->
            <!-- AKA a CSRF token -->
            <!-- always include this -->
            @csrf
            @method('PUT')
                <!-- title -->
                <div class="field">
                    <label class="label" for="title">Title</label>
                    <div class="control">
                        <input class="input" type="text" id="title" name="title" value="{{$article->title}}">
                    </div>
                </div>
                <!-- excerpt -->
                <div class="field">
                    <label class="label" for="excerpt">Excerpt</label>
                    <div class="control">
                        <input class="input" type="text" id="excerpt" name="excerpt" value="{{$article->excerpt}}">
                    </div>
                </div>
                <!-- body -->
                <div class="field">
                    <label class="label" for="body">Body</label>
                    <div class="control">
                        <input class="input" type="text" id="body" name="body" value="{{$article->body}}">
                    </div>
                </div>
                <!-- button -->
                <div class="field is-grouped">
                    <div class="control">
                        <button class="button is link" type="submit">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection