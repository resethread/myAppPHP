<?php 
	$tags = [
		'lorem', 'ipsum', 'dolor', 'sit', 'amet'
	];
	sort($tags);
?>

<ul class="list-group">
	@foreach ($tags as $tag)
		<li class="list-group-item"><a href="/tag/{{ $tag }}">{{ $tag }}</a></li>
	@endforeach	
</ul>