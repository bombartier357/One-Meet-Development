<!DOCTYPE html>
<html>
	<head>
		<meta charset='utf-8'>
		<title>One-Meet</title>
		<meta name='viewport' content='width=device-width, initial-scale=1.0'>
		<meta name='description' content=''>
		<meta name='author' content=''>
		<script src='/L-project/public/js/jquery/jquery.min.js'></script>
		<script src='/L-project/public/js/jquery/jquery-ui-1.9.2.custom.js'></script>
		<link href='/L-project/public/bootstrap/css/bootstrap.css' rel='stylesheet'>
		@yield('head')
	</head>
	<body>
		@if(Session::has('message'))
			<p style="color:green;">
			{{ Session::get('message') }}
			</p>
		@endif
		
		@yield('content')
	</body>
	@yield('hidden_js_variables')
	<script type='text/javascript' src='/L-project/public/bootstrap/js/bootstrap.js'></script>
	<script type='text/javascript' src='/L-project/public/js/angular.js'></script>
	@yield('js_packages')
</html>
