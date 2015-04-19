@extends('layouts.home')

@section('content')
<div class='container-fluid'>
	<div class='row-fluid'>
		<div class='md-col-12'>
			<div id='logo-spot'>
				<center><img style='position:relative;' src='images/onemeet.png' />
				</br>
				<button onclick='about_us()' class='btn btn-default'>About Us</button>
				<button onclick='login()' class='btn btn-default'>Login</button>
				<button onclick='register()' class='btn btn-default'>Register</button>
				</center>
			</div>
			<center>
			<div id='index-switcher-aboutus' style='v-align:center;border-radius: 15px;background-color:white;width:500px;height:400px;border:1px solid #cacaca;margin-top:5%;text-align:left;display:none;'>
				<span style='padding-left:5em;'>Welcome to one-meet.  Meet, play, exchange.</span>
			</div>
			</center>
			<center><div id="index-switcher-login" style='position:relative;z-index:100;border-radius: 15px;background-color:transparent;width:100px;height:100px;margin-top:-340px;margin-right:10px;display:none;'><center><h1>Login</h1></center>
				{{ Form::open(array('url'=>'login/gateway', 'method'=>'POST')) }}
				<p>
				{{ Form::label('user', 'User:') }}<br />
				{{ Form::text('user', '', array('class'=>'form-control')) }}
				</p>
				<p>
				{{ Form::label('password', 'Password:') }}<br />
				{{ Form::password('password', array('class'=>'form-control')) }}
				</p>
				<p>
				{{ Form::submit('Login', array('class'=>'btn btn-default')) }}
				</p>
				{{ Form::close() }}
			</div></center>
			
			<center><div id='index-switcher-register' style='position:relative;z-index:100;border-radius: 15px;background-color:transparent;width:200px;height:400px;margin-top:-420px;display:none;margin-right:450px;'>
				{{ Form::open(array('url'=>'register/create', 'method'=>'POST')) }}
				<p>
				{{ Form::label('user', 'User:') }}<br />
				{{ Form::text('user', '', array('class'=>'btn btn-default')) }}
				</p>
				<p>
				{{ Form::label('email', 'Email:') }}<br />
				{{ Form::text('email', '', array('class'=>'btn btn-default')) }}
				</p>
				<p>
				{{ Form::label('sex', 'Male:') }}{{ Form::radio('sex', 'Male') }}
				{{ Form::label('sex', 'Female:') }}{{ Form::radio('sex', 'Female') }}
				</p>
				<p>
				{{ Form::label('password', 'Password:') }}<br />
				{{ Form::password('password', array('class'=>'btn btn-default')) }}
				</p>
				<p>
				{{ Form::submit('Register', array('class'=>'btn btn-default')) }}
				</p>
				{{ Form::close() }}
			</div></center>
		</div>
	</div>
</div>
@stop

@section('js_packages')
<script src='js/index.js'></script>
@stop
