@extends('layouts.admin_layout')
@section('content')
	@if(isset($message))
		<div id="message">
			<h1>Message #{{ $message->id }}</h1>
			<h3>{{ Crypt::decrypt($message->name) }}</h3>
			<p><b>name</b> : {{ Crypt::decrypt($message->name) }}</p>
			<p><b>subject</b> : {{ Crypt::decrypt($message->subject) }}</p>
			<p><b>email</b> : {{ Crypt::decrypt($message->email) }}</p>
			<p><b>ip</b> : {{ $message->ip }}</p>
			<p>
				<b>text</b> : <br>
				{{ Crypt::decrypt($message->text) }}
			</p>
			{!! Form::open([]) !!}
				<button type="submit" class="btn btn-danger">Delete</button>
			{!! Form::close() !!}
		</div>
	@endif
@stop