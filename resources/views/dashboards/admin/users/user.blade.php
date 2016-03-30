@extends('layouts.admin_layout')
@section('content')
	<h1 class="header-page">User </h1>
	<form method="GET" action="/admin/users/search" class="form-inline">
		<input type="search" class="form-control" placeholder="Search users" style="width: 82%;" id="search-zone" name="search-zone"> 
	
		<button type="submit" class="btn btn-success">Search</button>
	</form>
	@if(isset($user))
		<table class="table table-striped table-hover ">
			<thead>
				<tr>
					<th>ID</th>
					<th>Name</th>
					<th>IP</th>
					<th>Status</th>
					<th>Banned</th>
					<th>Date register</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>{{ $user->id }}</td>
					<td>{{ $user->name }}</td>
					<td>{{ $user->ip }}</td>
					<td>{{ $user->status }}</td>
					<td>{{ $user->banned }}</td>
					<td>{{ $user->created_at }}</td>
				</tr>
			</tbody>
		</table>
	@endif
@stop