@extends('layouts.public_layout')
@section('content')
<link href="//vjs.zencdn.net/4.12/video-js.css" rel="stylesheet">
<div class="container-fluid">
	<div class="row">
		<div class="col-md-9" id="video_side">
			
			<div class="player">
				<video id="really-cool-video" class="video-js vjs-default-skin" controls preload="auto" width="640" height="480" poster="<?= "/users_content/videos/$video->id/thumbs/thumb_2.jpg" ?>" data-setup='{}'>
					<source src="{{ $video->path }}.mp4" type="video/mp4">
					
					old browser...
				</video>
				
				<div id="video_infos">
					<h2 id="bigTitle">{{ $video->name }}</h2>

					
				</div>
			</div>
			<p>{{ $video->nb_views }} views</p>
			@if (Auth::check())
				<form action="/add-favorite/{{ Auth::user()->id }}/{{ $video->id }}" method="POST">
					<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
					<button type="submit" class="button">Favorite</button>
				</form>
			@else
				<form action="/add-favorite/guest/guest" method="POST">
					<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
					<button type="submit" class="button">Favorite</button>
				</form>
			@endif
				
			<h2>rate this video</h2>	
			
			@if(Auth::check())
				{!! Form::open(['url' => '/rate-video/'.Auth::user()->id.'/'.$video->id, 'id' => 'rate_form']) !!}
					<input type="hidden" value="" name="rate" id="rate">
					@for($i = 1; $i <=5; $i++)
						<img src="/assets/img/star.png" alt="{{ $i }}" width="20" id="rate_{{ $i }}" class="rate_star">
					@endfor
				{!! Form::close() !!}
			@else
				{!! Form::open(['url' => '#', 'id' => 'rate_form']) !!}
					@for($i = 1; $i <=5; $i++)
						<img src="/assets/img/star.png" alt="{{ $i }}" width="20" id="rate_{{ $i }}" class="rate_star">
					@endfor
				{!! Form::close() !!}
			@endif
			
			<div class="message green">
				Ceci est un message de success ou d'avertissement : lorem ipsum
			</div>
			@if(Session::has('message_error'))
				<div class="message red">
					{{ Session::get('message_error') }}
				</div>
			@elseif(Session::has('message_success'))
				<div class="message green">
					{{ Session::get('message_success') }}
				</div>	
			@endif
			<hr>
			<div id="commentZone">
				<h3>Post a comment</h3>	
				<form action="/video/{{ $video->id }}/{{ $video->slug }}" method="POST" id="form_comment" class="">
					<textarea name="content" id="content" cols="30" rows="4" class="input"></textarea>
					<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
					<button type="submit" class="button">Send</button>
				</form>
				<hr>
				@if(isset($comments))
					@forelse($comments as $comment)
						<div class="commentUser"> 
							<a href="/channel/{{ str_slug($comment->user_name) }}">{{ $comment->user_name }}</a> {{ date("F j, Y, g:i a",strtotime($comment->created_at)) }} <br>
							{{ $comment->content }}
						</div>
						<hr>
					@empty
						No comment yet	
					@endforelse
				@endif
			</div>
		</div>
		<div class="col-md-3" id="suggest_videos_zone">
			<h5>You may like</h5>
				@if(isset($lateral_last_author_public))
					@foreach($lateral_last_author_public as $author_video)
						<div class="suggested">	
							<a href="{{ $author_video['link'] }}">
								<img src="{{ $author_video['img'] }}" class="suggested_img" width="150" height="100">
							</a>
							
							<div class="suggested_desciption">
								<span class="suggested_title">{{ $author_video['name'] }}</span>
								<span class="suggest_author"><a href="#">{{ $author_video['user'] }}</a></span>
								<span class="suggested_nb_views">{{ $author_video['nb_views'] }} views</span>
								<span class="suggested_duration">{{ $author_video['duration'] }}</span>
							</div>
						</div>		
					@endforeach
				@endif

				@if(isset($tags_videos))
					@foreach($tags_videos as $tags_video)
						
					@endforeach
				@endif

				@if(isset($random_videos))
					@foreach($random_videos as $random_video)

					@endforeach
				@endif
			
		</div>
	</div>
</div>
<script src="//vjs.zencdn.net/4.12/video.js"></script>

@stop
	
