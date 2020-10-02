<!-- this displays all the replies to a conversation -->
@foreach($conversation->replies as $reply)
<div style="border:2px solid green;padding:10px;margin:10px 0">
    <header style="display:flex;justify-content:space-between">
        <p class="m-0"><strong>{{ $reply->user->name}} said...</strong></p>
        <!-- if the current reply is set as the "best reply", then display the label below -->
        @if ($reply->isBest())
            <span style="color:green">Best Reply!!!</span>
        @endif
    </header>
    <!-- reply body text -->
    {{ $reply->body }}
    <!-- if the current user can update a conversation, then display the "Best Reply?" form -->
    @can ("update", $conversation)
    <!-- the button to choose the particular reply as the "best reply" -->
        <form action="/conversations/{{ $conversation->id }}/replies/{{ $reply->id }}/best" method="POST">
            @csrf
            <button type="submit" class="btn p-0 text-muted">Best Reply?</button>
        </form>
    @endcan
</div>
@endforeach
<!-- button to create a new reply -->
<form action="/conversations/{{ $conversation->id }}/replies/create" method="GET">
    @csrf
    <button>Reply</button>
</form>



