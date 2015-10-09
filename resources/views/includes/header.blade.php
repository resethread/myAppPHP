<div id="logo">
	<a href="/"><img src="/assets/img/logo.jpg" alt="logo" width="160" height="90"></a>
</div>

	<form method="GET" action="/search" id="search_bar">
		<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
		<input type="search" placeholder="Search a video here" class="input" id="search-zone" name="search-zone">
		
		<button type="submit" class="button" id="search_btn">Search</button>
	</form>


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



