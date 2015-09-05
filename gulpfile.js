/*
var elixir = require('laravel-elixir');

elixir(function(mix) {
    mix.sass('app.scss');
});
*/
var fs = require('fs');
var gulp = require('gulp-param')(require('gulp'), process.argv);
var ffmpeg = require('gulp-fluent-ffmpeg');
 
gulp.task('valid', function(id) {

	var path = __dirname + '/public/users_content/videos/' + id;

	fs.readdir(path, function(err, files) {
		var file = files[0];
		var extension = file.slice(-3);
		var file_no_extension = file.substr(0, file.lastIndexOf('.'));

		if (extension == 'mp4' || extension || 'avi') {
				
			return gulp.src(path + '/' + file)
				.pipe(ffmpeg('avi'), function(cmd) {
					return cmd.output('toto.avi')
				})
				.pipe(gulp.dest(path));
		}
	});
});

