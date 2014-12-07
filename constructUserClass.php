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
	private $image_bank_x = array();
	private $image_bank_y = array();
	private $image_bank_w = array();
	private $image_bank_h = array();
	private $favs_bank = array();
	private $favs_bank_id = array();
	
	function __construct($page){
		//Start session.
		session_start();
		
		//Assign PDO to hidden variable.
		$this->con = new PDO('mysql:host=localhost;dbname=botcry5_date;charset=utf8', 'botcry5_trader', 'traderb0tz', array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
			
		if (!$this->con)
		{
			die('Could not connect: ' . mysql_error());
		}
		
		//Create session cookie message to hackers.
		$_SESSION['HACKERS'] =  'I am not your enemy, but attacking this site will be a waste of time for you.  There are much easier targets, I know...';
		
		//Assign session information from previous page.
		$this->hash = $_SESSION['HASH'];
		$this->id = $_SESSION['ID'];
		$this->target = $page;
		$this->ip = $_SERVER['REMOTE_ADDR'];
		
		//Make sure user has appropriate directories.
		if (!file_exists('images/user_images/'.$this->id)) 
		{
			mkdir('images/user_images/'.$this->id, 0777, true);
			mkdir('images/user_images/'.$this->id.'/encrypted', 0777, true);
			mkdir('images/user_images/'.$this->id.'/encrypted_th', 0777, true);
		}
		
		//Pull database information and assign variables to be used later.
		$query = $this->con->prepare("SELECT * FROM users WHERE id = ?");
		$query->bindValue(1, $this->id, PDO::PARAM_INT);
		$query->execute();

		$row = $query->fetch(PDO::FETCH_ASSOC);
		
		$this->sex = $row['sex'];
		$this->user_name = $row['user'];
		
		//This allows us to have my user profile and to look at other users profiles/
		if(isset($_GET['access'])){
			$image_id = $_GET['access'];
		}else{
			$image_id = $this->id;
		}

		//This build image bank for user and assigns to array for later use/
		$query2 = $this->con->prepare("SELECT * FROM images WHERE owner = ? ORDER BY ID DESC");
		$query2->bindValue(1, $image_id, PDO::PARAM_INT);
		$query2->execute();
		
		while($row2 = $query2->fetch(PDO::FETCH_ASSOC)){
			$this->image_bank[] = $row2['filename'];
			$this->image_bank_id[] = $row2['id'];
			$this->image_bank_x[] = $row2['x_coords'];
			$this->image_bank_y[] = $row2['y_coords'];
			$this->image_bank_w[] = $row2['w_coords'];
			$this->image_bank_h[] = $row2['h_coords'];
		}
		
		//This build favorites bank for user and assigns to array for later use/
		$query3 = $this->con->prepare("SELECT * FROM favs WHERE fav_owner = ?");
		$query3->bindValue(1, $this->id, PDO::PARAM_INT);
		$query3->execute();
		
		while($row3 = $query3->fetch(PDO::FETCH_ASSOC)){
			$this->favs_bank[] = $row3['type'];
			$this->favs_bank_id[] = $row3['fav_id'];
		}
		
		if($row['session_hash'] == $this->hash){
			$this->session_hash();
			
			//Standard HTML Header....
			echo "<!DOCTYPE html>
			<html lang='en'><head>
			<meta charset='utf-8'>
			<title>One-Meet</title>
			<meta name='viewport' content='width=device-width, initial-scale=1.0'>
			<meta name='description' content=''>
			<meta name='author' content=''>
			<script src='js/jquery/jquery.min.js'></script>
			<script src='js/jquery/jquery-ui-1.9.2.custom.js'></script>";
		
		
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
			echo "<body style='background: url(\"js/jquery-ui-custom/images/ui-bg_fine-grain_75_c6caf8_60x60.png\");'><div class='container-fluid' id='master-node'>";
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
		<link href='bootstrap/css/bootstrap.css' rel='stylesheet'>
		<link href='css/jquery-ui-1.9.2.custom.css' rel='stylesheet'>
		<link href='css/master.css' rel='stylesheet'>  ";
		
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
		<nav class='navbar navbar-default' role='navigation'>
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

		</div>";
	}
	
	///////BODY////////
	private function html_body($target){
		echo "<div class='row-fluid' id='body'>";
		//WINDOW ELEMENTS/
		
		echo "<div id='mail-window' style='display:none;'>
		<table class='table table-bordered'><tr><td>Sender:</td><td id='sender-name'></td></tr><tr><td>Receiver:</td><td id='receiver-name'></td></tr><tr><td>Subject:</td><td>dfgsdfg</td></tr></table>
		<table>
		<tr>
		<td>
		<textarea style='resize:none;width:511px;height:340px;' name='addinfo' id='info'></textarea>
		</td>
		</tr>
		</table>
		</div>";
		
		echo "<div id='settings-window' style='display:none;'>
		Automatically accept mail requests
		</br>
		Automatically accept chat requests
		</br>
		Automatically accept video requests
		</div>";
		
		echo "<div id='receive-mail-window' style='display:none;'>
		</div>";
		//BODY HOME....................
		if($target == 'home'){
			echo "<div class='col-md-2' id='stats'>";
			
			if($_GET['subpage'] != 'views'){
				echo "<div><a href='index.php?logged=yes&page=home&subpage=views'><button style='width:100%;' class='btn btn-default'>Views</button></a></div>";
			}else{
				echo "<div><button style='width:100%;' class='btn btn-default'>Views</button></div>";
			}
			
			if($_GET['subpage'] != 'favorites'){
				echo "<div><a href='index.php?logged=yes&page=home&subpage=favorites'><button style='width:100%;' class='btn btn-default'>Favorites</button></a></div>";
			}else{
				echo "<div><button style='width:100%;' class='btn btn-default'>Favorites</button></div>";
			}
			
			if($_GET['subpage'] != 'chat_rooms'){
				echo "<div><a href='index.php?logged=yes&page=home&subpage=chat_rooms'><button style='width:100%;' class='btn btn-default'>Chat Rooms</button></a></div>";
			}else{
				echo "<div><button style='width:100%;' class='btn btn-default'>Chat Rooms</button></div>";
			}
			
			if($_GET['subpage'] != 'video'){
				echo "<div><a href='index.php?logged=yes&page=home&subpage=video'><button style='width:100%;' class='btn btn-default'>Video</button></a></div>";
			}else{
				echo "<div><button style='width:100%;' class='btn btn-default'>Video</button></div>";	
			}
			
			if(isset($_GET['subpage'])){
			echo "<div class='col-md-12' id='video-favorites'><center>Favorites</center></br>";
				$favs_bank_count = count($this->favs_bank);

				for($i=0; $i < $favs_bank_count; $i++){
					$query = $this->con->prepare("SELECT * FROM users WHERE id = ?");
					$query->bindValue(1, $this->favs_bank_id[$i], PDO::PARAM_INT);
					$query->execute();

					$row = $query->fetch(PDO::FETCH_ASSOC);
					
					if($this->favs_bank[$i] < 2){
						$message_disabler = 'disabled';
					}else{
						$message_disabler = '';
					}
					
					if($this->favs_bank[$i] < 4){
						$chat_disabler = 'disabled';
					}else{
						$chat_disabler = '';
					}
					
					if($this->favs_bank[$i] < 6){
						$video_disabler = 'disabled';
					}else{
						$video_disabler = '';
					}
					
					//USER INTERACTIONS/
					echo '<div class="dropdown clearfix"><button style="width:100%;"class="btn btn-default dropdown-toggle" type="button" id="fav-dropdown'.$row['user'].'" data-toggle="dropdown" aria-expanded="true>
					<span class="carat"></span>'.$row['user'].'</button>
					<ul class="dropdown-menu" role="menu" aria-labelledby="fav-dropdown'.$row['user'].'">
					  <li role="presentation"><button onclick="open_message('.$this->favs_bank_id[$i].', \''.$row['user'].'\', \''.$this->user_name.'\');" style="width:100%" class="btn btn-default '.$message_disabler.'">Message</button></li>
					  <li role="presentation"><button onclick="open_chat(\''.$row['user'].'\');" style="width:100%" class="btn btn-default '.$chat_disabler.'">Open Chat</button></li>
					  <li role="presentation"><button onclick="open_video('.$this->favs_bank_id[$i].');" style="width:100%" class="btn btn-default '.$video_disabler.'">Video</button></li>
					</ul></div>';
				}
				echo "</div>";
}
			echo "</div>";
			
			if(isset($_GET['subpage'])){
				if($_GET['subpage'] == 'views'){
					echo "<div class='col-md-10' id='views'>";
					$query = $this->con->prepare("SELECT * FROM views WHERE viewed_id = ?"); 
					$query->bindValue(1, $this->id, PDO::PARAM_INT);
					$query->execute();
					
					$count = $query->rowCount();
					
					if($count > 0){
						echo "<table class='table table-bordered'>";
						echo "<tr>
						<th>Avatar</th><th>User</th><th>Sex</th><th><span style='float:right;'>Actions</span></th>
						</tr>";
						
						while($row = $query->fetch(PDO::FETCH_ASSOC)){
							$this->user_row($row['viewer_id']);
						}

						echo "</table>";
					}
						echo "</div>";
					
					}elseif($_GET['subpage'] == 'favorites'){
						echo "<div class='col-md-10' id='favorites'>";
						
						$query = $this->con->prepare("SELECT * FROM favs WHERE fav_owner = ?");
						$query->bindValue(1, $this->id, PDO::PARAM_INT);
						$query->execute();
						
						echo "<table class='table table-bordered'>";
						while($row = $query->fetch(PDO::FETCH_ASSOC)){
							
							$query2 = $this->con->prepare("SELECT * FROM users WHERE id = ?");
							$query2->bindValue(1, $row['fav_id'], PDO::PARAM_INT);
							$query2->execute();
							$row2 = $query2->fetch(PDO::FETCH_ASSOC);
						
							echo "<tr>
							<td>
							".$row2['user']."
							</td>
							</tr>";
						}
						echo "</table>";
					
					
					
					echo "</div>";
				}elseif($_GET['subpage'] == 'chat_rooms'){
					echo "<div class='col-md-10' id='chat-rooms'>
					</div><div class='col-md-10' id='chat-input'>
					<input class='form-control' id='send-message' type='text' style='width:96.5%;margin-left:-.3%;' class='input-group input-group-lg' placholder='Message' />
					<button style='float:right;margin-top:-2.2%' id='button-send-message' onclick='send_message();' class='btn btn-default'>Send</button>
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
		
		//BODY PROFILE.......................
		if($target == 'profile'){
			
			if(isset($_GET['access'])){
				$profile_id = $_GET['access'];
			}else{
				$profile_id = $this->id;
			}

			$image_bank_count = count($this->image_bank);
			if(isset($this->image_bank[0])){
				$image_main = 'images/user_images/'.$profile_id.'/'.$this->image_bank[0].'';
			}else{
				$image_main = 'images/avatar.gif';
			}

			for($i=0; $i < $image_bank_count; $i++){
				$image_stream .= '<div ondrop="drop(event)" ondragover="allowDrop(event)"><a href="index.php?logged=yes&page=imagecrop&imageid='.$this->image_bank_id[$i].'"><img id="extra-images" src="images/user_images/'.$profile_id.'/'.$this->image_bank[$i].'" draggable="true" ondragstart="drag(event)"/></a></div>';
			}
			
			if(isset($_GET['access'])){
				$id = $_GET['access'];
				
				$query = $this->con->prepare("SELECT * FROM users WHERE id = ?");
				$query->bindValue(1, $_GET['access'], PDO::PARAM_INT);
				$query->execute();
				
				$row = $query->fetch(PDO::FETCH_ASSOC);
				
				//This adds to views table if user checks out another user's profile/
				$query2 = $this->con->prepare("INSERT INTO views SET viewer_id = ?, viewed_id = ? ON DUPLICATE KEY UPDATE time_stamp = NOW()");
				$query2->bindValue(1, $this->id, PDO::PARAM_INT);
				$query2->bindValue(2, $_GET['access'], PDO::PARAM_INT);
				$query2->execute();
				
				$display_name = $row['user'];
			}else{
				$id = $this->id;
				$display_name = $this->user_name;
			}

			echo "<div class='col-md-12'><div class='col-md-3'>Id: ".$id."</br>User: ".$display_name."</div></div>

			<div class='col-md-2'><div style='overflow:hidden;width:".$this->image_bank_w[0]."px;'><img styl='margin-left:-".$this->image_bank_x[0]."px;' id='profile-image' src='$image_main' /></div></div>
			
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
		
		//BODY IMAGECROP...............
		if($target == 'imagecrop'){
			
			$key = array_search($_GET['imageid'], $this->image_bank_id);
			$file = $this->image_bank[$key];
					
			echo "<div class='col-md-12'>
			
			<center><button onclick='crop(".$_GET['imageid'].");' class='btn btn-default'>Crop</button></center>
			
			<center><img id='crop-this-image' src='images/user_images/".$this->id."/".$file."' /></center>
			</div>
			<p>The cropped image</p>
			<center><div style='overflow:hidden;width:".$this->image_bank_w[$key]."px;height:".$this->image_bank_h[$key]."px;'><img id='cropped-image' style='margin-left:-".$this->image_bank_x[$key]."px;margin-top:-".$this->image_bank_y[$key]."px;' src='images/user_images/".$this->id."/".$file."' /></div></center>";
		}
		
		//BODY MATCHES................
		if($target == 'matches'){
			echo "<div class='col-md-12' id='matches'>
			<div class='col-md-4' id='pic-1'>PICTURE ONE</div>
			<div class='col-md-4' id='matching-chars'>MATCHING CHARACTERISTICS</div>
			<div class='col-md-4' id='pic-2'>PICTURE TWO</div>
			</div>";
		}
		
		
		//BODY SEARCH...................
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

			$query = $this->con->prepare("SELECT * FROM users WHERE id != ?"); 
			$query->bindValue(1, $this->id, PDO::PARAM_INT);
			$query->execute();
			
			echo "<table class='table table-bordered'>";
			echo "<tr>
			<th>Avatar</th><th>User</th><th>Sex</th><th><span style='float:right;'>Actions</span></th>
			</tr>";

			while($row = $query->fetch(PDO::FETCH_ASSOC)){
				$this->user_row($row['id']);
			}

			echo "</table></div>
			</div>";
		}
		
		echo "</div>";
	}
	
	/////FOOTER///////
	private function html_footer($target){
		echo "<div class='row-fluid' id='footer'>
		
		</div>";
	}
	
	///////HIDDEN VARIABLES////////
	private function hidden_variables($target){
		//UNIVERSAL HIDDEN VARIABLES/
		echo "<input type='hidden' id='user-id' value='".$this->id."'/>
		<input type='hidden' id='user-name' value='".$this->user_name."'/>";
		
		//HOME VARIABLES/
		if($target == 'home'){
			if(isset($_GET['subpage'])){
				if($_GET['subpage'] == 'video'){
					if(isset($_GET['join-room'])){
						echo "<input type='hidden' id='join-room' value='".$_GET['join-room']."' />";
					}else{
						echo "<input type='hidden' id='join-room' value='".$this->id."' />";
					}
				}elseif($_GET['subpage'] == 'chat_rooms'){
					if(isset($_GET['chatroom'])){
						echo "<input type='hidden' id='join-room' value='".$_GET['chatroom']."' />";
					}else{
						echo "<input type='hidden' id='join-room' value='".$this->user_name."' />";
					}
				}
			}
			
		}
		
		//IMAGECROP VARIABLES/
		if($target == 'imagecrop'){
			echo "<input type='hidden' id='x-coords' />
			<input type='hidden' id='y-coords' />
			<input type='hidden' id='width-coords' />
			<input type='hidden' id='height-coords' />";
		}
	}
	
	private function js_packages($target){
		//UNIVERSAL JS PACKAGES/
		echo "<script type='text/javascript' src='bootstrap/js/bootstrap.js'></script>
		<script type='text/javascript' src='js/nav.js'></script>
		<!--<script type='text/javascript' src='js/timeout.js'></script>-->";
		
		//PROFILE PACKAGES/
		if($target == 'profile'){
			echo "<script type='text/javascript' src='js/profile.js'></script>
			<script type='text/javascript' src='js/drag_and_drop.js'></script>";
		}
		
		//HOME PACKAGES/
		if($target == 'home'){
			if(isset($_GET['subpage'])){
				echo "<script src='js/user_interactions.js'></script>";
				if($_GET['subpage'] == 'video'){
					echo "<script src='SimpleWebRTC-master/latest.js'></script>
					<script src='js/simpleRTC.js'></script>
					";
				}elseif($_GET['subpage'] == 'chat_rooms'){
					echo "<script src='js/chat.js'></script>";
				}elseif($_GET['subpage'] == 'views'){
					echo "<script src='js/action_buttons.js'></script>
					<script src='js/search.js'></script>";
				}
			}
		}
		
		//SEARCH PACKAGES/
		if($target == 'search'){
			echo "<script src='js/action_buttons.js'></script>
			<script src='js/search.js'></script>";
		}
		
		//IMAGECROP PACKAGES/
		if($target == 'imagecrop'){
			echo "<script src='js/cropper.min.js'></script>
			<script src='js/crop_image.js'></script>";
		}
	}
	
	private function user_row($id){
				$query = $this->con->prepare("SELECT * FROM users WHERE id = ?"); 
				$query->bindValue(1, $id, PDO::PARAM_INT);			
				$query->execute();
				
				$row = $query->fetch(PDO::FETCH_ASSOC);
				
				$query2 = $this->con->prepare("SELECT * FROM images WHERE owner = ? ORDER BY id DESC"); 
				$query2->bindValue(1, $id, PDO::PARAM_INT);			
				$query2->execute();
				
				$row2 = $query2->fetch(PDO::FETCH_ASSOC);
				
				$image = 'images/user_images/'.$id."/".$row2['filename'];
				if(file_exists($image) && $row2['filename'] != ''){
					$image = "images/user_images/".$id."/".$row2['filename'];
				}else{
					$image = "images/avatar.gif";
				}
				
				$query3 = $this->con->prepare("SELECT * FROM favs WHERE fav_owner = ? && fav_id = ?"); 
				$query3->bindValue(1, $this->id, PDO::PARAM_INT);	
				$query3->bindValue(2, $row['id'], PDO::PARAM_INT);			
				$query3->execute();
				
				$count3 = $query3->rowCount();
				$row3 = $query3->fetch(PDO::FETCH_ASSOC);
				
					////////ACTION BUTTONS////////
					if($row3['type'] == 0){
						$favorite = 
						"<button id='make-favorite".$row['id']."' onclick='make_favorite(".$row['id'].", 1);' type='button' class='btn btn-default btn-lg'>
						  <span class='glyphicon glyphicon-star' aria-hidden='true'></span>
						</button>";
					}elseif($row3['type'] >= 1){
						$favorite = 
						"<button id='made-favorite".$row['id']."' type='button' class='btn btn-success btn-lg'>
						  <span class='glyphicon glyphicon-star' aria-hidden='true'></span>
						</button>";
					}
					
					
					
					if($row3['type'] <= 1){
						$message = 
						"<button id='request-message".$row['id']."' onclick='make_favorite(".$row['id'].", 2);' type='button' class='btn btn-default btn-lg'>
						  <span class='glyphicon glyphicon-envelope' aria-hidden='true'></span>
						</button>";
					}elseif($row3['type'] <= 2){
						$message = 
						"<button id='request-message".$row['id']."' onclick='make_favorite(".$row['id'].", 2);' type='button' class='btn btn-warning btn-lg'>
						  <span class='glyphicon glyphicon-envelope' aria-hidden='true'></span>
						</button>";
					}elseif($row3['type'] >= 3){
						$message = 
						"<button id='request-message".$row['id']."' type='button' class='btn btn-success btn-lg'>
						  <span class='glyphicon glyphicon-envelope' aria-hidden='true'></span>
						</button>";
					}
					
					if($row3['type'] <= 3){
						$chat = 
						"<button id='request-message".$row['id']."' onclick='make_favorite(".$row['id'].", 4);' type='button' class='btn btn-default btn-lg'>
						  <span class='glyphicon glyphicon-comment' aria-hidden='true'></span>
						</button>";
					}elseif($row3['type'] <= 4){
						$chat = 
						"<button id='request-message".$row['id']."' onclick='make_favorite(".$row['id'].", 4);' type='button' class='btn btn-warning btn-lg'>
						  <span class='glyphicon glyphicon-comment' aria-hidden='true'></span>
						</button>";
					}elseif($row3['type'] >= 5){
						$chat = 
						"<button id='request-message".$row['id']."' type='button' class='btn btn-success btn-lg'>
						  <span class='glyphicon glyphicon-comment' aria-hidden='true'></span>
						</button>";
					}
					
					if($row3['type'] <= 5){
						$video = 
						"<button id='request-message".$row['id']."' onclick='make_favorite(".$row['id'].", 6);' type='button' class='btn btn-default btn-lg'>
						  <span class='glyphicon glyphicon-facetime-video' aria-hidden='true'></span>
						</button>";
					}elseif($row3['type'] <= 6){
						$video = 
						"<button id='request-message".$row['id']."' onclick='make_favorite(".$row['id'].", 6);' type='button' class='btn btn-warning btn-lg'>
						  <span class='glyphicon glyphicon-facetime-video' aria-hidden='true'></span>
						</button>";
					}elseif($row3['type'] >= 7){
						$video = 
						"<button id='request-message".$row['id']."' type='button' class='btn btn-success btn-lg'>
						  <span class='glyphicon glyphicon-facetime-video' aria-hidden='true'></span>
						</button>";
					}
					//END ACTION BUTTONS/
				
				echo "<tr>
				<td width='10%' onclick='nav_profile(".$row['id'].");'>
					<img src='$image' width='50px;'/></td><td onclick='nav_profile(".$row['id'].");'>".$row['user']."</td><td onclick='nav_profile(".$row['id'].");'>".$row['sex']."
				</td>
				<td>
					<div style='float:right;'>
					".$favorite."
					".$message."
					".$chat."
					".$video."
					</div>
				</td>
				</tr>";
	}
	
	//SESSION HASH/
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
