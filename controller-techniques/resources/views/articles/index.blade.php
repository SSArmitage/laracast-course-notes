@extends ('layout')

@section ('content')
<div id="wrapper">
	<div id="page" class="container">
		<div id="content">
            <h2>Articles</h2>

            <!-- iterate through the list of articles -->
            @foreach ($articles as $article)
                <div class="title">
                <!-- using named route here instead of hard coding the path -->
                <!-- this named route still requires a wildcard value, pass this in as the second argument, either explicitly as $article->id OR can just put $article itself and laravel will know to fetch the correct 'id' key name -->
                <!-- $article->path() = route('articles.show') -->
                <!-- route('articles.show') = articles/{{ $article->id }} -->
				<h3><a href="{{ $article->path() }}">{{ $article->title }}</a></h3>
                <!-- images/banner.jpg is a realive path -->
                <!-- /images/banner.jpg to start from the root -->
                <!-- could store the path to the thumbnail you want to use (store in the database) -->
                <p><img src="/images/banner.jpg" alt="" class="image image-full" /> </p>
                <span class="byline">{{ $article->excerpt }}</span>
                </div>
                <!-- no body section, user can click on the link to go to the whole article -->
            @endforeach

		</div>
	</div>
</div>
@endsection