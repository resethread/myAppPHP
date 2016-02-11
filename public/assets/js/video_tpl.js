new Vue({

	debug: true,

	el: '#video_tpl',

	ready: function() {
		this.fetchComments();
	},	

	data: {
		comments: [
		
		]
	},
	methods: {
		fetchComments: function() {
			var url = window.location.pathname; // urm
			var id = url.split('/', 3); // ['/', 'video', id]
			id = id[2]
			
			this.$http.get('/comments/' + id, function(comments, status, request) {
				this.comments = comments;
				console.log(comments);
			}).error(function(data, status, request) {
				console.log('error');

			})
		}
	},

	postComment: function() {
		
	}
});