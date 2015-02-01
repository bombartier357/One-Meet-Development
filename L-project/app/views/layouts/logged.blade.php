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
		<script type='text/javascript' src='/L-project/public/js/angular.js'></script>
		<link href='/L-project/public/bootstrap/css/bootstrap.css' rel='stylesheet'>
		<link href='/L-project/public/css/jquery-ui-1.9.2.custom.css' rel='stylesheet'>
		<link href='/L-project/public/css/master.css' rel='stylesheet'>
		<link href='/L-project/public/css/jquery.spin.css' rel='stylesheet'>
		<link href='/L-project/public/css/font-awesome-4.2.0/css/font-awesome.min.css' rel='stylesheet'>
		<link href='/L-project/public/packages/sweetalert-master/lib/sweet-alert.css' rel='stylesheet'>
		<style type="text/css">
			li:hover {
				color: green;
			}
			</style>
		@yield('head')
		@yield('js_packages')
	</head>
	<body ng-app="angApp" style='background: url("/L-project/public/js/jquery-ui-custom/images/ui-bg_diamond_8_261803_10x8.png");'>
		<div class="container-fluid" style='min-height:990px;max-height:990px;'>
		@yield('nav')
		<div class="container-fluid">
		@yield('body')
		</div>
		@yield('footer')
		</div>
	</body>
	<input type="hidden" id="user-id" value="{{$id}}"/>
	<input type="hidden" id="coinbase-price" value="{{$coinbase_price}}"/>
	@yield('hidden_variables')
	<script type='text/javascript' src='/L-project/public/bootstrap/js/bootstrap.js'></script>
	<script type='text/javascript' src='/L-project/public/js/angApp.js'></script>
	<script type='text/javascript' src='/L-project/public/js/jquery.spin.js'></script>
	<script type='text/javascript' src='/L-project/public/packages/sweetalert-master/lib/sweet-alert.min.js'></script>
</html>
