@extends('layouts.user_layout')
@section('content')
	<h1 class="text-center">Your videos</h1>
	<table class="table">
		<thead>
			<th>Overview</th>
			<th>Title</th>
			<th>Views</th>
		</thead>
		<tbody>
			@foreach($videos as $video)
				<tr>
					<td>
						<?php
							chdir(public_path("users_content/videos/$video->id"));
							$path = getcwd();
							$files = scandir($path);
							$src_img = $files[3];
						?>
						<img src="{{ "/users_content/videos/$video->id/$src_img" }}" alt="" width="100">
					</td>
					<td>{{ $video->name }}</td>
					<td>{{ $video->nb_views }}</td>
					<td><a href="/user/edit-video/{{ $video->id }}">Edit</a></td>
					<td>
						{!! Form::open(['url' => '/user/delete-video/'.$video->id, 'method' => 'POST']) !!}
							<input type="submit" class="button mini red" value="Delete">
						{!! Form::close() !!}
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>
@stop