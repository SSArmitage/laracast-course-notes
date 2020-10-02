<h3 class="font-bold text-xl mb-4">Following</h3>

<ul>
    @foreach(auth()->user()->follows as $user)
        <li class="mb-4">
            <div>
                <a 
                href="/profiles/{{ $user->name }}"
                class="flex items-center text-sm">
                    <div class="mr-2">
                        <img src="{{ $user->getAvatarAttribute(40) }}" alt="" class="rounded-full mr-2" style="width:50px">
                    </div> 
                    <p>{{ $user->name }}</p>
                </a>
            </div>
        </li>
    @endforeach
</ul>