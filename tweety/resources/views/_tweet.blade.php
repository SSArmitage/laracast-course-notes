<div class="flex p-4 border-b border-b-gray-400">
    <!-- avatar -->
    <div class="mr-2 flex-shrink-0">
        <div>
            <a href="/profiles/{{ $tweet->user->name }}">
                <!-- <img src="https://api.adorable.io/avatars/50/abott@adorable.png" alt="" class="rounded-full mr-2"> -->
                 <!-- add a unique id to get the same avatar each time, provide a unique key-->
                 <!-- can switch to old avatars, by changing avatars=>avatar -->
                <img 
                src="{{ $tweet->user->getAvatarAttribute(50) }}" 
                alt="" 
                class="rounded-full mr-2" 
                style="
                    width:50px; 
                    height:50px
                ">
                 <!-- <img src="https://i.pravatar.cc/50?u=fake@pravatar.com" alt="" class="rounded-full mr-2"> -->
                 <!-- add a unique id to get the same avatar each time, provide a unique key-->
                 <!-- <img src="https://i.pravatar.cc/50?u={{ $tweet->user->email }}" alt="" class="rounded-full mr-2"> -->
            </a>
        </div>
    </div>
    <!-- user's details -->
    <div>
        <h5 class="font-bold mb-4">
            <a href="/profiles/{{ $tweet->user->name }}">{{ $tweet->user->name }}</a>
        </h5>
        <p class="text-sm">
            {{ $tweet->body }}
        </p>
    </div>
</div>
