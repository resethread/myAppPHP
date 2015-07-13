@extends('layouts.user_layout')

@section('content')
	<h1>Favortited</h1>
	
	<table class="table">
		@foreach($favorited as $favorite)
			<tr>
				<td></td>
			</tr>
		@endforeach
	</table>
@stop