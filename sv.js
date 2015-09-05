var ffmpeg = require('fluent-ffmpeg');
var fs = require('fs');

var path = __dirname + '/public/users_content/videos/' + 1;


var files = fs.readdir(path, function(err, files) {

	var file = files[0];
	var extension = file.slice(-3);
	var file_no_extension = file.substr(0, file.lastIndexOf('.'));

	if (extension == 'mp4' || extension || 'avi') {
		process.chdir(path);

		var command = ffmpeg(file).output('tata.avi').run();
	}
});






