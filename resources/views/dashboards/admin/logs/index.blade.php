@extends('layouts.admin_layout')
@section('content')
	@if(isset($files))
		<h1 class="page-header">Logs</h1>

		<table class="table">
			<thead>
				<tr>
					<th>Logs</th>
				</tr>
			</thead>
			<tbody>
				@foreach($files as $file)
					<tr>
						<td><a href="/admin/logs/log/{{ $file }}">{{ $file }}</a></td>
					</tr>
				@endforeach
			</tbody>
		</table>

			

	@endif
@stop