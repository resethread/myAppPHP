<div class="col-md-2" id="logo">
	<a href="/"><img src="/assets/img/logo.jpg" alt="logo" width="160" height="90"></a>
</div>
<div class="col-md-6">
	<form method="GET" action="/search" id="">
		<div class="input-group">
			<input type="text" class="form-control" placeholder="Search video" aria-describedby="basic-addon1">
			<span class="input-group-addon" id="basic-addon1">Go</span>
		</div>
	</form>
</div>
<div class="col-md-4">
	@if(Auth::guest())
		<a class="btn btn-success">Upload video</a>
		<a href="/new-account" class="btn btn-info">New account</a>
		<a href="/login" class="btn btn-link">Login</a>
	@else
		<a class="btn btn-success">Upload video</a>
		<a href="/account" class="btn btn-info">{{ Auth::user()->name }}</a>
		<a href="/logout" class="btn btn-danger">logout</a>
	@endif
</div>