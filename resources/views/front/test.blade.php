<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<link rel="stylesheet" href="/assets/css/bootstrap.css">
		<title>Document</title>
	</head>
	<body>
	<a href="/test2">test</a>
		{!! Form::open(['files' => true]) !!}
			
			<input type="text" name="toto">
			<input type="file" name="file">

		{!! Form::close() !!}
	</body>
</html>