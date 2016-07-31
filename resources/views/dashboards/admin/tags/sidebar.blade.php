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
					<li class="list-group-item" v-for="tag in tags">
						<span v-text="tag"></span>
						<i class="pull-right"  @click="removeTag(tag)">REMOVE</i>
					</li>
				</ul>
				<div class="form-group">
					<button type="submit" class="btn btn-success">Save</button>
				</div>
				<h1 v-text="stringifyTags"></h1>
			{!! Form::close() !!}
		</div>
	</div>
	<script src="/assets/js/vue.js"></script>
	<script>
		var SidebarCtrl = new Vue({
			el: '#sidebar_menu',

			data: {
				tags: ['toto', 'bob', 'max']
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
					event.preventDefault()
					alert('message \n test \n test')
				}
			},

			computed: {
				stringifyTags: function() {
					var arr = this.tags 
					arr = arr.toJSON()
				}
			}
		});
	</script>
@endsection