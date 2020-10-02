<!-- layout and structure stored in layout.blase.php, specific content stored in this welcome view file -->
<!-- using blade templating engine, allows you to re-use a layout file -->
<!-- i.e. if you need to insert a script, can put it in the layout file instead of having to put in in every single view -->
<!-- when welcome page is requested, load this view, this view declares its extending the main layout file, next its saying for the main content section insert the div... -->

@extends ('layout')

@section ('header')
    <div id="header-featured">
		<div id="banner-wrapper">
			<div id="banner" class="container">
				<h2>Maecenas luctus lectus</h2>
				<p>This is <strong>SimpleWork</strong>, a free, fully standards-compliant CSS template designed by <a href="http://templated.co" rel="nofollow">TEMPLATED</a>. The photos in this template are from <a href="http://fotogrph.com/"> Fotogrph</a>. This free template is released under the <a href="http://templated.co/license">Creative Commons Attribution</a> license, so you're pretty much free to do whatever you want with it (even use it commercially) provided you give us credit for it. Have fun :) </p>
                <a href="#" class="button">Etiam posuere</a> 
            </div>
		</div>
	</div>
@endsection
