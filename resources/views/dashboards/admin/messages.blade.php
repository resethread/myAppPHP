@extends('layouts.admin_layout')
@section('content')
	@if(isset($messages))
		<table class="table">
			<thead>
				<tr>
					<th>id</th>
					<th>name</th>
					<th>email</th>
					<th>subject</th>
					<th>text</th>
					<th>ip</th>
				</tr>
			</thead>
			<tbody>
				@foreach($messages as $message)
					<tr>
						<td><a href="/admin/message/{{ $message->id }}">{{ $message->id }}</a></td>
						<td>{{ Crypt::decrypt($message->name) }}</td>
						<td>{{ Crypt::decrypt($message->email) }}</td>
						<td>{{ Crypt::decrypt($message->subject) }}</td>
						<td>{{ Crypt::decrypt($message->text) }}</td>
						<td>{{ $message->ip }}</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	@endif
@stop