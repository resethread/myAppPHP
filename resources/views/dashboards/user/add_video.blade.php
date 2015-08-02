@extends('layouts.user_layout')
@section('content')
<link rel="stylesheet" href="https://rawgit.com/enyo/dropzone/master/dist/dropzone.css">
<style>
	#form-add-video {
		text-align: center;
		border: 3px dashed #999;
		border-radius: 4px;
	}

	.drop_empty {}
	.drop_novalid {border: 3px dashed #f00;}
	.drop_valid {border: 3px dashed #0f0;}
	

	.btn_tag {
		border: 1px solid #aaa;
		padding: 1px 6px;
		background: #c9c9c9;
		display: inline-block;
		cursor: pointer;
	}

	.tagged {
		background: #B5CACE;
	}
</style>
<h1 class="text-center">UPLOAD VIDEO HERE </h1>
@if(Session::has('message_success'))
	<div class="alert alert-success">
		{{ Session::get('message_success') }}
	</div>
@elseif(Session::has('message_error'))
	<div class="alert alert-danger">
		{{ Session::get('message_error') }}
	</div>
@endif
	{!! Form::open(['method' => 'POST', 'files' => true]) !!}
	<div class="fallback">				
		<input type="file" id="file" name="file" accept="video/*" style="">
		<button type="submit">OK</button>
	</div>
	{!! Form::close() !!}
<hr>
<div class="progress">
	<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="" id="progress_bar">
	</div>
</div>
<div id="progress_precent"></div>	

<button id="btn" class="button">click</button>
@stop
