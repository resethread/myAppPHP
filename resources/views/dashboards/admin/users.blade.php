@extends('layouts.admin_layout')
@section('content')
	<h1 class="page-header">Users</h1>
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