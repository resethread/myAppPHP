@extends('layouts.admin_layout')
@section('content')
	<h1 class="page-header">Videos online</h1>
	<form method="GET" action="/admin/videos-search/" class="form-inline">
		<input type="search" class="form-control" placeholder="Search videos" style="width: 82%;" id="search-zone" name="search-zone"> 
		<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
		<button type="submit" class="btn btn-success">Search</button>
	</form>
	<br>
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
					<td><a href="/video/{{ $video->id }}/{{ $video->slug }}" target="_blank">{{ $video->name }}</a></td>
					<td><a href="/admin/user/{{ $video->user_id }}">{{ $video->user_id }}</a></td>
					<td>{{ $video->duration }}</td>
					<td>{{ date('F j, Y, g:i a', strtotime($video->created_at)) }}</td>
				</tr>
			@endforeach
			</tbody>
		</table>	
	@endif
@stop