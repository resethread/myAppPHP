@extends('layouts.public_layout')
@section('content')

<div class="well col-md-4 col-md-offset-3 col-xs-12">
	<h1 class="text-center">Login</h1>
	<form method="POST" action="/login" id="" class="">
		<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
		
		<div class="form-group">
			<input type="text" class="form-control" name="login" placeholder="Login" tabindex="1">
		</div>

		<div class="form-group">
			<input type="password" class="form-control" name="password" placeholder="Password" tabindex="2">
		</div>

		<div class="form-group">
			<button type="submit" class="btn btn-default btn-block btn-lg" tabindex="3">Send</button>
		</div>
	</form>
</div>
@stop
