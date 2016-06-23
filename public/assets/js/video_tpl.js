Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#token').getAttribute('value');

var vm = new Vue({

	debug: true,

	el: '#video_tpl',

	ready: function() {

		this.getId()

		var id = window.location.pathname // url
		id = id.split('/', 3); // ['/', 'video', id]
		id = id[2]

		this.fetchComments(id);

	},	

	data: {
		id: '',
		message_response: {
			display: false,
			status: '',
			message: ''
		},
		comments: []
	},
	methods: {

		getId: function() {
			var id = window.location.pathname // url
			id = id.split('/', 3); // ['/', 'video', id]
			id = id[2]

			this.id = id

		},

		fetchComments: function(id) {
			
			this.$http.get('/comments/' + id, function(comments, status, request) {
				this.comments = comments;
			}).error(function(data, status, request) {
				console.log('error');

			})
		},

		addFaforite: function(id) {
			id = this.id 
			this.$http({
				url: '/add-favorite/' + id, method: 'POST'}).then(function(response) {

					console.log(response.data)
					vm.message_response.display = true
					vm.message_response.status = response.data.status
					vm.message_response.message = response.data.message

					console.log(vm.message_response)
				})
		},

		rateVideo: function(i) {
			var id = this.id
			this.$http({
				url: '/rate-video/' + id + '/' + i, method: 'POST'}).then(function(response) {
					console.log(response)
					vm.message_response.display = true
					vm.message_response.status = response.data.status
					vm.message_response.message = response.data.message
				})
		},

		sendComment: function(event) {
			event.preventDefault()
			if (this.comment) {
				
				this.$http.post('/comment/' + this.id, {comment : this.comment }).then(function(response) {
					console.log(response)
					vm.message_response.display = true
					vm.message_response.status = response.data.status
					vm.message_response.message = response.data.message
					
				})
			}
			this.comment = ''

		}
	},
})



