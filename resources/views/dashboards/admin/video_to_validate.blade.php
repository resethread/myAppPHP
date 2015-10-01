@extends('layouts.admin_layout')
@section('content')
	<h1 class="page-header">Video to validate</h1>
	<h3>{{ $video->name }}</h3>
	<div align="center" class="embed-responsive embed-responsive-16by9">
		<video controls class="embed-responsive-item">
			<source src="{{ $video->path }}.mp4" type="video/mp4">
			<source src="{{ $video->path }}.webm" type="video/webm">
		</video>
	</div>
	<hr>
	<div class="well">
		<div class="row">
			<div class="col-md-3">
				{!! Form::open(['url' => "admin/create-thumbnails/$video->id",'class' => 'form-inline']) !!}
				<button type="submit" class="btn btn-info" id="btn_create_thumbnails">Create Thumbnails</button>
				{!! Form::close() !!}
			</div>
			<div class="col-md-3">
				{!! Form::open(['url' => "admin/convert-formats/$video->id",'class' => 'form-inline']) !!}
				<button type="submit" class="btn btn-primary" id="btn_create_thumbnails">Convert formats</button>
				{!! Form::close() !!}
			</div>
			<div class="col-md-6">
				{!! Form::open(['class' => 'form-inline']) !!}
					<label for="">Validated ?</label>
					<select name="validate" class="form-control">
						<option value="maybe">MAYBE</option>
						<option value="yes">YES</option>
						<option value="no">NO</option>
					</select>
					<button autofocus type="submit" class="btn btn-success">GO</button>
				{!! Form::close() !!}
			</div>
		</div>
	</div>
	
	<hr>
	<h4>Thumbs</h4>
	@for($i = 0; $i <= 14; $i++)
		<img src="/users_content/videos/1/z_img_toto00{{ $i }}.jpg" alt="" width="250">
	@endfor
@stop