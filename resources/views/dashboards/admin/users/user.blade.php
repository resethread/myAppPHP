@extends('layouts.admin_layout')
@section('content')
	<h1 class="header-page">User </h1>
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