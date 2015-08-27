Dropzone.options.myAwesomeDropzone = {
	paramName: 'file',
	url: '/user/add-video',
	method: 'post',
	maxFilesize: 50,
	acceptedFiles: 'video/*',
	init: function() {
		console.log('loaded')
	},	
};

(function diplayClassicForm() {
	document.getElementById('to_classic_form').onclick = function() {
		document.getElementById('classic_form_upload').style.display = 'block';
	}
})();