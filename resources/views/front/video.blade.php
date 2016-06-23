@extends('layouts.public_layout')
@section('content')
<meta id="token" value="{{ csrf_token() }}"> 
<div class="container-fluid" style="margin-top: 30px;" id="video_tpl">
	<div class="row">
		<div class="col-md-7" id="video_side">
		
			<div class="player embed-responsive embed-responsive-16by9">
				<video id="really-cool-video" class="video-js vjs-default-skin" controls preload="auto" width="640" height="480" poster="" data-setup='{}'>
					<source src="{{ $video->path }}.webm" type="video/webm">
					<source src="{{ $video->path }}.mp4" type="video/mp4">
					old browser...
				</video>
			</div>
			<div id="video_infos">
				<h2 id="bigTitle">{{ $video->name }}</h2>					
			</div>

			<p>{{ $video->nb_views }} views</p>

			<div class="message" v-if="message_response.display" v-text="message_response.message" :class="message_response.status">
			</div>

			<button class="button orange" @click="addFaforite" >Favorite</button>

			<h2>rate this video</h2>	
			
			 <i v-for="i in [1,2,3,4,5]" :data-rate="i" class="fa fa-star rate_star" @click="rateVideo(i)"></i>
 
			<div id="commentZone">
				<h3>Post a comment</h3>	
				
				<form @submit="sendComment">
					<textarea rows="4" class="input" v-model="comment"></textarea>
					<button type="submit" class="button m1_0 olive">Send</button>
				</form>
				
				<div class="message" v-for="comment in comments">
					<a href="#" v-text="comment.user_name"></a>
					<small v-text="comment.created_at"></small> <br>
					<span v-text="comment.content"></span>
				</div>
				
			</div>
		</div>
		<div class="col-md-5" id="suggest_videos_zone">
			<h5>You may like</h5>
			@if(isset($lateral_last_author_public))
				@foreach($lateral_last_author_public as $video)
					<div class="suggested">	
						<div class="suggested_image">
							<a href="{{ $video['link'] }}">
								<img src="{{ $video['img'] }}" class="suggested_img" width="150" height="100">
							</a>
						</div>
						
						<div class="suggested_description">
							<span class="suggested_title">{{ $video['name'] }}</span>
							<span class="suggest_author"><a href="#">{{ $video['user'] }}</a></span>
							<span class="suggested_nb_views">{{ $video['nb_views'] }} views</span>
							<span class="suggested_duration">{{ $video['duration'] }}</span>
						</div>
					</div>		
				@endforeach
			@endif
		</div>
	</div>
</div>
@stop
	
