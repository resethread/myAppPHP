@extends('layouts.public_layout')
@section('content')
	<div class="container">
	<h1 class="centered">Contact</h1>
		
		@if($errors->has())
			<div class="message red">
				<ul>
					@foreach($errors->all() as $error)
						<li>{{ $error }}</li>
					@endforeach
				</ul>
			</div>
		@elseif( Session::has('message_success') )
			<div class="message green">
				{{ Session::get('message_success') }}
			</div>
		@endif

		{!! Form::open(['class' => 'form rounded']) !!}
			
			<div class="field">
				<label for="name" class="label">Name</label>
				<input type="text" placeholder="Your name" name="name" class="input" autofocus>
			</div>

			<div class="field">
				<label for="email" class="label">Email</label> 
				<input type="email" placeholder="Your email" name="email" class="input"> 
			</div>
			
			<div class="field">
				<label for="subject" class="label">Suject</label>
				<select name="subject" id="">
					@foreach($options as $option)
						<option value="{{ str_slug($option, '_') }}">{{ $option }}</option>
					@endforeach
				</select>
			</div>

			<div class="field">
				<label for="text" class="label">Message</label>
				<textarea name="text" rows="10" class="input" placeholder="message"></textarea>
			</div>

			<div class="field">
				<button class="button green	" type="submit">Send message</button>
			</div>

		{!! Form::close() !!}
	</div>
@stop