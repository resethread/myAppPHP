@extends('layouts.public_layout')
@section('content')

<div class="well col-md-4 col-md-offset-3">
<h1 class="text-center">Create new account</h1>
	<form method="POST" action="/new-account" id="formNewAccount" class="">
		<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />

		<div class="form-group">
			<input type="text" class="form-control" name="name" placeholder="Name">
		</div>
		
		<div class="form-group">
			<input type="email" class="form-control" name="email" placeholder="Email">
		</div>

		<div class="form-group">
			<input type="password" class="form-control" name="password" placeholder="Password">
		</div>

		<div class="form-group">
			<input type="password" class="form-control" name="password_confirmation" placeholder="Password confirmation">
		</div>

		<div class="form-group">
			<input type="checkbox" name="accepted"> I've read and accepted the <a href="/terms-and-conditions">terms and conditions</a>
		</div>

		<div class="form-group">
			<button type="submit" class="btn btn-default btn-block btn-lg">Send</button>
		</div>
	</form>
</div>

{{-- 
<div class="container-fluid">
	<h1 class="centered">Create a new account</h1>
	<form method="POST" action="/new-account" id="formNewAccount" class="form rounded centered">
		
		<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
		
		<div class="field">
			<label for="name" class="label">name</label>
			<input type="text" placeholder="name" name="name" autofocus class="input" id="name" required>
		</div>
		
		<div class="field">
			<label for="email" class="label">email</label>
			<input type="text" placeholder="email" name="email" class="input" id="email" required> 
		</div>
		
		<div class="field">
			<label for="password" class="label">password</label>
			<input type="password" placeholder="password" name="password" class="input" id="password" required>
		</div>
		
		<div class="field">
			<label for="password_confirmation" class="label">password confirmation</label>
			<input type="password" placeholder="password confirmation" name="password_confirmation" class="input" id="password_confirmation" required>
		</div>
		
		<div class="checkbox field">
			<label>
				<input type="checkbox" name="accepted">	I've read and accepted the <a href="/terms-and-conditions">terms and conditions</a>
			</label>
		</div>
		<button type="submit" class="button">send</button>
	</form>
</div>
 --}}
@stop
