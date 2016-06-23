@extends('layouts.public_layout')
@section('content')
	<!-- if ! pour les tests -->
	@if(!isset($star))
		<div class="col-md-3">
			<img src="http://placehold.it/250x400" class="img-responsive">
		</div>
		<div class="col-md-2">
			<dl>
				<dt>Name: </dt>
				<dd>{{ 'test' }}</dd> <br>
				
				<dt>Country: </dt>
				<dd>{{ 'Groville' }}</dd> <br>

				<dt>H: </dt>
				<dd>170</dd> <br>
			</dl>
		</div>
		<div class="col-md-3">
			<h4>Last videos</h4>
			@for($i = 0; $i < 4; $i++)
				<div class="star_last_videos">
					
				</div>
			@endfor
		</div>
		<div class="col-md-4">
			Lorem ipsum dolor sit amet, consectetur adipisicing elit. Hic cum sunt consectetur minus aliquid assumenda iure consequuntur, neque cumque, laboriosam quia libero inventore minima ab id totam eum officia aliquam!
		</div>
	@endif
@endsection