@extends('layouts.user_layout')

@section('content')
<style>
	.btn_tag {
		display: inline-block;
		padding: 4px 8px;
		border: 1px solid #000;
		text-align: center;
		background: #606c88;
		background: linear-gradient(to bottom, #606c88 0%,#3f4c6b 100%);
		color: #fff;
		cursor: pointer;
	}


	.tagged {
		background: #8fa6bf;
		background: linear-gradient(to bottom, #8fa6bf 0%,#6f93b9 100%);
	}
</style>
	<h1>Edit</h1>

	<h2>{{ $video->name }}</h2>

	<h4>Advanced (optionnal)</h4>
	<h5>Keywords</h5>
	
	{!! Form::open(['id' => 'edit_video']) !!}
		<textarea name="keywords" id="" cols="0" rows="3" class="input"><?php foreach($video->tagged as $tagged): ?><?php echo $tagged->tag_name; ?> <?php endforeach; ?> </textarea>
		<br><br>

		@foreach($tags as $tag)
			<div class="btn_tag">{{ $tag }}</div>
		@endforeach

		<input type="text" id="tags" name="tags" style="display: none; visibility: hidden;">
		<hr>
		<button type="submit" class="button">Send</button>
	{!! Form::close() !!}
@stop