<?php 
	$tags = [
		'lorem', 'ipsum', 'anime', 'sit', 'amet', 'dolor'
	];
	sort($tags);
?>

<div class="list-group">
	@foreach ($tags as $tag)
		<a href="/tag/{{ $tag }}" class="list-group-item">{{ $tag }}</a>
	@endforeach	
</div>