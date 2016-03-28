@extends('layouts.admin_layout')
@section('content')
	<h1 class="page-header">Fast delete</h1>
	
	{!! Form::open(['url' => '/admin/fast-delete/videos'  , 'class' => 'form-group well']) !!}
		<legend>Videos</legend>
		<textarea name="elements" class="form-control"></textarea>
		<button type="submit" class="btn btn-danger">DELETE VIDEOS</button> <br>
	{!! Form::close() !!}

	{!! Form::open(['url' => '/admin/fast-delete/users'  , 'class' => 'form-group well']) !!}
		<legend>Users</legend>
		<textarea name="elements" class="form-control"></textarea>
		<button type="submit" class="btn btn-danger">DELETE USERS</button> <br>
	{!! Form::close() !!}

	{!! Form::open(['url' => '/admin/fast-delete/comments'  , 'class' => 'form-group well']) !!}
		<legend>Comments</legend>
		<textarea name="elements" class="form-control"></textarea>
		<button type="submit" class="btn btn-danger">DELETE COMMENTS</button> <br>
	{!! Form::close() !!}
@stop