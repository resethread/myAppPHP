var elixir = require('laravel-elixir');

elixir(function(mix) {

	// SASS
	var sass_files = [
		'test',
		'test2'
	]

	var css_destination = 'public/assets/css/'


	for (var file of sass_files) {
		mix.sass(`${file}.scss`, `${css_destination}${file}.css` )
	}

	// JS
	var js_files = [
		'overviews',
	]
});



