@extends('layouts.admin_layout')
@section('content')
	@if(isset($log))
		{{ $log }}
	@endif
@stop