<div 
class="border border-blue-400 rounded-lg px-8 py-6 mb-8"
style="border-radius:1.25rem"
>
    <form method="POST" action="/tweets">
        <!-- csrf protection -->
        @csrf
        <textarea 
        name="body" 
        id="" 
        class="w-full" 
        placeholder="What's up doc?"
        required
        >
        </textarea>
        <!-- horizontal rule -->
        <hr class="my-4">
        <!-- avatar + button -->
        <footer class="flex justify-between">
            <div style="width:40px;">
                <!-- <img src="https://api.adorable.io/avatars/40/abott@adorable.png" alt="" class="rounded-full mr-2"> -->
                <!-- <img src="https://api.adorable.io/avatars/40/{{ auth()->user()->email }}" alt="" class="rounded-full mr-2"> -->
                <!-- pass in the desired avatar size -->
                <img src="{{ auth()->user()->getAvatarAttribute(40) }}" alt="Your avatar" class="rounded-full mr-2">
            </div>
            <button 
            type="submit" 
            class="bg-blue-500 rounded-lg shadow py-2 px-2 text-white"
            >
            Tweet-Tweet
            </button>
        </footer>
    </form> 

    @error('body')        
        <p class="text-red-500 mt-4">{{ $message }}</p>   
    @enderror
</div>