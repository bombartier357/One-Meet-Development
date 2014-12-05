<?php
//Author: Kyle Austin
//Date: 11/29/2014
//Purpose: Build class that can be used to login to accounts dynamically...

class loginUserClass{
	
//PDO Object/
private $con;

//Setter storage/
private $user_name;
private $password;


	function __construct($user, $pass){
		$this->con = new PDO('mysql:host=localhost;dbname=botcry5_date;charset=utf8', 'botcry5_trader', 'traderb0tz', array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
			
		if (!$this->con)
		{
			die('Could not connect: ' . mysql_error());
		}
			
		$this->user_name = $user;
		$this->password = $pass;
		
		if(isset($this->user_name) && isset($this->password)){
			$this->login_attempt();
		}else{
			die("You must enter a user name and password to continue.");
		}	
				
		//END __CONSTRUCT/
	}
	
	public function login_attempt(){
		$query = $this->con->prepare("SELECT * FROM users WHERE user = ?");
		$query->bindValue(1, $this->user_name, PDO::PARAM_STR);
		$query->execute();

		$row = $query->fetch(PDO::FETCH_ASSOC);
		  
		$hashed_pass = crypt($this->password, $row['salt']);
		
		if($hashed_pass == $row['password']){
			$this->build_session($row['id'], $row['sex']);
		}else{
			echo $hashed_pass."</br>";
			echo $row['password'];
			die("You have entered the wrong password or user name.");
		}
		//END LOGIN_ATTEMPT/
	}
	
	private function build_session($id, $sex){
		session_start();

		$charset='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
		$str = '';
		$length = 255;
			$count = strlen($charset);
			while ($length--) {
				$str .= $charset[mt_rand(0, $count-1)];
			}
		$new_hash = $str;
		
		$result = $this->con->prepare("UPDATE users SET session_hash = ? WHERE id=?"); 
		$result->bindValue(1, $new_hash, PDO::PARAM_STR);
		$result->bindValue(2, $id, PDO::PARAM_INT);
		$result->execute();
		
		$_SESSION['ID'] = $id;
		$_SESSION['SEX'] = $sex;
		$_SESSION['HASH'] = $new_hash;
		
		$newURL = 'index.php?logged=yes';
		
		header('Location: '.$newURL);
	}
	
	//END BUILD_SESSION/
}

?>
