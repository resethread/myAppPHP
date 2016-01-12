@extends('layouts.admin_layout')
@section('content')
	<h1 class="page-header">Users</h1>
	<form method="GET" action="/admin/users-search" class="form-inline">
		<input type="search" class="form-control" placeholder="Search users" style="width: 82%;" id="search-zone" name="search-zone"> 
	
		<button type="submit" class="btn btn-success">Search</button>
	</form>
	@if(isset($users))
		<table class="table table-striped table-hover ">
			<thead>
				<tr>
					<th>ID</th>
					<th>Name</th>
					<th>Email</th>
					<th>Banned</th>
					<th>Date register</th>
				</tr>
			</thead>
			<tbody>
			@foreach($users as $user)
				<tr>
					<td>{{ $user->id }}</td>
					<td><a href="/admin/user/{{ $user->id }}">{{ $user->name }}</a></td>
					<td>{{ $user->email }}</td>			
					<td>{{ $user->banned }}</td>				
					<td>{{ $user->created_at }}</td>
				</tr>
			@endforeach
			</tbody>
		</table>	
	@endif
@stop