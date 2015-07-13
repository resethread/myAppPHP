@extends('layouts.public_layout')
@section('content')
<div class="container-fluid">
	<h1>Create a new account</h1>
	<form method="POST" action="/new-account" id="formNewAccount" class="rounded_form">
		
		<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
		
		<div class="form-group">
			<label for="name" class="label">name</label>
			<input type="text" placeholder="name" name="name" autofocus class="input" id="name" required>
		</div>
		
		<div class="form-group">
			<label for="email" class="label">email</label>
			<input type="text" placeholder="email" name="email" class="input" id="email" required> 
		</div>
		
		<div class="form-group">
			<label for="password" class="label">password</label>
			<input type="password" placeholder="password" name="password" class="input" id="password" required>
		</div>
		
		<div class="form-group">
			<label for="password_confirmation" class="label">password confirmation</label>
			<input type="password" placeholder="password confirmation" name="password_confirmation" class="input" id="password_confirmation" required>
		</div>
		
		<div class="checkbox">
			<label>
				<input type="checkbox" name="accepted">	I've read and accepted the <a href="/terms-and-conditions">terms and conditions</a>
			</label>
		</div>
		<button type="submit" class="button">send</button>
	</form>
</div>
@stop
