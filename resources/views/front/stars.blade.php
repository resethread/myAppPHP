@extends('layouts.public_layout')
@section('content')


	<div class="search_custom">
		<?php $letters = range('a', 'z'); ?>
		{!! Form::open() !!}
			@foreach($letters as $letter)
				<a href="/stars/{{ $letter }}">{{ strtoupper($letter) }}</a>
			@endforeach
			<input type="text" class="input">
		{!! Form::close() !!}
		<hr>
	</div>
	@if(isset($videos))
		@foreach ($videos as $video)
			<div class="videoOvw">
				<a href="/video/{{ $video->id.'/'.$video->slug }}"><img src="{{ $video->path }}-0.jpg" alt="" width="200" height="100" title="{{ $video->name }}"></a>
				<p class="ovwTitle"><a href="/video/{{ $video->id.'/'.$video->slug }}" title="{{ $video->name }}">{{ $video->name }}</a></p>
				<p class="owwNbViews">{{ $video->nb_views }}</p>
			</div>
		@endforeach
	@endif

@stop