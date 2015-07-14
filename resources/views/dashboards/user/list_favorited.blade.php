@extends('layouts.user_layout')

@section('content')
	<h1>Favortited</h1>
	
	<table class="table">
		@foreach($favorited as $video)
			<tr>
				
			</tr>
		@endforeach
		<pre>
			{{ var_dump($favorited) }}
		</pre>
	</table>
@stop