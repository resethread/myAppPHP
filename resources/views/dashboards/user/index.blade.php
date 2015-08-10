@extends('layouts.user_layout')
@section('content')

	@if(Session::has('message_success'))
		<div class="alert alert-success">
			{{ Session::get('message_success') }}
		</div>
	@elseif(Session::has('message_error'))
		<div class="alert alert error">
			{{ Session::get('message_error') }}
		</div>	
	@endif

	<div class="add">
		<a href="/user/add-video">Add Video</a>
	</div>
	<hr>
	<h2>Last videos</h2>
	<table class="table">
		<thead>
			<th>Overview</th>
			<th>Informations</th>
			<th>Edit</th>
			<th>Delete</th>
		</thead>
		<tbody>
		@forelse($last_videos as $video) 
			<tr>
				<td><a href="/video/{{ $video->id }}/{{ $video->slug }}"><img src="{{ $video->path }}-3.jpg" alt="" width="100"></a></td>
				<td>{{ $video->name }} <br>
					{{ $video->nb_comments }} comments	<br>
					{{ $video->nb_views }} views
	
				</td>
				<td><a href="/user/edit-video/{{ $video->id }}" class="button mini blue">Edit</a></td>
				<td>
					{!! Form::open(['url' => '/user/delete-video/'.$video->id, 'method' => 'POST']) !!}
						<input type="submit" class="button mini red" value="Delete">
					{!! Form::close() !!}
				</td>
			</tr>
		@empty
			<tr>
				<td>No video yet &nbsp; <a href="/user/add-video">Upload video</a></td>
			</tr>	
		@endforelse
		</tbody>
	</table>
	<hr>
	<h2>Last favorited</h2>
	<table class="table">
		<thead>
			<tr>
				<th></th>
				<th>Name</th>
			</tr>
		</thead>
		<tbody>
			{{-- 
				<tr>
					<td><a href="/video/{{ $video->id }}/{{ $video->slug }}"><img src="/users_content/videos/{{ $video->id }}/thumbs/thumb_1.jpg" alt="" width="100"></a></td>
					<td>{{ $video->name }}</td>
				</tr>
	
			 --}}
		</tbody>
	</table>

@stop

