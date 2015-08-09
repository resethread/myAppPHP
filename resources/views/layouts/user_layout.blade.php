<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<link rel="stylesheet" href="/assets/css/app.css">
		<link rel="stylesheet" href="/assets/css/site.css">
		<title>App</title>
	</head>
	<body>
		<header id="header">
			@include('includes.header')
		</header>
		
		<div class="cotnainer-fluid">
			<div class="row">
				<div class="col-md-2" id="user_sidebar">
					<ul>
						<li><a href="/user">{{ Auth::user()->name }}</a></li>
						<li><a href="/user/videos">Videos</a></li>
						<li><a href="/user/favorites">Favorites</a></li>
						<li><a href="/user/comments">Comments</a></li>
						<li><a href="/user/settings">Setting</a></li>
					</ul>
				</div>
				<div class="col-md-10" id="main_user">
					@yield('content')
				</div>
			</div>
		</div>
		<footer id="footer">
			@include('includes.footer')
		</footer>
		<script src="http://code.jquery.com/jquery-1.11.2.min.js"></script>
		@if (isset($scripts))
			@foreach($scripts as $script)	
				<script src="/assets/js/{{ $script }}.js"></script>
			@endforeach
		@endif
	</body>
</html>