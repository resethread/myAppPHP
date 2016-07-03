@extends('layouts.admin_layout')
@section('content')
<h1 class="page-header">Tags</h1>
<div class="row">
	<div class="col-md-12">
		{!! Form::open(['method' => 'POST', 'class' => 'form-inline']) !!}
			<div class="form-group">
				<input type="text" name="tag" class="form-control"	placeholder="create new tag">
			</div>
			<div class="form-group">
				<button type="submit" class="btn btn-success">Add</button>
			</div>
		{!! Form::close() !!}
	</div>
</div>
<hr>
<?php $letters = range('a', 'z'); ?>
@foreach($letters as $letter)
	<div class="col-md-3">
		{{ $letter }}
	</div>
@endforeach
@stop