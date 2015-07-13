@extends('layouts.public_layout')
@section('content')
<div class="container-fluid">
	<h1>Login</h1>
	<form action="/login" method="POST" id="formLogin" class="rounded_form">

		<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
		
		<div class="form-group">
			<label for="login" class="label">Login</label> 
			<input type="text" placeholder="login" name="login" autofocus class="input"> 
		</div>
		
		<div class="form-group">
			<label for="password" class="label">Password</label>
			<input type="password" placeholder="password" name="password" class="input"> 
		</div>

		<button type="submit" class="button">ok</button>
	</form>
</div>
@stop
