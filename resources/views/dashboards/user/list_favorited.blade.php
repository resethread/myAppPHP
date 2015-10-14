@extends('layouts.user_layout')

@section('content')
	<h1>Favortited</h1>
	
	<table class="table">
		@foreach($videos as $video)
			<tr>
				<td><a href="/video/{{ $video->id }}/{{ $video->slug }}"><img src="/users_content/videos/{{ $video->id }}/thumbs/thumb_1.jpg" alt="" width="100"></a></td>
				<td>{{ $video->name }} <br>
					{{ $video->nb_comments }} comments	<br>
					{{ $video->nb_views }} views
	
				</td>
				<td>
					{!! Form::open(['url' => '/user/delete-favorite/'.$video->id, 'method' => 'POST']) !!}
						<input type="submit" value="Delete" class="button red mini">
					{!! Form::close() !!}
				</td>
			</tr>
		@endforeach
	</table>
@stop