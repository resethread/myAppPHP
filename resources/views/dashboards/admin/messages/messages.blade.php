@extends('layouts.admin_layout')
@section('content')
	@if(isset($messages))
		<h1 class="page-header">Messages</h1>
		<table class="table">
			<thead>
				<tr>
					<th>id</th>
					<th>name</th>
					<th>email</th>
					<th>subject</th>
					<th>text</th>
					<th>ip</th>
					<th>Delete</th>
				</tr>
			</thead>
			<tbody>
				@foreach($messages as $message)
					<tr>
						<td><a href="/admin/messages/message/{{ $message->id }}">{{ $message->id }}</a></td>
						<td>{{ Crypt::decrypt($message->name) }}</td>
						<td>{{ Crypt::decrypt($message->email) }}</td>
						<td>{{ Crypt::decrypt($message->subject) }}</td>
						<td><a href="/admin/messages/message/{{ $message->id }}">{{ Crypt::decrypt($message->text) }}</a></td>
						<td>{{ $message->ip }}</td>
						<td><i class="fa fa-trash-o"></i></td>
					</tr>
				@endforeach
			</tbody>
		</table>
	@endif
@stop