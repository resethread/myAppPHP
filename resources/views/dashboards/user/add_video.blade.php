@extends('layouts.user_layout')
@section('content')
<link rel="stylesheet" href="/assets/css/dropzone.css">
<style>
	#classic_form_upload {
		display: none;
	}

	#my-awesome-dropzone {
		width: 300px;
		height: 100px;
		border: 3px dashed #ccc;
		border-radius: 7px;
		background: #f3f3f3;

		margin-bottom: 8em;
	}
</style>

<style>
.js .input-file-container {
  position: relative;
  width: 225px;
}
.js .input-file-trigger {
  display: block;
  padding: 14px 45px;
  background: #39D2B4;
  color: #fff;
  font-size: 1em;
  transition: all .4s;
  cursor: pointer;
}
.js .input-file {
  position: absolute;
  top: 0; left: 0;
  width: 225px;
  padding: 14px 0;
  opacity: 0;
  cursor: pointer;
}
 
/* quelques styles d'interactions */
.js .input-file:hover + .input-file-trigger,
.js .input-file:focus + .input-file-trigger,
.js .input-file-trigger:hover,
.js .input-file-trigger:focus {
  background: #34495E;
  color: #39D2B4;
}
 
/* styles du retour visuel */
.file-return {
  margin: 0;
}
.file-return:not(:empty) {
  margin: 1em 0;
}
.js .file-return {
  font-style: italic;
  font-size: .9em;
  font-weight: bold;
}
/* on complète l'information d'un contenu textuel
   uniquement lorsque le paragraphe n'est pas vide */
.js .file-return:not(:empty):before {
  content: "Selected file: ";
  font-style: normal;
  font-weight: normal;
}

</style>
	<h1 class="">UPLOAD VIDEO HERE </h1>

	@if(Session::has('message_success'))
		<div class="message green">
			{{ Session::get('message_success') }}
		</div>
	@elseif(Session::has('message_error'))
		<div class="message red">
			{{ Session::get('message_error') }}
		</div>
	@endif
	
	{!! Form::open(['method' => 'POST', 'files' => true, 'id' => 'cl']) !!}
		<div class="input-file-container">
		  	<input class="input-file" id="my-file" type="file" name="file">
			<label for="my-file" class="input-file-trigger" tabindex="0">Select a video...</label>
		</div>
		<p class="file-return"></p>
		<br>
		<textarea name="" class="input" id="" cols="4" rows="4"></textarea>
		<button type="submit" class="button orange">Upload</button>
	{!! Form::close() !!}	


	<script>
// ajout de la classe JS à HTML
document.querySelector("html").classList.add('js');
 
// initialisation des variables
var fileInput  = document.querySelector( ".input-file" ),  
    button     = document.querySelector( ".input-file-trigger" ),
    the_return = document.querySelector(".file-return");
 
// action lorsque la "barre d'espace" ou "Entrée" est pressée
button.addEventListener( "keydown", function( event ) {
    if ( event.keyCode == 13 || event.keyCode == 32 ) {
        fileInput.focus();
    }
});
 
// action lorsque le label est cliqué
button.addEventListener( "click", function( event ) {
   fileInput.focus();
   return false;
});
 
// affiche un retour visuel dès que input:file change
fileInput.addEventListener( "change", function( event ) {  
    the_return.innerHTML = this.value;  
});
	</script>

	
	
	
	{{-- 
	<form action="/user/add-video" class="dropzone" id="my-awesome-dropzone" enctype="multipart/form-data">
		<input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
		<div class="fallback">
			<input name="file" type="file" />
		</div>
		<div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress></span></div>
	</form>

	<span id="progress"></span>
	<div class="progress_bar">
		<div class="bar" id="bar" style="width:0">
			
		</div>
	</div>
	
	If you meet trouble to upload your files with the drag and drop system, you can use the <a href="#" id="to_classic_form">classic form</a> <br>

	{!! Form::open(['method' => 'POST', 'files' => true, 'id' => 'classic_form_upload']) !!}
	<div class="fallback">				
		<input type="file" id="file" name="file" accept="video/*" style="">
		<button type="submit" class="button blue">Upload</button>
	</div>
	{!! Form::close() !!}
	 --}}
@stop
