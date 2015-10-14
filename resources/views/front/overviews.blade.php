@extends('layouts.public_layout')
@section('content')
	@if(isset($videos))
		@foreach ($videos as $video)
			<div class="videoOvw">
				<a href="/video/{{ $video->id.'/'.$video->slug }}">
					<?php 
						$path = "/users_content/videos/$video->id";

						$random_name = $video->path;
						$random_name = substr($random_name, strrpos($random_name, '/')); 	
						$random_name = ltrim($random_name, '/');

						$real_path = "$path/z_img__$random_name"."001.jpg";
					?>
					<img src="{{ $real_path }}" alt="" width="200" height="100" title="{{ $video->name }}">
				</a>
				<p class="ovwTitle"><a href="/video/{{ $video->id.'/'.$video->slug }}" title="{{ $video->name }}">{{ $video->name }}</a></p>
				<p class="owwNbViews">{{ $video->nb_views }}</p>
			</div>
		@endforeach
	@endif
	@if(isset($videos_by_tag))
		@foreach ($videos_by_tag as $video)
			<div class="videoOvw">
				<a href="/video/{{ $video->id.'/'.$video->slug }}"><img src="http://placehold.it/200x100" alt="" title="{{ $video->name }}"></a>
				<p class="ovwTitle"><a href="/video/{{ $video->id.'/'.$video->slug }}" title="{{ $video->name }}">{{ $video->name }}</a></p>
				<p class="owwNbViews">{{ $video->nb_views }}</p>
			</div>
		@endforeach
	@endif
@stop