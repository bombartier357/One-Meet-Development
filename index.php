<?php
//Author: Kyle Austin
//Date: 11/29/2014
//Purpose: Build master node for website

//This is run to create new accounts/
if(isset($_POST['submit'])){
	include_once("makeUserClass.php");
	$new_user = new makeUserClass($_POST['user'], $_POST['email'], $_POST['pass'], $_POST['rpass'], $_POST['sex'], $_SERVER['REMOTE_ADDR']);
}

//This is run to login/
if(isset($_POST['login'])){
	include_once("loginUserClass.php");
	$new_login = new loginUserClass($_POST['user'], $_POST['password']);
}

//This is run after login/
if(isset($_GET['logged']) && $_GET['logged'] == 'yes'){
	
	//This section will dynamically load different pages/
	if(isset($_GET['page'])){
		$page = $_GET['page'];
	}else{
		$page = 'home';
	}
	
	include("constructUserClass.php");
	$new_construct = new constructUserClass($page);
}else{
	
if(isset($_GET['register'])){
	echo "<!DOCTYPE html>
			<html lang='en' style='background: url(\"js/jquery-ui-custom/images/ui-bg_layered-circles_75_e2fbe7_13x13.png\");'><head>
			<meta charset='utf-8'>
			<title>One-Meet</title>
			<meta name='viewport' content='width=device-width, initial-scale=1.0'>
			<meta name='description' content=''>
			<meta name='author' content=''>
			<script src='js/jquery/jquery.min.js'></script>
			<script src='js/jquery/jquery-ui-1.9.2.custom.js'></script>";
	echo "<head>";
	
	echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
		<link href='bootstrap/css/bootstrap.css' rel='stylesheet'>
		<link href='css/jquery-ui-1.9.2.custom.css' rel='stylesheet'>
		<link href='css/master.css' rel='stylesheet'>  ";
	echo "</head>";
	
	echo "<body style='background: rgba(0, 0, 0, 0);'>";
	
	echo "<center><div style='border-radius: 15px;background-color:white;width:500px;height:400px;border:1px solid #cacaca;margin-top:10%;'><center>Register</center>
	<form method='post' action='index.php'>
	<center><div class='form-group' style='width:75%;margin-top:10%;'><input class='form-control' type='text' name='user' placeholder='username' /></div></center>
	<center><div class='form-group' style='width:75%;margin-top:5%;'><input class='form-control' type='text' name='email' placeholder='email' /></div></center>
	<center><div class='form-group' style='width:75%;margin-top:5%;'><input class='form-control' type='password' name='pass' placeholder='password' /></div></center>
	<center><div class='form-group' style='width:75%;margin-top:5%;'><input class='form-control' type='password' name='rpass' placeholder='password repeat' /></div></center>
	<center><div class='form-group' style='width:75%;margin-top:5%;'><input type='radio' name='sex' value='male' checked />Male
	<input type='radio' name='sex' value='female' />Female</div></center>
	<input class='btn btn-default' type='submit' name='submit' value='Submit' />
	</form></div></center>";
}else{
	echo "<!DOCTYPE html>
			<html lang='en' style='background: url(\"js/jquery-ui-custom/images/ui-bg_layered-circles_75_e2fbe7_13x13.png\");'><head>
			<meta charset='utf-8'>
			<title>One-Meet</title>
			<meta name='viewport' content='width=device-width, initial-scale=1.0'>
			<meta name='description' content=''>
			<meta name='author' content=''>
			<script src='js/jquery/jquery.min.js'></script>
			<script src='js/jquery/jquery-ui-1.9.2.custom.js'></script>";
	echo "<head>";
	
	echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
		<link href='bootstrap/css/bootstrap.css' rel='stylesheet'>
		<link href='css/jquery-ui-1.9.2.custom.css' rel='stylesheet'>
		<link href='css/master.css' rel='stylesheet'>  ";
	echo "</head>";
	
	echo "<body style='background: rgba(0, 0, 0, 0);'>";
	
	echo "<center><div style='border-radius: 15px;background-color:white;width:500px;height:400px;border:1px solid #cacaca;margin-top:10%;'><img style='width:100%;border-radius: 15px;' src='images/logo2.png' /><form method='post' action='index.php'>
	<center><div class='form-group' style='width:75%;margin-top:5%;'><input class='form-control' type='text' name='user' placeholder='username' /></div></center>
	<div class='form-group' style='width:75%;'><input class='form-control' type='password' name='password' placeholder='password' /></div>
	<div class='form-group' style='width:75%;'><input class='btn btn-default' type='submit' name='login' value='Log In' /><a style='margin-left:25px;' class='btn btn-default' href='index.php?register=yes'>Register</a></div>
	</form></div></center>
	";
	
	echo "</body>";
	echo "</html>";
}
}
?>
