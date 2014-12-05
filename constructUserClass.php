<?php
//Author: Kyle Austin
//Date: 11/29/2014
//Purpose: Build class that can be used display main web pages dynamically...

class constructUserClass{
	
	//PDO Object/
	private $con;
	
	//Target page to load/
	private $target;
	
	//Public Variables/
	public $id;
	public $user_name;
	public $first_name;
	public $last_name;
	public $sex;
	public $date_of_birth;
	public $year_of_birth;
	public $month_of_birth;
	public $day_of_birth;
	public $address1;
	public $address2;
	public $city;
	public $state;
	public $zip;
	public $country;
	public $ip;
	
	//Private Variables/
	private $hash;
	private $image_bank = array();
	private $image_bank_id = array();
	
	function __construct($page){
		session_start();
		
		$this->con = new PDO('mysql:host=localhost;dbname=botcry5_date;charset=utf8', 'botcry5_trader', 'traderb0tz', array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
			
		if (!$this->con)
		{
			die('Could not connect: ' . mysql_error());
		}
		
		$_SESSION['HACKERS'] =  'I am not your enemy, but attacking this site will be a waste of time for you.  There are much easier targets, I know...';
		
		$this->hash = $_SESSION['HASH'];
		$this->id = $_SESSION['ID'];
		$this->target = $page;
		$this->ip = $_SERVER['REMOTE_ADDR'];
		
		if (!file_exists('images/user_images/'.$this->id)) 
		{
			mkdir('images/user_images/'.$this->id, 0777, true);
			mkdir('images/user_images/'.$this->id.'/encrypted', 0777, true);
			mkdir('images/user_images/'.$this->id.'/encrypted_th', 0777, true);
		}
		
		$query = $this->con->prepare("SELECT * FROM users WHERE id = ?");
		$query->bindValue(1, $this->id, PDO::PARAM_INT);
		$query->execute();

		$row = $query->fetch(PDO::FETCH_ASSOC);
		
		$this->sex = $row['sex'];
		$this->user_name = $row['user'];

		//This build image bank for user and assigns to array for later use/
		$query2 = $this->con->prepare("SELECT * FROM images WHERE owner = ? ORDER BY ID DESC");
		$query2->bindValue(1, $this->id, PDO::PARAM_INT);
		$query2->execute();
		
		while($row2 = $query2->fetch(PDO::FETCH_ASSOC)){
			$this->image_bank[] = $row2['filename'];
			$this->image_bank_id[] = $row2['id'];
		}
		
		
		if($row['session_hash'] == $this->hash){
			$this->session_hash();
			
			//Standard HTML Header....
			echo "<!DOCTYPE html>
			<html lang='en' style='background: #F9F9F9;'><head>
			<meta charset='utf-8'>
			<title>Dating Website</title>
			<meta name='viewport' content='width=device-width, initial-scale=1.0'>
			<meta name='description' content=''>
			<meta name='author' content=''>
			<script src='js/jquery.min.js'></script>
			<script src='js/jquery-ui.min.js'></script>";
		
		
			$this->generate_page($this->target);
		}else{
			die("Your session hash does not match.  Please log back in and try again.<p></p><a href='index.php' />Home</a>");
		}
		
		//END CONSTRUCT/
	}
	
	private function generate_page($target){
		
			echo "<head>";
			$this->header($target); 
			$this->js_packages($target);
			echo "</head>";
			echo "<body><div class='container-fluid' id='master-node'>";
			$this->html_nav_bar($target);
			$this->html_body($target);
			$this->html_footer($target);
			echo "</div>";
			$this->hidden_variables($target);
			echo "</body>";
			echo "</html>";
	}
	
	private function header($target){
		echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
		<link href='css/master.css' rel='stylesheet'>  
		<link href='bootstrap/css/bootstrap.css' rel='stylesheet'>";
		
		if($target == 'home'){
			if(isset($_GET['subpage'])){
				if($_GET['subpage'] == 'video'){

				}
			}
		}
		
		if($target == 'imagecrop'){
			echo "<link href='css/croppic.css' rel='stylesheet'>  ";
		}  
		  
	}
	
	private function html_nav_bar($target){
		echo "<div class='row-fluid'>
		<nav class='navbar navbar-default navbar-fixed-top' role='navigation'>
		<ul class='nav navbar-nav'>";
		
		 if($target != 'home'){
			echo "<li class='col-md-3' id='home-link'><a href='index.php?logged=yes&page=home'>Home</a></li>";
		}else{
			echo "<li class='col-md-3' id='home-link'>Home</li>";
		}
		
		if($target != 'profile'){
			echo "<li class='col-md-3' id='profile-link'><a href='index.php?logged=yes&page=profile'>Profile</a></li>";
		}else{
			echo "<li class='col-md-3' id='profile-link'>Profile</li>";
		}
		
		if($target != 'matches'){
			echo "<li class='col-md-3' id='matches-link'><a href='index.php?logged=yes&page=matches'>Matches</a></li>";
		}else{
			echo "<li class='col-md-3' id='matches-link'>Matches</li>";
		}
		
		if($target != 'search'){
			echo "<li class='col-md-3' id='search-link'><a href='index.php?logged=yes&page=search'>Search</a></li>";
		}else{
			echo "<li class='col-md-3' id='search-link'>Search</li>";
		}
		echo "</ul>
		<ul class='nav nav-pills' style='float:right;'>
		
		<li role='presentation'>
		<button id='nav-trash' onclick='nav_trash();' type='button' class='btn btn-default btn-default' style='float:right;'>
		  <span class='glyphicon glyphicon-trash' aria-hidden='true'></br>(1)</span>
		</button>
		</li>
		<li role='presentation'>
		<button id='nav-mail' onclick='nav_mail();' type='button' class='btn btn-default btn-default' style='float:right;'>
		  <span class='glyphicon glyphicon-envelope' aria-hidden='true'></br>(1)</span>
		</button>
		</li>
		<li role='presentation'>
		<button id='nav-settings' onclick='nav_settings();' type='button' class='btn btn-default btn-lg' style='float:right;'>
		  <span class='glyphicon glyphicon-cog' aria-hidden='true'></span></span>
		</button>
		</li>
		<li role='presentation'>
		<button id='nav-logout' onclick='nav_logout();' type='button' class='btn btn-default btn-lg' style='float:right;'>
		  <span class='glyphicon glyphicon-log-out' aria-hidden='true'></span></span>
		</button>
		</li>
		
		</ul>
		</nav>
		</div>

		
		<div class='col-md-12' id='buffer-nav'></div>
		</div>";
	}
	
	private function html_body($target){
		echo "<div class='row-fluid' id='body'>";
		
		if($target == 'home'){
			echo "<div class='col-md-2' id='stats'>";
			
			if($_GET['subpage'] != 'views'){
				echo "<div><a href='index.php?logged=yes&page=home&subpage=views'>Views</a></div>";
			}else{
				echo "<div>Views</div>";
			}
			
			if($_GET['subpage'] != 'favorites'){
				echo "<div><a href='index.php?logged=yes&page=home&subpage=favorites'>Favorites</a></div>";
			}else{
				echo "<div>Favorites</div>";
			}
			
			if($_GET['subpage'] != 'chat_rooms'){
				echo "<div><a href='index.php?logged=yes&page=home&subpage=chat_rooms'>Chat Rooms</a></div>";
			}else{
				echo "<div>Chat Rooms</div>";
			}
			
			if($_GET['subpage'] != 'video'){
				echo "<div><a href='index.php?logged=yes&page=home&subpage=video'>Video</a></div>";
			}else{
				echo "<div>Video</div>";
				echo "<div class='col-md-12' id='video-favorites'>Favorites</div>";
			}

			echo "</div>";
			
			if(isset($_GET['subpage'])){
				if($_GET['subpage'] == 'views'){
					echo "<div class='col-md-10' id='views'></div>";
				}elseif($_GET['subpage'] == 'favorites'){
					echo "<div class='col-md-10' id='favorites'></div>";
				}elseif($_GET['subpage'] == 'chat_rooms'){
					echo "<div class='col-md-10' id='chat_rooms'>
						

					</div>";
				}elseif($_GET['subpage'] == 'video'){
					echo "<div class='col-md-10' id='video'>
						<video id='localVideo' autoplay></video>
        				<div id='remoteVideos'></div>
					</div>";
				}
			}
		//END HOME/	
		}
		
		if($target == 'profile'){

			$image_bank_count = count($this->image_bank);
			$image_main = 'images/user_images/'.$this->id.'/'.$this->image_bank[0];

			for($i=0; $i < $image_bank_count; $i++){
				$image_stream .= '<div ondrop="drop(event)" ondragover="allowDrop(event)"><a href="index.php?logged=yes&page=imagecrop&imageid='.$this->image_bank_id[$i].'"><img id="extra-images" src="images/user_images/'.$this->id.'/'.$this->image_bank[$i].'" draggable="true" ondragstart="drag(event)"/></a></div>';
			}

			echo "<div class='col-md-12'><div class='col-md-3'>Id: ".$this->id."</br>User: ".$this->user_name."</div></div>

			<div class='col-md-2'><img id='profile-image' src='$image_main' /></div>
			
			<div class='col-md-4'>
			<div class='col-md-12' id='age-display'>Age</div>
			<div class='col-md-12' id='sex-display'>Sex</div>
			<div class='col-md-12' id='looking-display'>Looking For</div>
			<div class='col-md-12' id='provide-display'>I Can Provide</div>
			<div class='col-md-12' id='interest-display'>Interests</div>
			<div class='col-md-12' id='hobbies-display'>Hobbies</div>
			</div>
			<div class='col-md-6'></div>
			<div class='col-md-12' id='image-reel'>Images
			
			<label for='fileToUpload'>Select a File to Upload</label><br />
			<input type='file' name='fileToUpload' id='fileToUpload2' onchange='fileSelected();'/>
			
			<div id='fileName'></div>
			<div id='fileSize'></div>
			<div id='fileType'></div>
			
			<button class='btn btn-default' id='make_upload' onclick='uploadFile2()'>Upload</button>
			
			<div id='progressNumber'></div>
			<div id='image-display'>
			$image_stream
			</div>
			</div>";
			
			echo "<div style='display:none;' id='window-interests'><table class='table table-bordered'><th>Interests</th></table></div>";
		//END PROFILE/
		}
		
		if($target == 'imagecrop'){
			
			$key = array_search($_GET['imageid'], $this->image_bank_id);
			$file = $this->image_bank[$key];
					
			echo "<div class='col-md-12'>
			<center><img id='crop-this-image' src='images/user_images/".$this->id."/".$file."' /></center>
			</div>";
		}
		
		if($target == 'matches'){
			echo "<div class='col-md-12' id='matches'>
			<div class='col-md-4' id='pic-1'>PICTURE ONE</div>
			<div class='col-md-4' id='matching-chars'>MATCHING CHARACTERISTICS</div>
			<div class='col-md-4' id='pic-2'>PICTURE TWO</div>
			</div>";
		}
		
		if($target == 'search'){
			echo "<div class='col-md-12' id='search'>
			<div class='col-md-12'>Search</div>
			<div class='col-md-12' id='search-form'>
			<div class='row'>
			  <div class='col-lg-2'>
			  <form class='form-inline' role='form'>
				<div class='form-group'>
					<div class='input-group'>
					<span class='input-group-btn'>
						<button class='btn btn-default' type='button'>Go!</button>
					</span>
					<input type='text' class='form-control' placeholder='User Name'>
					</div><!-- /input-group -->
					<div class='checkbox'>
						<label>
						  <input type='checkbox'> Male
						</label>
						</div>
				</div><!-- /.col-lg-6 -->
				</div><!-- /.row -->
				</form>
				</div>
			</div>
			<div class='col-md-12' id='search-results'>";

			$query = $this->con->prepare("SELECT * FROM users"); 
			//$query->bindValue(1, $new_hash, PDO::PARAM_STR);
			//$query->bindValue(2, $id, PDO::PARAM_INT);
			$query->execute();
			
			echo "<table class='table table-bordered'>";
			echo "<tr>
			<th>Avatar</th><th>User</th><th>Sex</th><th><span style='float:right;'>Actions</span></th>
			</tr>";

			while($row = $query->fetch(PDO::FETCH_ASSOC)){
				$query2 = $this->con->prepare("SELECT * FROM images WHERE owner = ? ORDER BY id DESC"); 
				$query2->bindValue(1, $row['id'], PDO::PARAM_INT);			
				$query2->execute();
				
				$row2 = $query2->fetch(PDO::FETCH_ASSOC);
				
				$image = 'images/user_images/'.$this->id."/".$row2['filename'];
				if(file_exists($image) && $row2['filename'] != ''){
					$image = "images/user_images/".$this->id."/".$row2['filename'];
				}else{
					$image = "images/avatar.gif";
				}
				
				echo "<tr>
				<td width='10%'>
					<img src='$image' width='50px;'/></td><td>".$row['user']."</td><td>".$row['sex']."
				</td>
				<td>
					<div style='float:right;'>
					<button id='make-favorite' onclick='make_favorite(".$row['id'].", ".$this->id.");' type='button' class='btn btn-default btn-lg'>
					  <span class='glyphicon glyphicon-star' aria-hidden='true'></span>
					</button>
					<button type='button' class='btn btn-default btn-lg'>
					  <span class='glyphicon glyphicon-envelope' aria-hidden='true'></span>
					</button>
					<button type='button' class='btn btn-default btn-lg'>
					  <span class='glyphicon glyphicon-comment' aria-hidden='true'></span>
					</button>
					<button type='button' class='btn btn-default btn-lg'>
					  <span class='glyphicon glyphicon-facetime-video' aria-hidden='true'></span>
					</button>
					</div>
				</td>
				</tr>";
			}

			echo "</table></div>
			</div>";
		}
		
		echo "</div>";
	}
	
	private function html_footer($target){
		echo "<div class='row-fluid' id='footer'>
		
		</div>";
	}
	
	private function hidden_variables($target){
		echo "<input type='hidden' id='user-id' value='".$this->id."'/>
		<input type='hidden' id='user-name' value='".$this->user_name."'/>";
	}
	
	private function js_packages($target){
		echo "<script type='text/javascript' src='bootstrap/js/bootstrap.js'></script>
		<script type='text/javascript' src='js/nav.js'></script>
		<!--<script type='text/javascript' src='js/timeout.js'></script>-->";
		
		if($target == 'profile'){
			echo "<script type='text/javascript' src='js/profile.js'></script>
			<script type='text/javascript' src='js/drag_and_drop.js'></script>";
		}
		
		if($target == 'home'){
			if(isset($_GET['subpage'])){
				if($_GET['subpage'] == 'video'){
					echo "<script src='SimpleWebRTC-master/latest.js'></script>
					<script src='js/simpleRTC.js'></script>";
				}elseif($_GET['subpage'] == 'chat_rooms'){

				}
			}
		}
		
		if($target == 'search'){
			echo "<script src='js/action_buttons.js'></script>";
		}
		
		if($target == 'imagecrop'){
			echo "<script src='js/croppic/croppic.min.js'></script>
			<script src='js/croppic/croppic.js'></script>";
		}
	}
	
	private function session_hash(){
		$new_hash = $this->generate_hash();
		
		$query = $this->con->prepare("UPDATE users SET session_hash = ?, last_ip = ? WHERE id = ?");
		$query->bindValue(1, $new_hash, PDO::PARAM_STR);
		$query->bindValue(2, $this->ip, PDO::PARAM_STR);
		$query->bindValue(3, $this->id, PDO::PARAM_INT);
		$query->execute();
		
		$_SESSION['HASH'] = $new_hash;
		$this->hash = $new_hash;
		
		//END SESSION HASH/
	}
	
	//This generates 255 character hash...
	private function generate_hash(){
		$charset='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
		$str = '';
		$length = 255;
		$count = strlen($charset);
		while ($length--) {
			$str .= $charset[mt_rand(0, $count-1)];
		}
		$hash = $str;
		
		return $hash;
	//END OF GENERATE HASH
	}
	
	//END CONSTRUCTUSERCLASS/
}

?>
