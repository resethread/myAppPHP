@extends('layouts.public_layout')
@section('content')

<div class="col-md-8 col-md-offset-2 col-xs-12">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h4>Login</h4>
		</div>
		<div class="panel-body">
			<form method="POST" action="/login" id="" class="">
				<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />

				<div class="form-group">
					<input type="text" class="form-control" name="login" placeholder="Login" tabindex="1">
				</div>

				<div class="form-group">
					<input type="password" class="form-control" name="password" placeholder="Password" tabindex="2">
				</div>

				<div class="form-group">
					<button type="submit" class="btn btn-default btn-block btn-lg" tabindex="3">Send</button>
				</div>
			</form>
		</div>
	</div>
</div>

@endsection

