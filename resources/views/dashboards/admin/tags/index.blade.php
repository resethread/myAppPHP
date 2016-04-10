@extends('layouts.admin_layout')
@section('content')
<h1 class="page-header">Tags</h1>
<?php $letters = range('a', 'z'); ?>

@foreach($letters as $letter)
	<div class="col-md-3">
		{{ $letter }}
	</div>
@endforeach
@stop