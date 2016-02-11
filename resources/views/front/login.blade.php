@extends('layouts.public_layout')
@section('content')

<div class="well col-md-4 col-md-offset-3 col-xs-12">
	<h1 class="text-center">Login</h1>
	<form method="POST" action="/login" id="" class="">
		<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
		
		<div class="form-group">
			<input type="text" class="form-control" name="login" placeholder="Login">
		</div>

		<div class="form-group">
			<input type="password" class="form-control" name="password" placeholder="Password">
		</div>

		<div class="form-group">
			<button type="submit" class="btn btn-default btn-block btn-lg">Send</button>
		</div>
	</form>
</div>
{{-- 
<div class="container-fluid">
	<h1 class="centered">Login</h1>
	<form action="/login" method="POST" id="formLogin" class="form rounded centered">

		<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
		
		<div class="field">
			<label for="login" class="label">Login</label> 
			<input type="text" placeholder="login" name="login" autofocus class="input"> 
		</div>
		
		<div class="field">
			<label for="password" class="label">Password</label>
			<input type="password" placeholder="password" name="password" class="input"> 
		</div>

		<button type="submit" class="button">ok</button>
	</form>
</div>
 --}}
@stop
