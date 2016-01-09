@extends('layouts.admin_layout')
@section('content')
	<h1 class="page-header">Comments</h1>
	<form method="GET" action="/admin/videos-online/search" class="form-inline">
		<input type="search" class="form-control" placeholder="Search comments" style="width: 82%;" id="search-zone" name="search-zone"> 
	
		<button type="submit" class="btn btn-success">Search</button>
	</form>
	@if(isset($comments))
		<table class="table table-striped table-hover ">
			<thead>
				<tr>
					<th>ID</th>
					<th>user name</th>
					<th>Video id</th>
					<th>Content</th>
					<th>Date register</th>
				</tr>
			</thead>
			<tbody>
				@foreach($comments as $comment)
					<tr>
						<td>{{ $comment->id }}</td>
						<td>{{ $comment->user_name }}</td>
						<td>{{ $comment->video_id }}</td>
						<td>{{ $comment->content }}</td>
						<td>{{ date("F j, Y, g:i a",strtotime($comment->created_at)) }}</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	@endif
@stop