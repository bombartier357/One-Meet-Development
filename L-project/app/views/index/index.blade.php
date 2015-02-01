@extends('layouts.home')

@section('content')
<div class='container-fluid'>
	<div class='row-fluid'>
		<div class='md-col-12'>
			<div id='logo-spot'>
				<center><img src='images/OneMeet_logo.png' />
				</br>
				<button onclick='about_us()' class='btn btn-default'>About Us</button>
				<button onclick='login()' class='btn btn-default'>Login</button>
				<button onclick='register()' class='btn btn-default'>Register</button>
				</center>
			</div>
			<center>
			<div id='index-switcher-aboutus' style='v-align:center;border-radius: 15px;background-color:white;width:500px;height:400px;border:1px solid #cacaca;margin-top:5%;text-align:left;'>
				<span style='padding-left:5em;'>Welcome to one-meet.  Here at one meet we try to bring people together and build an online community.</span>  </br></br>Go ahead meet someone.
			</div>
			</center>
			<center><div id="index-switcher-login" style='border-radius: 15px;background-color:white;width:500px;height:400px;border:1px solid #cacaca;margin-top:5%;display:none;'><center><h1>Login</h1></center>
				{{ Form::open(array('url'=>'login/gateway', 'method'=>'POST')) }}
				<p>
				{{ Form::label('user', 'User:') }}<br />
				{{ Form::text('user') }}
				</p>
				<p>
				{{ Form::label('password', 'Password:') }}<br />
				{{ Form::password('password') }}
				</p>
				<p>
				{{ Form::submit('Login') }}
				</p>
				{{ Form::close() }}
			</div></center>
			
			<center><div id='index-switcher-register' style='border-radius: 15px;background-color:white;width:500px;height:400px;border:1px solid #cacaca;margin-top:5%;display:none;'><center><h1>Register</h1></center>
				{{ Form::open(array('url'=>'register/create', 'method'=>'POST')) }}
				<p>
				{{ Form::label('user', 'User:') }}<br />
				{{ Form::text('user') }}
				</p>
				<p>
				{{ Form::label('email', 'Email:') }}<br />
				{{ Form::text('email') }}
				</p>
				<p>
				{{ Form::label('sex', 'Male:') }}{{ Form::radio('sex', 'Male') }}
				{{ Form::label('sex', 'Female:') }}{{ Form::radio('sex', 'Female') }}
				</p>
				<p>
				{{ Form::label('password', 'Password:') }}<br />
				{{ Form::password('password') }}
				</p>
				<p>
				{{ Form::submit('Register') }}
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
