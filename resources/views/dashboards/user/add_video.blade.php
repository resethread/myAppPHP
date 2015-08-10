@extends('layouts.user_layout')
@section('content')
<link rel="stylesheet" href="/assets/css/dropzone.css">
<style>

</style>
	<h1 class="text-center">UPLOAD VIDEO HERE </h1>
	@if(Session::has('message_success'))
		<div class="message green">
			{{ Session::get('message_success') }}
		</div>
	@elseif(Session::has('message_error'))
		<div class="message red">
			{{ Session::get('message_error') }}
		</div>
	@endif
	{!! Form::open(['method' => 'POST', 'files' => true]) !!}
	<div class="fallback">				
		<input type="file" id="file" name="file" accept="video/*" style="">
		<button type="submit" class="button blue">OK</button>
	</div>
	{!! Form::close() !!}

@stop
