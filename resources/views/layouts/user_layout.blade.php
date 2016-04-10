<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<link rel="stylesheet" href="/assets/css/bootstrap.css">
		<link rel="stylesheet" href="/assets/css/site.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
		<title>App</title>
	</head>
	<body>
		<style>
		i {
			margin-right: 0.9em;
		}
		</style>
		<div class="container-fluid" style="margin-top: 20px;">
			<div class="row" id="header">
				@include('includes.header')
			</div>
			<div class="row">
				<nav id="navTop">
					<ul>
						<li><a href="/news-videos">news videos</a></li>
						<li><a href="/most-viewed">most viewed</a></li>
						<li><a href="/top-rated">top rated</a></li>
						<li><a href="/most-favorited">most favorited</a></li>
						<li><a href="/most-commented">most commented</a></li>
						<li><a href="/tags">tags</a></li>
						<li><a href="/random">random</a></li>
						<li><a href="/stars">stars</a></li>
						<li><a href="/channels">channels</a></li>
					</ul>
				</nav>
			</div>
			<div class="row">
				<div class="col-md-2">
					<div class="row">
						<div class="list-group">
							<a href="/account" class="list-group-item"><i class="fa fa-user"></i> {{ Auth::user()->name }}</a>
							<a href="/account/videos" class="list-group-item"><i class="fa fa-video-camera"></i> Videos</a>
							<a href="/account/favorites" class="list-group-item"><i class="fa fa-heart"></i> Favorites</a>
							<a href="/account/settings" class="list-group-item"><i class="fa fa-gear"></i> Setting</a>
						</div>
					</div>
				</div>
				<div class="col-md-10" style="min-height: 75vh;">
					@yield('content')
				</div>
			</div>
		</div>
		<footer id="footer">
			@include('includes.footer')
		</footer>

		{{-- 
		<header id="header">
			@include('includes.header')
		</header>
		<nav id="navTop">
			<ul>
				<li><a href="/news-videos">news videos</a></li>
				<li><a href="/most-viewed">most viewed</a></li>
				<li><a href="/top-rated">top rated</a></li>
				<li><a href="/most-favorited">most favorited</a></li>
				<li><a href="/most-commented">most commented</a></li>
				<li><a href="/tags">tags</a></li>
				<li><a href="/random">random</a></li>
				<li><a href="/stars">stars</a></li>
				<li><a href="/channels">channels</a></li>
			</ul>
		</nav>
		<div class="cotnainer-fluid" style="min-height: 75vh;">
			<div class="row">
				<div class="col-md-2" id="user_sidebar">
					<ul>
						<li><a href="/user">{{ Auth::user()->name }}</a></li>
						<li><a href="/user/videos">Videos</a></li>
						<li><a href="/user/favorites">Favorites</a></li>
						<li><a href="/user/settings">Setting</a></li>
					</ul>
				</div>
				<div class="col-md-9" id="main_user">
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
		 --}}
	</body>
</html>