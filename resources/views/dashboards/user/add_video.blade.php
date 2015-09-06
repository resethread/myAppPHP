@extends('layouts.user_layout')
@section('content')
<link rel="stylesheet" href="/assets/css/dropzone.css">
<style>
	#classic_form_upload {
		display: none;
	}

	#my-awesome-dropzone {
		width: 300px;
		height: 100px;
		border: 3px dashed #ccc;
		border-radius: 7px;
		background: #f3f3f3;

		margin-bottom: 8em;
	}
</style>
	<h1 class="text-center">UPLOAD VIDEO HERE </h1>
	@if(Session::has('message_success'))
		<div class="message green">
			{{ Session::get('message_success') }}
		</div>
	@elseif(Session::has('message_error'))
		<div class="message red">
			{{ Session::get('message_error') }}
		</div>
	@endif

	

	<form action="/user/add-video" class="dropzone" id="my-awesome-dropzone" enctype="multipart/form-data">
		<input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
		<div class="fallback">
			<input name="file" type="file" />
		</div>
		<div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress></span></div>
	</form>

	<span id="progress"></span>
	<div class="progress_bar">
		<div class="bar" id="bar" style="width:0">
			
		</div>
	</div>
	
	If you meet trouble to upload your files with the drag and drop system, you can use the <a href="#" id="to_classic_form">classic form</a> <br>

	{!! Form::open(['method' => 'POST', 'files' => true, 'id' => 'classic_form_upload']) !!}
	<div class="fallback">				
		<input type="file" id="file" name="file" accept="video/*" style="">
		<button type="submit" class="button blue">Upload</button>
	</div>
	{!! Form::close() !!}
@stop
