@extends('layouts.admin_layout')
@section('content')
	<h1 class="page-header">Videos to validate</h1>
	@if(isset($videos))
		<table class="table table-striped table-hover ">
			<thead>
				<tr>
					<th>ID</th>
					<th>Name</th>
					<th>user_id</th>
					<th>duration</th>
					<th>date uploaded</th>
				</tr>
			</thead>
			<tbody>
			@foreach($videos as $video)
				<tr>
					<td>{{ $video->id }}</td>
					<td><a href="/admin/video-to-validate/{{ $video->id }}">{{ $video->name }}</a></td>
					<td><a href="/admin/user/{{ $video->user_id }}">{{ $video->user_id }}</a></td>
					<td>{{ $video->duration }}</td>
					<td>{{ date('F j, Y, g:i a', strtotime($video->created_at)) }}</td>
				</tr>
			@endforeach
			</tbody>
		</table>	
	@endif
@stop