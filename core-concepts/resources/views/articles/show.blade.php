@extends ('layout')

@section ('content')
<div id="wrapper">
	<div id="page" class="container">
		<div id="content">
			<div class="title">
				<h2>{{ $article->title }}</h2>
				<span class="byline">{{ $article->excerpt }}</span>
            </div>
            <!-- images/banner.jpg is a realive path -->
            <!-- /images/banner.jpg to start from the root -->
            <!-- could store the path to the thumbnail you want to use (store in the database) -->
			<p><img src="/images/banner.jpg" alt="" class="image image-full" /> </p>
			<p>{{ $article->body }}</p>
			<!-- display tags -->
			<p>
				@foreach ($article->tags as $tag)
					<!-- using hard coded path -->
					<!-- <a href="/articles?tag={{ $tag->name }}">{{ $tag->name }}</a> -->
					<!-- using named routes -->
					<!-- show the route for articles.index -->
					<a href="{{ route('articles.index', ['tag' => $tag->name]) }}">{{ $tag->name }}</a>
				@endforeach
			</p>
		</div>
	</div>
</div>
@endsection