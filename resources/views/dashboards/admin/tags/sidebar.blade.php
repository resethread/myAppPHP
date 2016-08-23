@extends('layouts.admin_layout')
@section('content')
	<h1>Sidebar menu</h1>	
	<div class="container" id="sidebar_menu">
		<div class="col-md-6">
			{!! Form::open(['class' => 'form-inline', 'v-on:submit' => 'confirm']) !!}
				<div class="form-group">
					<input type="text" class="form-control" v-model="new_tag">
				</div>
				<div class="form-group">
					<button type="button" class="btn btn-primary" @click="addTag">Add</button>
				</div>
				<ul class="list-group">
					<li class="list-group-item" v-for="tag in tags | orderBy 'tag'">
						<span v-text="tag"></span>
						<i class="pull-right"  @click="removeTag(tag)">REMOVE</i>
					</li>
				</ul>
				<input type="hidden" name="side_tags" :value="stringifyTags">
				<div class="form-group">
					<button type="submit" class="btn btn-success">Save</button>
				</div>
			{!! Form::close() !!}
		</div>
	</div>
	<script src="/assets/js/vue.js"></script>
	<script src="/assets/js/vue-resource.js"></script>
	<script>
		var SidebarCtrl = new Vue({
			el: '#sidebar_menu',

			ready: function() {
				this.fetchSideTags()
			},

			data: {
				tags: []
			},

			methods: {
				addTag: function() {
					var new_tag = this.new_tag
					if (new_tag) {
						this.tags.unshift(this.new_tag)
						this.new_tag = ''
					}

				},

				removeTag: function(tag) {
					this.tags.$remove(tag)
				},

				confirm: function(event) {
					//event.preventDefault()
					//alert('message \n test \n test')
				},

				fetchSideTags: function() {

					this.$http.get('/api/side-tags', function(tags, status, request) {
						this.tags = tags;
					}).error(function(data, status, request) {
						console.log('error');
					})


				}
			},

			computed: {
				stringifyTags: function() {
					return JSON.stringify(this.tags)
				}
			}
		});
	</script>
@endsection