<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<link rel="stylesheet" href="/assets/css/azpp.css">
		<link rel="stylesheet" href="/assets/css/site.css">
		<link rel="stylesheet" href="/assets/css/bootstrap.css">
		<title>Project</title>
		@if(isset($fullMain))
		<style>
			#sidebar {display: none;}
			#main {width: 98%;}
		</style>
		@endif
		<style>
			.videoOvw {
					display: inline-block;
				width: 200px;
				height: 150px;
				margin: 10px;
				border: 1px solid #777;
				font-size: 0;
				overflow: hidden;
				text-transform: lowercase;
			}

			.ovwTitle {
				font-size: 13px;
				margin: 0 0 0 8px;
				padding: 0;
			}

			.owwNbViews {
				font-size: 11px;
				margin: 0 0 0 8px;
			}
		</style>
	</head>
	<body>
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
				<div class="col-md-1">
					<div class="row">
						<ul class="list-group">
							@for($i = 0; $i < 30; $i++)
								<li class="list-group-item"><a href="/tag/test">Cras justo odio</a></li>
							@endfor
					</ul>
					</div>
				</div>
				<main class="col-md-11" style="min-height: 75vh;">
					@yield('content')
				</main>
			</div>
			<div class="row">
				<footer id="footer">
					@include('includes.footer')
				</footer>
			</div>
		</div>
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
		<div id="central">
			<div id="sidebar">
				<ul id="tagsList">
					@for($i = 0; $i < 20; $i++)
						<li><a href="/tag/voyage">test</a></li>
					@endfor
				</ul>
			</div>
			<main id="main">
				@yield('content')
			</main>
			<div class="clear"></div>
		</div>
		<footer id="footer">
			@include('includes.footer')
		</footer>
		@if(isset($scripts))
			@foreach($scripts as $script)
				<script src="/assets/js/{{ $script }}.js"></script>
			@endforeach
		@endif
		 --}}
	</body>
</html>
