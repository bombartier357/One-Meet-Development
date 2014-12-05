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
	echo "<form method='post' action='index.php'>
	<input type='text' name='user' placeholder='username' />
	<input type='text' name='email' placeholder='email' />
	<input type='password' name='pass' placeholder='password' />
	<input type='password' name='rpass' placeholder='password repeat' />
	<br>
	<input type='radio' name='sex' value='male' checked />Male
	<br>
	<input type='radio' name='sex' value='female' />Female
	<input type='submit' name='submit' value='Submit' />
	</form>";
}else{
	echo "<form method='post' action='index.php'>
	<input type='text' name='user' placeholder='username' />
	<input type='text' name='password' placeholder='password' />
	<input type='submit' name='login' value='Log In' />
	</form>";
	echo "<p></p><a href='index.php?register=yes'>Register</a>";
}
}
?>
