<?php
//Author: Kyle Austin
//Date: 11/29/2014
//Purpose: Build class that can be used to create accounts dynamically...

class makeUserClass{

//PDO Object/
private $con;

//Standard class variables/
private $user_name;
private $email;
private $password;
private $password_repeat;
private $sex;
private $submit_date;
private $ip_submit;

//Blowfish start and end paramaeters/
private $blowfish_pre = '$2a$12$';
private $blowfish_end = '$';
  
 //Designates allowed character langth and character length/
private $allowed_chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789./';
private $chars_len = 63;

//Assign salt values/
private $salt_length = 21;
private $salt= "";

	//CONSTRUCTOR/
	function __construct($user, $email, $pass, $rpass, $sex, $ip){
		
		$this->con = new PDO('mysql:host=localhost;dbname=botcry5_date;charset=utf8', 'botcry5_trader', 'traderb0tz', array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
		
		if (!$this->con)
		{
			die('Could not connect: ' . mysql_error());
		}	
		
		$this->user_name = $user;
		$this->email = $email;
		$this->password = $pass;
		$this->password_repeat = $rpass;
		$this->sex = $sex;
		$this->ip_submit = $ip;
		$this->submit_date = date("Y-m-d");
		
		if(isset($this->user_name) && isset($this->email) && isset($this->password) && isset($this->password_repeat) && isset($this->sex) && $this->password == $this->password_repeat){
			
			$regex = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/'; 
			
			//Regex detects invalid email format/
			if (preg_match($regex, $this->email)) {
				} else { 
				die("Invalid Email Format.");
				} 
			
			//Detects for duplicate account names/
			$check_dupe = $this->con->prepare("SELECT * FROM users WHERE user = ?");
			$check_dupe->bindValue(1, $this->user_name, PDO::PARAM_STR);
			$check_dupe->execute();

			$checked_dupe = $check_dupe->fetch(PDO::FETCH_ASSOC);

			if($checked_dupe['user'] == $this->user_name){
				die("Username already exists.  Please try another.");
			}else{
				echo "Username Available.";
			}
			
			$build = $this->build_account();
		
		}elseif(!isset($this->user_name)){
			die("You must enter a user name.");
		}elseif(!isset($this->email)){
			die("You must enter your email.");
		}elseif(!isset($this->password)){
			die("You must enter a password.");
		}elseif(!isset($this->password_repeat)){
			die("You must repeat your password.");
		}elseif($this->password != $this->password_repeat){
			die("Your repeated password does not match your original.");
		}
			
		//END __CONSTRUCT/
	}

	
	private function build_account(){
		
		for($i = 0; $i < $this->salt_length; $i++){
			$this->salt .= $this->allowed_chars[mt_rand(0,$this->chars_len)];
		}
		
		$this->salt = $this->blowfish_pre . $this->salt . $this->blowfish_end;
		
		$this->password = crypt($this->password, $this->salt);
		
		echo $this->user_name."<br>";
		echo $this->email."<br>";
		echo $this->password."<br>";
		echo $this->salt."<br>";
		echo $this->submit_date."<br>";
		
		try{
		$query = $this->con->prepare("INSERT INTO users SET user = ?, email = ?, sex=?, password = ?, salt = ?, created_date = ?, created_ip = ?");
		$query->bindValue(1, $this->user_name, PDO::PARAM_STR);
		$query->bindValue(2, $this->email, PDO::PARAM_STR);
		$query->bindValue(3, $this->sex, PDO::PARAM_STR);
		$query->bindValue(4, $this->password, PDO::PARAM_STR);
		$query->bindValue(5, $this->salt, PDO::PARAM_STR);
		$query->bindValue(6, $this->submit_date, PDO::PARAM_STR);
		$query->bindValue(7, $this->ip_submit, PDO::PARAM_STR);
		$result = $query->execute();
		}catch(PDOException $e){
			echo $e;
		}
		
		if($result){
			echo "Account Created!";
		}
		//END BUILD_ACCOUNT/
	} 

	//END MAKEUSERCLASS/
}
?>
