<div id="logo">
	<a href="/"><img src="/assets/img/logo.jpg" alt="logo" width="160" height="90"></a>
</div>
<div id="search">
	<form method="GET" action="/search">
		<input type="search" placeholder="Search a video here" class="input" id="search-zone" name="search-zone">
		<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
		<button type="submit" class="button" id="search_btn">Search</button>
	</form>
</div>

<div id="btn-space">
	@if(Auth::guest())
		<div class="button green"><a href="/new-account">Upload videos now</a></div>
		<div class="button blue"><a href="/login">Register</a></div>
		<div class="button "><a href="/login">Login</a></div>
	@else
		<div class="button"><a href="/user">{{ Auth::user()->name }}</a></div>
		<div class="button"><a href="/logout">Logout</a></div>
	@endif
</div>

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

