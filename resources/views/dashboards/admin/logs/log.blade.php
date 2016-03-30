@extends('layouts.admin_layout')
@section('content')
	@if(isset($log))
		<pre>
			{{ $log }}
		</pre>
	@endif
@stop