@extends ('layout')

@section ('content')
<div id="wrapper">
	<div id="page" class="container">
		<div id="content">
            <h2>Articles</h2>

            <!-- iterate through the list of articles -->
            @foreach ($articles as $article)
                <div class="title">
				<h3><a href="articles/{{ $article->id }}">{{ $article->title }}</a></h3>
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