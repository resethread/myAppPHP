@extends('layouts.public_layout')
@section('content')
	
		
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
	<div class="well col-md-4 col-md-offset-3 col-xs-12">
		<h1 class="text-center">Contact</h1>
		<form action="/contact" method="POST">
			<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />

			<div class="form-group">
				<input type="text" placeholder="Your name" name="name" class="form-control" autofocus>
			</div>

			<div class="form-group">
				<input type="email" placeholder="Your email" name="email" class="form-control"> 
			</div>

			<div class="form-group">
				<label for="subject">Subject</label>
				<select name="subject" class="form-control">
					@foreach($options as $option)
						<option value="{{ str_slug($option, '_') }}">{{ $option }}</option>
					@endforeach
				</select>
			</div>

			<div class="form-group">
				<textarea name="text" rows="10" class="form-control" placeholder="Your message"></textarea>
			</div>

			<div class="form-group">
				<button type="submit" class="btn btn-default btn-lg btn-block">Send</button>
			</div>
			{{-- 
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
			 --}}
		</form>
	</div>
	
@stop