@extends('layouts.admin_layout')
@section('content')
	<h1 class="page-header">Fast delete</h1>
	
	{!! Form::open(['url' => '/admin/fast-delete/videos'  , 'class' => 'form-group well']) !!}
		<legend>for videos</legend>
		<textarea name="users" class="form-control"></textarea>
		<button type="submit" class="btn btn-danger">DELETE VIDEOS</button> <br>
	{!! Form::close() !!}

	{!! Form::open(['url' => '/admin/fast-delete/users'  , 'class' => 'form-group well']) !!}
		<legend>for users</legend>
		<textarea name="users" class="form-control"></textarea>
		<button type="submit" class="btn btn-danger">DELETE USERS</button> <br>
	{!! Form::close() !!}
@stop