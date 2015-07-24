<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<link rel="stylesheet" href="/assets/css/site.css">
		<link rel="stylesheet" href="/assets/css/bootstrap.css">
		<title>Admin</title>
	</head>
	<body>
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
				<div class="col-md-3">
					<div class="list-group">
						<a href="/admin/videos-to-validate" class="list-group-item">Videos to validate<span class="badge">30 today</span></a>
						<a href="/admin/videos-online" class="list-group-item">Videos online</a>
						<a href="/admin/users" class="list-group-item">Users</a>
						<a href="/admin/comments" class="list-group-item">Comments</a>
						<br>
						<a href="/admin/fast-delete" class="list-group-item">Fast delete</a>
						<a href="/admin/messages" class="list-group-item">Messages</a>
						<a href="/admin/logs" class="list-group-item">Logs</a>
					</div>
				</div>
				<div class="col-md-9">
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