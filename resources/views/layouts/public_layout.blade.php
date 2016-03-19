<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<link rel="stylesheet" href="/assets/css/app.css">
		<link rel="stylesheet" href="/assets/css/site.css">
		<link rel="stylesheet" href="/assets/css/bootstrap.css">
		<title>Project</title>
		@if(isset($fullMain))
		<style>
			#sidebar {display: none;}
			#main {width: 98%;}
		</style>
		@endif
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
				<div class="col-md-1 visible-lg visible-md">
					<div class="row" id="categories_side">
						<ul class="list-group">
							@for($i = 0; $i < 30; $i++)
								<li class="list-group-item"><a href="/tag/test">Cras justo odio</a></li>
							@endfor
						</ul>
					</div>
				</div>
				<div class="col-sm-12 visible-sm visible-xs">
					<h3>Categories</h3>
					<select class="form-control" style="margin-bottom: 20px;">
						<option value="z">a</option>
						<option value="z">a</option>
						<option value="z">a</option>
						<option value="z">a</option>
					</select>
				</div>
				<main class="col-md-11 col-sm-12" style="min-height: 75vh;">
					@yield('content')
				</main>
			</div>
			<div class="row">
				<footer id="footer">
					@include('includes.footer')
				</footer>
			</div>
		</div>

		@if(isset($scripts))
			@foreach($scripts as $script)
				<script src="/assets/js/{{ $script }}.js"></script>
			@endforeach
		@endif
	</body>
</html>
