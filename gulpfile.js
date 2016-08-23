var fs = require('fs-extra')
var elixir = require('laravel-elixir')



elixir(function(mix) {

	// create bootstrap folder in resources if not exist
	/*
	fs.stat('./resources/bootstrap', (err, stats) => {
		if (!stats) {
			fs.copy('./node_modules/bootstrap-sass/assets/stylesheets', './resources/assets/bootstrap', (err) => {
				if (err) 
					console.log('erreur')
				else 
					console.log('success')	
			})
		}
		else {
			console.log('already insuide')
		}
	})
	*/


	// SASS
	mix.sass('app.scss', 'public/assets/css/test.css')
});



