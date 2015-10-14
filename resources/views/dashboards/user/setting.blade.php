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
	
	@if(isset($avatar_src))
		<img src="{{ $avatar_src }}" alt="avatar" width="50">
	@endif
	{!! Form::open(['url' => '/user/settings/avatar', 'files' => true, 'class' => 'form rounded']) !!}
		<h3>Avatar</h3>
		<div class="field">
			<input type="file" name="avatar" id="avatar" accept="image/jpeg, image/png"> 
		</div>
		<div class="field">
			<button type="submit" class="button">Send new avatar</button>
		</div>
		
	{!! Form::close() !!}

	
	{!! Form::open(['url' => '/user/settings/email', 'class' => 'form rounded']) !!}
		<h3>Change email</h3>
		<div class="field">
			<input type="email" name="email" id="email" class="input" placeholder="email"> 
		</div>
		<div class="field">
			<input type="email" name="email_confirmation" id="email_confirmation" class="input" placeholder="email confirmation">
		</div>
		<div class="field">
			<button type="submit" class="button">Send new email</button>
		</div>
	{!! Form::close() !!}

	
	{!! Form::open(['url' => '/user/settings/password', 'class' => 'form rounded']) !!}
		<h3>Change password</h3>
		<div class="field">
			<input type="password" name="password" id="password" class="input" placeholder="password">
		</div>
		<div class="field">
			<input type="password" name="password_confirmation" id="password_confirmation" class="input" placeholder="password confirmation">
		</div>
		<div class="field">
			<button type="submit" class="button">Send new password</button>
		</div>
	{!! Form::close() !!}
@stop