Dropzone.options.myAwesomeDropzone = {
	paramName: 'file',
	url: '/user/add-video',
	method: 'post',
	maxFilesize: 50,
	acceptedFiles: 'video/*',
	init: function() {
		console.log('initalised')
	},	
	addedfile: function(file) {
		console.log("file added");
		document.getElementById('bar').style.width = '0%';
	},
	error: function(e) {
		console.log('error : ' + e)
	},
	sending: function() {
		console.log('start sending');
	},
	uploadprogress: function(file, progress, bytesSent) {

		var progress = progress;

		document.getElementById('bar').style.width = progress + '%';

		document.getElementById('progress').innerHTML = progress + ' %'

		console.log(file);
		console.log(progress);
		console.log(bytesSent);
	},
	complete: function() {
	//	location.reload(); 
	console.log('complete');
	},
	success: function() {
		console.log('success');
	},
	canceled: function() {
		console.log('cancelled');
	}
};

(function diplayClassicForm() {
	document.getElementById('to_classic_form').onclick = function() {
		document.getElementById('classic_form_upload').style.display = 'block';
	}
})();