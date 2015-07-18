@extends('layouts.admin_layout')
@section('content')
	<h1 class="page-header">Video to validate</h1>
	<h3>{{ $video->name }}</h3>
	<div align="center" class="embed-responsive embed-responsive-16by9">
		<video controls class="embed-responsive-item">
			<source src="{{ $video->path }}.mp4" type="video/mp4">
		</video>
	</div>
	<hr>
	{!! Form::open(['class' => 'form-group well']) !!}
		<legend>Validated ?</legend>
		<select name="validate" class="form-control">
			<option value="yes">YES</option>
			<option value="no">NO</option>
		</select>
		<button autofocus type="submit" class="btn btn-success">GO</button>
	{!! Form::close() !!}
	<hr>
	<h4>Thumbs</h4>
	@for($i = 0; $i <= 15; $i++)
		<img src="{{ $video->path }}-{{ $i }}.jpg" alt="" width="250">
	@endfor
@stop