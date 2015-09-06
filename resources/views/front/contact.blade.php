@extends('layouts.public_layout')
@section('content')
	<div class="container">
	<h1 class="centered">Contact</h1>
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
				<label for="Suject" class="label">Suject</label>
				<select name="suject" id="">
					@foreach($options as $option)
						<option value="{{ str_slug($option, '_') }}">{{ $option }}</option>
					@endforeach
				</select>
			</div>

			<div class="field">
				<label for="message" class="label">Message</label>
				<textarea name="message" rows="10" class="input" placeholder="message"></textarea>
			</div>

			<div class="field">
				<button class="button green	" type="submit">Send message</button>
			</div>

		{!! Form::close() !!}
	</div>
@stop