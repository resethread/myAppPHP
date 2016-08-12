<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<link rel="stylesheet" href="/assets/css/site.css">
		<link rel="stylesheet" href="/assets/css/bootstrap.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
		<title>Admin</title>
	</head>
	<body>
		<style>
		i {
			margin-right: 0.9em;
		}
		</style>
		<div class="navbar navbar-default navbar-fixed-top">
			<div class="container-fluid">
				<div class="navbar-header">
					
				</div>
				<div class="navbar-collapse collapse">
					<ul class="nav navbar-nav">
						<li><a href="/admin" class="btn">ADMIN PANEL</a></li>
					</ul>

					<ul class="nav navbar-nav navbar-right">
						<li><a href="/">Public</a></li>
						<li><a href="/logout">Logout</a></li>
					</ul>
				</div>
			</div>
		</div>
		<div class="container-fluid" style="margin-top: 60px;">
			<div class="row">
				<div class="col-md-2" style="background: #32383e; min-height: 100vh;">
					<div class="row">
						<div class="list-group">
							<a href="/admin" class="list-group-item"><i class="fa fa-dashboard"></i> Home</a>
							<a href="/admin/videos-to-validate" class="list-group-item"><i class="fa fa-check-square"></i> Videos to validate<span class="badge">30 today</span></a>
							<a href="/admin/videos-online" class="list-group-item"><i class="fa fa-video-camera"></i> Videos online</a>
							<a href="/admin/users" class="list-group-item"><i class="fa fa-users"></i> Users</a>
							<a href="/admin/comments" class="list-group-item"><i class="fa fa-comments"></i> Comments</a>
							<a href="/admin/stars" class="list-group-item"><i class="fa fa-female"></i> Stars</a>
							<a href="/admin/tags" class="list-group-item"><i class="fa fa-tags"></i> Tags</a>
							<a href="/admin/tags/sidebar" class="list-group-item"><i class="fa fa-tags"></i> Tags - sidebar</a>
							<a href="/admin/banners" class="list-group-item"><i class="fa fa-photo"></i> Banners</a>

							<a href="/admin/comments-reported" class="list-group-item"><i class="fa fa-warning"></i> Comments reported</a>
							<a href="/admin/fast-delete" class="list-group-item"><i class="fa fa-exclamation-circle"></i> Fast delete</a>
							<a href="/admin/messages" class="list-group-item"><i class="fa fa-envelope"></i> Messages</a>
							<a href="/admin/logs" class="list-group-item"><i class="fa fa-terminal"></i> Logs</a>

							
						</div>
					</div>
				</div>
				<div class="col-md-10">
					@if(Session::has('message_success'))
						<div class="alert alert-success">
							{{ Session::get('message_success') }}
						</div>
					@elseif(Session::has('message_error'))
						<div class="alert alert-danger">
							{{ Session::get('message_error') }}
						</div>
					@endif
					@yield('content')
				</div>
			</div>
		</div>
	</body>
</html>