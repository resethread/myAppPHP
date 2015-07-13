@extends('layouts.user_layout')

@section('content')
	<h1>Your videos</h1>
	<table class="table">
		<thead>
			<th>Overview</th>
			<th>Title</th>
			<th>Views</th>
		</thead>
		<tbody>
			@foreach($videos as $video)
				<tr>
					<td><img src="/users_content/videos/{{ $video->id }}/thumbs/thumb_1.jpg" alt="video overview" width="100"></td>
					<td>{{ $video->name }}</td>
					<td>{{ $video->nb_views }}</td>
				</tr>
			@endforeach
		</tbody>
	</table>
	{!! $videos->render() !!}
@stop