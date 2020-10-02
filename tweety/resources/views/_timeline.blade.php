<div 
class="border border-gray-300 rounded-lg"
style="border-radius:1.25rem">
        <!-- iterate over the tweets in the DB -->
    @foreach($tweets as $tweet)
        @include('_tweet')
    @endforeach
</div>