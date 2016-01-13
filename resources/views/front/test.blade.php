<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<link rel="stylesheet" href="/assets/css/bootstrap.css">
		<title>Document</title>
<style>

.videoOvw {
		display: inline-block;
	width: 200px;
	height: 150px;
	margin: 10px;
	border: 1px solid #777;
	font-size: 0;
	overflow: hidden;
	text-transform: lowercase;
}

.ovwTitle {
	font-size: 13px;
	margin: 0 0 0 8px;
	padding: 0;
}

.owwNbViews {
	font-size: 11px;
	margin: 0 0 0 8px;
}

</style>
	</head>
	<body>
		<div class="container-fluid" style="margin-top: 10px;">
			<div class="row">
				<div class="col-md-2">
					<img src="/assets/img/logo.jpg" alt="">
				</div>
				<div class="col-md-6">
					<form action="" class="form-horizontal">
						<div class="col-md-6">
							<input type="search" class="form-control" placeholder="search">
						</div>
						<div class="col-md-6">
							<button class="btn btn-default">search</button>
						</div>
					</form>
				</div>
				<div class="col-md-4">
					<button class="btn btn-success">Register</button>
					<button class="btn btn-warning">Login</button>
					<button class="btn btn-danger">Test</button>
				</div>
			</div>
		</div>
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-2">
					<ul class="list-group">
						@for($i = 0; $i < 40; $i++)
							<li class="list-group-item"><a href="#">Cras justo odio</a></li>
						@endfor
					</ul>
				</div>
				<div class="col-md-10">
					@for($i = 0; $i < 30; $i++)
						<div class="videoOvw">
							<a href="/video/14/le-meilleur-basketteur-le-show-jaune-6">
								<img src="/users_content/videos/14/z_img__rgxdgvt3S8001.jpg" alt="" title="LE MEILLEUR BASKETTEUR ! - LE SHOW JAUNE #6" height="100" width="200">
							</a>
							<p class="ovwTitle"><a href="/video/14/le-meilleur-basketteur-le-show-jaune-6" title="LE MEILLEUR BASKETTEUR ! - LE SHOW JAUNE #6">LE MEILLEUR BASKETTEUR ! - LE SHOW JAUNE #6</a></p>
							<p class="owwNbViews">2</p>
						</div>
					@endfor
				</div>
			</div>
		</div>
	</body>
</html>