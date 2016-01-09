@extends('layouts.admin_layout')
@section('content')
	@if(isset($logs))
		<h1 class="page-header">Logs</h1>
		{{ $logs }}
	@endif
@stop