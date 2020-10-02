@extends('layout')

@section('head')
<!-- put style sheet here (if this view needs a different style) -->
@endsection

@section('content')
    <div class="wrapper">
        <div id="page" class="container">
            <h1>New Article</h1>
            <form method="POST" action="/articles">
            <!-- cross-site request forgery (crsf directive) -->
            <!-- expands out to a hidden input with a name="token" and a value="some unique string that will be verified on your server" -->
            <!-- 
                <input type="hidden" name="token" value="uniqueString">
             -->
            <!-- protects you from malicious users on other servers faking form requests to your server -->
            <!-- AKA a CSRF token -->
            <!-- always include this -->
            @csrf
                <!-- title -->
                <div class="field">
                    <label class="label" for="title">Title</label>
                    <div class="control">
                        <!-- include browser level validation by including the "required" keyword (as an extra level of validation in addition to the server side validation) -->
                        <!-- can include a conditional to see if the $errors object has anything for the 'title' and then if so, highlight the input & include an error message -->
                        <!-- NOTE: instead of an inline style, could conditionaly add a class, and the class could be associated with the style -->
                        <!-- old() => helper function that provides the previous input value (found in vendor/laravel/framework/src/illuminate/Foundation/helpers.php). Laravel allows you to keep input from one request during the next request, useful for re-populating forms after detecting validation errors-->
                        <input 
                        class="input" 
                        type="text" id="title" 
                        name="title" 
                        style="{{$errors->has('title') ? 'border:2px solid red' : ''}}"
                        value="{{ old('title') }}"
                        >
                        <!-- could also do it this way: -->
                        <!-- <input 
                        class="input" 
                        type="text" id="title" 
                        name="title" 
                        style="@error('title') border:2px solid red  @enderror"
                        > -->
                        @if ($errors->has('title'))
                            <p class="help is-danger">{{ $errors->first('title') }}</p>
                        @endif
                    </div>
                </div>
                <!-- excerpt -->
                <div class="field">
                    <label class="label" for="excerpt">Excerpt</label>
                    <div class="control">
                        <input 
                        class="input" 
                        type="text" 
                        id="excerpt" 
                        name="excerpt"
                        style="{{$errors->has('excerpt') ? 'border:2px solid red' : ''}}"
                        value="{{ old('excerpt') }}"
                        >
                        @if ($errors->has('excerpt'))
                            <p class="help is-danger">{{ $errors->first('excerpt') }}</p>
                        @endif
                    </div>
                </div>
                <!-- body -->
                <div class="field">
                    <label class="label" for="body">Body</label>
                    <div class="control">
                        <input 
                        class="input" 
                        type="text" 
                        id="body" 
                        name="body"
                        style="{{$errors->has('body') ? 'border:2px solid red' : ''}}"
                        value="{{ old('body') }}"
                        >
                        @if ($errors->has('body'))
                            <p class="help is-danger">{{ $errors->first('body') }}</p>
                        @endif
                    </div>
                </div>
                <!-- tags -->
                <div class="field">
                    <label class="label" for="">Tags</label>
                    <div class="control">
                        <!-- name is an array called "tags" because users can add multiple tags, the value of each selected option will be added to the tags array in the request instance (these values will be inserted into the pivot table)-->
                        <!-- multiple => allows the user to select any number of tags -->
                        <select 
                        name="tags[]"
                        multiple>
                            @foreach ($tags as $tag)
                                 <!-- the tag id is stored in the pivot table -->
                                <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                            @endforeach
                        </select>

                        @if ($errors->has('tags'))
                            <p class="help is-danger">{{ $errors->first('tags') }}</p>
                        @endif
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