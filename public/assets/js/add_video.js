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
	},
	error: function(e) {
		console.log('error : ' + e)
	},
	uploadprogress: function(file, progress, bytesSent) {
		console.log(file);
		console.log(progress);
		console.log(bytesSent);
	},
	complete: function() {
		location.reload(); 
	}
};

(function diplayClassicForm() {
	document.getElementById('to_classic_form').onclick = function() {
		document.getElementById('classic_form_upload').style.display = 'block';
	}
})();