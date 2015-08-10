<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<link rel="stylesheet" href="/assets/css/app.css">
		<link rel="stylesheet" href="/assets/css/site.css">
		<title>Project</title>
		@if(isset($fullMain))
		<style>
			#sidebar {display: none;}
			#main {width: 98%;}
		</style>
		@endif
	</head>
	<body>
		<header id="header">
			@include('includes.header')
		</header>
		<div id="sidebar">
			<ul id="tagsList">
				@for($i = 0; $i < 20; $i++)
					<li><a href="/tag/voyage">voyage</a></li>
				@endfor
			</ul>
		</div>
		<main id="main">
			@yield('content')
		</main>
		<div class="clear"></div>
		<footer id="footer" style="{{ str_contains(Request::url(), 'video/') ? 'position:relative;' : 'tata' }}">
			@include('includes.footer')
		</footer>
		<script src="http://code.jquery.com/jquery-2.1.3.min.js"></script>
		@if(isset($scripts))
			@foreach($scripts as $script)
				<script src="/assets/js/{{ $script }}.js"></script>
			@endforeach
		@endif
	</body>
</html>
