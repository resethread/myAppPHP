var elixir = require('laravel-elixir');

elixir(function(mix) {

	var sass_files = [
		'test',
		'test2'
	]

	var css_destination = 'public/assets/css/'





	for (var file of sass_files) {
		mix.sass(`${file}.scss`, `${css_destination}${file}.css` )
	}
});



