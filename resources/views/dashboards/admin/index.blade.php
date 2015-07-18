@extends('layouts.admin_layout')
@section('content')
	<h1 class="page-header">Welcome administrator</h1>
	<div class="row">
		<div class="btn-group btn-group-justified">
			<a href="/admin/videos-to-validate" class="btn btn-default btn-info"><strong>120</strong> <br>news videos</a>
			<a href="/admin/users" class="btn btn-default btn-primary"><strong>80</strong> <br>news users</a>
			<a href="" class="btn btn-default btn-danger"><strong>80</strong> <br>comments reported</a>
		</div>
	</div>
@stop