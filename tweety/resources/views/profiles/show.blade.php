@extends('layouts.app')

@section('content')
    <!-- <p>Profile page for {{ $user->name }}</p> -->
    <header class="mb-6 relative">
        <div 
        style="
            width:700px;
            border-radius:1.25rem;
            overflow:hidden
        " 
        class="mb-2">
            <img 
            src="https://pbs.twimg.com/profile_banners/166985114/1562243400/1500x500">
        </div>
        <div class="flex justify-between items-center mb-4">
            <!-- user info -->
            <div>
                <h2 class="font-bold text-2xl">{{ $user->name }}</h2>
                <p class="text-sm">Joined {{\Carbon\Carbon::parse($user->created_at)->diffForHumans()}}</p>
            </div>
            <!-- buttons -->
            <div>
                <a  
                class="rounded-full border border-gray-300 py-2 px-4 text-xs mr-2"
                >
                Edit Profile
                </a>

                <a
                class="bg-blue-500 rounded-full shadow py-2 px-4 text-white text-xs"
                >
                Follow Me
                </a>
            </div>
        </div>

        <!-- user description -->
        <p class="text-sm">Living in London, originally from Peru. Always keep a marmalade sandwich under your hat in case of emergencies.</p>

        <!-- profile picture -->
        <div>
            <img 
            src="{{ $user->getAvatarAttribute(50) }}" 
            alt="" 
            class="rounded-full mr-2 absolute"
            style="
                width:150px;
                top:40%;
                left:calc(50% - 75px)
            ">
        </div>
    </header>

    <!-- ->tweets b/c it is returning the relationship instance -->
    @include('_timeline', [
        'tweets' => $user->tweets
    ])
@endsection