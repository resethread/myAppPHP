@extends('layouts.public_layout')
@section('content')
	@if(isset($channels))
		@foreach($channels as $chan)

		@endforeach
	@endif
@stop