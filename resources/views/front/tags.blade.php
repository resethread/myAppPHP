@extends('layouts.public_layout')
@section('content')

	

	@foreach($tags as $tag)
		<div class="tags_list">
			{{ $tag->name }}
		</div>
	@endforeach 
@endsection