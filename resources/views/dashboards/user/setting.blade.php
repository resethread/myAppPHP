@extends('layouts.user_layout')
@section('content')
	<h1>Settings</h1>
	@if (Session::has('message_error'))
		<div class="alert alert-danger">
			{{ Session::get('message_error') }}
		</div>
	@elseif(Session::has('message_success'))
		<div class="alert alert-success">
			{{ Session::get('message_success') }}
		</div>
	@endif
	<h3>Avatar</h3>
	@if(isset($avatar_src))
		<img src="{{ $avatar_src }}" alt="avatar" width="50">
	@endif
	{!! Form::open(['url' => '/user/settings/avatar', 'files' => true]) !!}
		<input type="file" name="avatar" id="avatar" accept="image/jpeg, image/png"> <br>
		<button type="submit" class="button">Send new avatar</button>
	{!! Form::close() !!}
	<hr>
	<h3>Change email</h3>
	{!! Form::open(['url' => '/user/settings/email']) !!}
		<input type="email" name="email" id="email" class="input" placeholder="email"> 
		<input type="email" name="email_confirmation" id="email_confirmation" class="input" placeholder="email confirmation">
		<button type="submit" class="button">Send new email</button>
	{!! Form::close() !!}
	<hr>
	<h3>Change password</h3>
	{!! Form::open(['url' => '/user/settings/password']) !!}
		<input type="password" name="password" id="password" class="input" placeholder="password">
		<input type="password" name="password_confirmation" id="password_confirmation" class="input" placeholder="password confirmation">
		<button type="submit" class="button">Send new password</button>
	{!! Form::close() !!}
@stop