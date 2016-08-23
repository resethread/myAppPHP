<?php
	use Illuminate\Support\Facades\Cache;
	$tags = Cache::get('side_tags');
	sort($tags);
?>

<div class="list-group">
	@foreach ($tags as $tag)
		<a href="/tag/{{ $tag }}" class="list-group-item">{{ $tag }}</a>
	@endforeach	
</div>