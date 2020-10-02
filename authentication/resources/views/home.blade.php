@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <!-- once signed in you can access information about the authenticated user -->
                    <!-- Auth, give me the authenticated user => Auth::user() or auth()->user() is an instance of the User model => and then from that, grab the users name -->
                    <!-- if the user is not signed in, Auth::user() will return null -->
                    You and logged in, {{ Auth::user()->name }}
                    <!-- {{ __('You are logged in,') }} -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
