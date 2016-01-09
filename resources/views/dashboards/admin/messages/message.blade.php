@extends('layouts.admin_layout')
@section('content')
	@if(isset($message))
		<h1>Messages</h1>
		<p><b>name</b>: {{ Crypt::decrypt($message->name) }}</p>
		<p><b>email</b>: {{ Crypt::decrypt($message->email) }}</p>
		<p><b>subject</b>: {{ Crypt::decrypt($message->subject) }}</p>
		<p><b>text</b>: {{ Crypt::decrypt($message->text) }}</p>
		<hr>
		{!! Form::open() !!}
			<button type="submit" class="btn btn-danger">Delete</button>
		{!! Form::close() !!}
	@endif
@stop