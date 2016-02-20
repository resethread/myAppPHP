@extends('layouts.admin_layout')
@section('content')
	@if(isset($video))
		<h1 class="page-header">Edit video</h1>
		<div class="row">
			<div class="col-md-4">
				
				{!! Form::open() !!}
					<div class="form-group">
						<label for="">Name</label>
						<input type="text" class="form-control" name="name" value="{{ $video->name }}">
					</div>
					<div class="form-group">
						<label for="">Tags</label>
						<textarea rows="3" class="form-control" name="tags" value=""></textarea>
					</div>
					<div class="form-group">
						<label for="">Stars</label>
						<input type="text" class="form-control" name="stars" value="">
					</div>
					<div class="form-group">
						<button class="btn btn-success">Update</button>
					</div>
				{!! Form::close() !!}
			</div>
			<div class="col-md-8">
				<video controls>
					<source src="{{ $video->path }}.webm" type="video/webm">
					<source src="{{ $video->path }}.mp4" type="video/mp4">
				</video>
			</div>
		</div>
	@endif
@stop