<?php

class LoggedHomeCtrl extends BaseController {
	//Blockchain
	public $blockchain;
	public $btc_address;
	public $btc_balance = 0;
	public $btc_txs = 0;
	public $btc_total_received = 0;
	public $btc_total_sent = 0;
	
	//Coinbase
	private $coinbase_key = 'PUVYS9Cz18qAH4SO';
	private $coinbase_secret = 'KngZUtf3UDRsc5LF02nDTVUOkJJFKhKX';
	public $coinbase_price;
	
	//Public Variables/
	public $todays_date;
	public $id;
	public $session_hash;
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
	public $new_mail_count;
	public $auto_mail;
	public $auto_chat;
	public $auto_video;
	
	//Tags
	public $iam1;
	public $iam2;
	public $iam3;
	public $iam4;
	public $iam5;
	public $lookingfor1;
	public $lookingfor2;
	public $lookingfor3;
	public $lookingfor4;
	public $lookingfor5;
	public $canprovide1;
	public $canprovide2;
	public $canprovide3;
	public $canprovide4;
	public $canprovide5;
	public $near1;
	public $near2;
	public $near3;
	public $near4;
	public $near5;
	
	//Professions
	public $professions = array('All', 'Family Medicine', 'Hospitalist', 'Pediatrics', 'Not Specified');
	public $sub_professions = array('All', 'Adult', 'Not Specified');
	
	//Communication variables/
	public $room;
	
	//Navigation variables
	public $nav_variables;
	public $escape;
	
	//data arrays
	public $new_mail_array = array();
	public $user_rows = array();
	
	public function __construct(){
		include('blockchainClass.php');
		//$this->blockchain = new blockchainClass();
		$this->id = Session::get('MYSESSION');
		$this->session_hash = Session::get('MYHASH');
		$this->ip = $_SERVER['REMOTE_ADDR'];
		
		//require_once("Coinbase.php");
		//$coinbase = Coinbase::withApiKey($this->coinbase_key, $this->coinbase_secret);
		//$this->coinbase_price = $coinbase->getBuyPrice('1');
		
		$user = Users::find($this->id);
		$this->user_name = $user->user;
		$this->sex = $user->sex;
		$this->auto_mail = $user->auto_mail;
		$this->auto_chat = $user->auto_chat;
		$this->auto_video = $user->auto_video;
		$datetime = new DateTime('tomorrow');
		$this->todays_date = $datetime->format('Y-m-d');
		$this->btc_balance = $user->temp_coins / 100000000;
		
		//Set tags
		$this->iam1 = $user->iam1;
		$this->iam2 = $user->iam2;
		$this->iam3 = $user->iam3;
		$this->iam4 = $user->iam4;
		$this->iam5 = $user->iam5;
		$this->lookingfor1 = $user->lookingfor1;
		$this->lookingfor2 = $user->lookingfor2;
		$this->lookingfor3 = $user->lookingfor3;
		$this->lookingfor4 = $user->lookingfor4;
		$this->lookingfor5 = $user->lookingfor5;
		$this->canprovide1 = $user->canprovide1;
		$this->canprovide2 = $user->canprovide2;
		$this->canprovide3 = $user->canprovide3;
		$this->canprovide4 = $user->canprovide4;
		$this->canprovide5 = $user->canprovide5;
		$this->near1 = $user->near1;
		$this->near2 = $user->near2;
		$this->near3 = $user->near3;
		$this->near4 = $user->near4;
		$this->near5 = $user->near5;
		
		
		if($user->chat_room != ''){
			$user->update(array('chat_room'=>''));
		}
		
		$bitcoin_address = DB::table('blockchain_schema')->where('user_id', $this->id)->first();
		if($bitcoin_address){
			$this->btc_address = $bitcoin_address->address;
		}else{
			//$this->btc_address = $this->blockchain->generate_address($this->user_name, $this->id);
			//DB::table('blockchain_schema')->insert(array('user_id'=>$this->id, 'user'=>$this->user_name, 'address'=>$this->btc_address));
		}
		
		//$this->btc_balance = $this->blockchain->get_balance($this->btc_address);
		//$btc_info = json_decode(file_get_contents('https://blockchain.info/address/'.$this->btc_address.'?format=json'));
		//$this->btc_txs = $btc_info->n_tx;
		//$this->btc_total_received = $btc_info->total_received;
		//$this->btc_total_sent = $btc_info->total_sent;
		
		//Session Hashing/
		$old_hash = $user->session_hash;
		
		if($old_hash == $this->session_hash){
			$new_hash = Str::random(255);
			Users::where('id', '=', $this->id)->update(array('session_hash'=>$new_hash, 'last_ip'=>$this->ip));
			Session::put('MYHASH', $new_hash);
		}else{
			//die('Session hash mismatch.  Please login again.');
		}
		
		//This builds directory paths if they do not exist.
		if (!file_exists('/images/user_images/'.$this->id)) 
		{
			$path = public_path().'/images/user_images/'.$this->id;
			File::makeDirectory($path, $mode = 0777, true, true);
			$path2 = public_path().'/images/user_images/'.$this->id.'/encrypted';
			File::makeDirectory($path2, $mode = 0777, true, true);
			$path3 = public_path().'/images/user_images/'.$this->id.'/encrypted_th';
			File::makeDirectory($path3, $mode = 0777, true, true);
		}
		
		$mails = Mails::where('receiver_id', '=', $this->id);
		$this->new_mail_count = $mails->count();
		$this->new_mail_array = $mails->get();
		
		$build_array = array();
		foreach($this->new_mail_array as $mail_array){
			$to_user = Users::where('id', '=', $mail_array->receiver_id)->first();
			$from_user = Users::where('id', '=', $mail_array->sender_id)->first();
			
			$build_array = array_add($build_array, $mail_array->id,array(
					'id'=>$mail_array->id,
					'to_id'=>$mail_array->receiver_id,
					'to_name'=>$to_user->user,
					'from_id'=>$mail_array->sender_id, 
					'from_name'=>$from_user->user,
					'subject'=>$mail_array->subject, 
					'message'=>$mail_array->text,
					'created_at'=>$mail_array->created_at
				));
		}
		
		$this->new_mail_array = $build_array;
		
		//Preset settings buttons
		switch(true){
				case ($this->auto_mail == 0):
					$radio_mail_yes = "";
					$radio_mail_no = 'checked="checked"';
					break;
				default:
					$radio_mail_yes = 'checked="checked"';
					$radio_mail_no = '';
					break;
			}
			
			switch(true){
				case ($this->auto_chat == 0):
					$radio_chat_yes = "";
					$radio_chat_no = 'checked="checked"';
					break;
				default:
					$radio_chat_yes = 'checked="checked"';
					$radio_chat_no = '';
					break;
			}
			
			switch(true){
				case ($this->auto_video == 0):
					$radio_video_yes = "";
					$radio_video_no = 'checked="checked"';
					break;
				default:
					$radio_video_yes = 'checked="checked"';
					$radio_video_no = '';
					break;
			}
			
		$make_chatroom = DB::table('chat_rooms_schema')->where('owner_id', '=', $this->id)->where('type', '=', 'home')->first();
		
		
		//Makes sure that a personal chatroom is created for this user
		if(!$make_chatroom){
			$create_chatroom = Rooms::create(array('owner_id'=>$this->id, 'room_name'=>$this->user_name, 'type'=>'home'));
			$this->room = $create_chatroom->id;
		}else{
			$this->room = $make_chatroom->id;
		}
		
		//This sets global nav variables
		$this->nav_variables = array(
		'id'=>$this->id, 
		'session_hash'=>$this->session_hash, 
		'user_name'=>$this->user_name, 
		'new_mail_count'=>$this->new_mail_count,
		'btc_balance'=>$this->btc_balance,
		'btc_address'=>$this->btc_address,
		'btc_txs'=>$this->btc_txs,
		'btc_total_received'=>$this->btc_total_received,
		'btc_total_sent'=>$this->btc_total_sent,
		'coinbase_price'=>$this->coinbase_price,
		'room'=>$this->room,
		'radio_mail_yes'=>$radio_mail_yes,
		'radio_mail_no'=>$radio_mail_no,
		'radio_chat_yes'=>$radio_chat_yes,
		'radio_chat_no'=>$radio_chat_no,
		'radio_video_yes'=>$radio_video_yes,
		'radio_video_no'=>$radio_video_no,
		'todays_date'=>$this->todays_date,
		'iam1'=>$this->iam1,
		'iam2'=>$this->iam2,
		'iam3'=>$this->iam3,
		'iam4'=>$this->iam4,
		'iam5'=>$this->iam5,
		'lookingfor1'=>$this->lookingfor1,
		'lookingfor2'=>$this->lookingfor2,
		'lookingfor3'=>$this->lookingfor3,
		'lookingfor4'=>$this->lookingfor4,
		'lookingfor5'=>$this->lookingfor5,
		'canprovide1'=>$this->canprovide1,
		'canprovide2'=>$this->canprovide2,
		'canprovide3'=>$this->canprovide3,
		'canprovide4'=>$this->canprovide4,
		'canprovide5'=>$this->canprovide5,
		'near1'=>$this->near1,
		'near2'=>$this->near2,
		'near3'=>$this->near3,
		'near4'=>$this->near4,
		'near5'=>$this->near5);
		
		
		//This creates an array of the logged user's favorites.  This can be called on any page using this controller.
		$favs = DB::table('favs_schema')->where('fav_owner', $this->id)->get();
		foreach($favs as $fav){

			switch(true){
				case ($fav->type == 1):
					$button1 = "btn btn-success";
					break;
				default:
					$button1 = 'btn btn-default';
					break;
			}
			
			//This detects snail mail permissions between users
			$mails = DB::table('favmail_schema')->where('mail_owner', $this->id)->where('mail_id',$fav->fav_id)->first();
			$cross_mails = DB::table('favmail_schema')->where('mail_owner', $fav->fav_id)->where('mail_id', $this->id)->first();
			
			switch(true){
				case ($mails && $cross_mails):
					$button2 = "btn btn-success";
					$button2_perm = '';
					break;
				case ($mails && !$cross_mails):
					$button2 = "btn btn-warning";
					$button2_perm = 'disabled';
					break;
				case (!$mails && $cross_mails):
					$button2 = "btn btn-info";
					$button2_perm = 'disabled';
					break;
				default:
					$button2 = 'btn btn-default';
					$button2_perm = 'disabled';
					break;
			}
			
			//This detects chat permissions between users
			$chats = DB::table('favchat_schema')->where('chat_owner', $this->id)->where('chat_id',$fav->fav_id)->first();
			$cross_chats = DB::table('favchat_schema')->where('chat_owner', $fav->fav_id)->where('chat_id', $this->id)->first();
			
			switch(true){
				case ($chats && $cross_chats):
					$button3 = "btn btn-success";
					$button3_perm = '';
					break;
				case ($chats && !$cross_chats):
					$button3 = "btn btn-warning";
					$button3_perm = 'disabled';
					break;
				case (!$chats && $cross_chats):
					$button3 = "btn btn-info";
					$button3_perm = 'disabled';
					break;
				default:
					$button3 = 'btn btn-default';
					$button3_perm = 'disabled';
					break;
			}
			
			//This detects video permissions between users
			$videos = DB::table('favvideo_schema')->where('video_owner', $this->id)->where('video_id',$fav->fav_id)->first();
			$cross_videos = DB::table('favvideo_schema')->where('video_owner', $fav->fav_id)->where('video_id', $this->id)->first();
			
			switch(true){
				case ($videos && $cross_videos):
					$button4 = "btn btn-success";
					$button4_perm = '';
					break;
				case ($videos && !$cross_videos):
					$button4 = "btn btn-warning";
					$button4_perm = 'disabled';
					break;
				case (!$videos && $cross_videos):
					$button4 = "btn btn-info";
					$button4_perm = 'disabled';
					break;
				default:
					$button4 = 'btn btn-default';
					$button4_perm = 'disabled';
					break;
			}
			
			//This grabs user data of selected fav in loop
			$user_data = DB::table('users_schema')->where('id', $fav->fav_id)->first();
			$avatar = Images::where('owner', '=', $fav->fav_id)->first();
			
			//This grabs avatar data
			if($avatar['w_coords'] > 0 && $avatar['h_coords'] > 0){
				$width = $avatar['init_width'];
				$height = $avatar['init_height'];
					
				$resize_w = $width / $avatar['w_coords'];
				$resize_h = $height / $avatar['h_coords'];
						
				$resize_w2 = $avatar['w_coords'] / 50;
				$resize_h2 = $avatar['h_coords'] / 50;
					
				$x_calc = $avatar['x_coords'] / $resize_w2;
				$y_calc = $avatar['y_coords'] / $resize_h2;
					
				$w_calc = $avatar['w_coords'] * $resize_w / $resize_w2;
				$h_calc = $avatar['h_coords'] * $resize_h / $resize_h2;
				
			}else{
				$w_calc = $avatar['init_width'];
				$h_calc = $avatar['init_height'];
				
				$x_calc = 0;
				$y_calc = 0;
			}
			
			if($avatar){
				$avatar_file = "user_images/".$avatar['id']."/".$avatar['filename'];
			}else{
				$avatar_file = 'avatar.gif';
				$w_calc = 50;
				$h_calc = 50;
			}
			
			$profile_style = 'margin-left:-'.$x_calc.'px;margin-top:-'.$y_calc.'px;height:'.$h_calc.'px;width:'.$w_calc.'px;';
			
			
			//This determines when the selected fav last login time was and if they are currently online or not
			if($user_data){
				$last_login = new DateTime($user_data->updated_at);
				$now = new DateTime();
				$obj_diff = $last_login->diff($now);
				$diff = $obj_diff->format("Last seen %d days, %h hours and %i minutes ago");
				$years_diff = $obj_diff->y;
				$months_diff = $obj_diff->m;
				$days_diff = $obj_diff->d;
				$hours_diff = $obj_diff->h;
				$mins_diff = $obj_diff->i;
				
				if($mins_diff < 6  && $hours_diff < 1 && $days_diff < 1 && $months_diff < 1 && $years_diff < 1){
					$online = 1;
					$html_style = 'btn btn-success';
				}elseif($mins_diff >= 6 && $mins_diff < 15  && $hours_diff < 1 && $days_diff < 1 && $months_diff < 1 && $years_diff < 1){
					$online = 1;
					$html_style = 'btn btn-warning';
				}else{
					$online = 0;
					$html_style = 'btn btn-danger';
				}
				
				//Gotta pass this shit to the view, lets build a clever array for this...
				$this->user_rows = array_add($this->user_rows, $fav->fav_id,array(
					'id'=>$user_data->id,
					'user'=>$user_data->user, 
					'sex'=>$user_data->sex, 
					'login_diff'=>$diff, 
					'online'=>$online, 
					'online_style'=>$html_style, 
					'fav_type'=>$fav->type,
					'button1'=>$button1,
					'button2'=>$button2,
					'button2_perm'=>$button2_perm,
					'button3'=>$button3,
					'button3_perm'=>$button3_perm,
					'button4'=>$button4,
					'button4_perm'=>$button4_perm,
					'filename'=>$avatar_file,
					'profile_style'=>$profile_style
				));
			}else{
				//This should never execute, but if it does than the loop has gone too far for some reason...
				$this->user_rows = array_add($this->user_rows, $fav->fav_id,array('id'=>'N/A', 'user'=>'ROW ERROR', 'login_diff'=>'Not logged in', 'online_style'=>'btn btn-default'));
			}
		}
	}
	//Main Pages/
	public function get_home_logged()
	{
		
		return View::make('logged.index.home', $this->nav_variables
		)->with('mail_rows', $this->new_mail_array)
		->with('fav_rows', $this->user_rows);
	}
	
	public function sotosholy($id)
	{
		$sotosholy = Sotosholy::find($id);
		
		$user1 = Users::find($sotosholy->player1);
		
		if($sotosholy->player2 != 0){
			$user2 = Users::find($sotosholy->player2);
			$user2_name = $user2->user;
		}else{
			$user2_name = 'Open';
		}
		
		if($sotosholy->player3 != 0){
			$user3 = Users::find($sotosholy->player3);
			$user3_name = $user3->user;
		}else{
			$user3_name = 'Open';
		}
		
		if($sotosholy->player4 != 0){
			$user4 = Users::find($sotosholy->player4);
			$user4_name = $user4->user;
		}else{
			$user4_name = 'Open';
		}
		
		$sotosholy_array = array('id'=>$id, 'max_players'=>$sotosholy->max_players, 'bounty'=>$sotosholy->bounty, 'player1'=>$sotosholy->player1, 'player1_name'=>$user1->user, 'player2'=>$sotosholy->player2, 'player2_name'=>$user2_name, 'player3'=>$sotosholy->player3, 'player3_name'=>$user3_name, 'player4'=>$sotosholy->player4, 'player4_name'=>$user4_name, 'player1_balance'=>$sotosholy->player1_balance, 'player2_balance'=>$sotosholy->player2_balance, 'player3_balance'=>$sotosholy->player3_balance, 'player4_balance'=>$sotosholy->player4_balance, 'player1_property'=>$sotosholy->player1_property, 'player2_property'=>$sotosholy->player2_property, 'player3_property'=>$sotosholy->player3_property, 'player4_property'=>$sotosholy->player4_property);
		
		return View::make('logged.index.sotosholy', $this->nav_variables
		)->with('mail_rows', $this->new_mail_array)
		->with('fav_rows', $this->user_rows)
		->with('sotosholy', $sotosholy_array);
	}
	
	//Profile
	public function get_home_profile()
	{	
		//Lets grab some image data for the profile image
		$profile_style = '';
		$profile_image = Images::where('owner', '=', $this->id);
		$image = $profile_image->first();
		
		if($image){
				
			if($image['w_coords'] > 0 && $image['h_coords'] > 0){	
				$width = $image['init_width'];
				$height = $image['init_height'];
				
				$resize_w = $width / $image['w_coords'];
				$resize_h = $height / $image['h_coords'];
					
				$resize_w2 = $image['w_coords'] / 300;
				$resize_h2 = $image['h_coords'] / 300;
				
				$x_calc = $image['x_coords'] / $resize_w2;
				$y_calc = $image['y_coords'] / $resize_h2;
				
				$w_calc = $image['w_coords'] * $resize_w / $resize_w2;
				$h_calc = $image['h_coords'] * $resize_h / $resize_h2;
				
				$profile_style = 'margin-left:-'.$x_calc.'px;margin-top:-'.$y_calc.'px;height:'.$h_calc.'px;width:'.$w_calc.'px;';
			
			}
			
			$pass_image = array('filename'=>"user_images/".$this->id."/".$image['filename'], 'profile_style'=>$profile_style);
		}else{
			$pass_image = array('filename'=>'avatar.gif', 'profile_style'=>$profile_style);
		}
		//Now we need to grab all image rows to be displayed in reel
		$reel_images = Images::where('owner', '=', $this->id);
		$reel = $reel_images->get();
		
		$master_reel = array();
		
		foreach($reel as $image){
			
			//This is clever CSS trick for formatting images based on coordinates(coordinates acquired from cropping function)
			if($image->w_coords > 0 && $image->h_coords > 0){
				$width = $image->init_width;
				$height = $image->init_height;
					
				$resize_w = $width / $image->w_coords;
				$resize_h = $height / $image->h_coords;
						
				$resize_w2 = $image->w_coords / 300;
				$resize_h2 = $image->h_coords / 300;
					
				$x_calc = $image->x_coords / $resize_w2;
				$y_calc = $image->y_coords / $resize_h2;
					
				$w_calc = $image->w_coords * $resize_w / $resize_w2;
				$h_calc = $image->h_coords * $resize_h / $resize_h2;
			}else{
				$w_calc = $image->init_width;
				$h_calc = $image->init_height;
				
				$x_calc = 0;
				$y_calc = 0;
			}
			
			//Lets build our master array containing the image reel containing an array of images
			$master_reel = array_add($master_reel, $image->id, array('id'=>$image->id,'owner'=>$image->owner, 'filename'=>$image->filename, 'x_coords'=>$image->x_coords, 'y_coords'=>$image->y_coords, 'h_coords'=>$image->h_coords, 'w_coords'=>$image->w_coords, 'h_calc'=>$h_calc, 'w_calc'=>$w_calc, 'x_calc'=>$x_calc, 'y_calc'=>$y_calc));
		}
		

		//Return the shit to the view
		return View::make('logged.index.profile', $this->nav_variables
		)->with('image_main',$pass_image)
		->with('master_reel',$master_reel)
		->with('mail_rows', $this->new_mail_array);
	}
	
	//This is a proxy page for viewing other users profiles...  It is very similar to the personal profile...
	public function get_home_profile_proxy($proxy_id)
	{	
		$view_logger = Views::firstOrCreate(array('viewer_id' => $this->id, 'viewed_id' => $proxy_id));
		
		$profile_style = '';
		$profile_image = Images::where('owner', '=', $proxy_id);
		
		$user = DB::table('users_schema')->where('id', '=', $proxy_id)->first();
		$favs =  DB::table('favs_schema')->where('fav_owner', $this->id)->where('fav_id',$user->id)->first();
		
		$iam1_proxy = $user->iam1;
		$iam2_proxy = $user->iam2;
		$iam3_proxy = $user->iam3;
		$iam4_proxy = $user->iam4;
		$iam5_proxy = $user->iam5;
		$lookingfor1_proxy = $user->lookingfor1;
		$lookingfor2_proxy = $user->lookingfor2;
		$lookingfor3_proxy = $user->lookingfor3;
		$lookingfor4_proxy = $user->lookingfor4;
		$lookingfor5_proxy = $user->lookingfor5;
		$canprovide1_proxy = $user->canprovide1;
		$canprovide2_proxy = $user->canprovide2;
		$canprovide3_proxy = $user->canprovide3;
		$canprovide4_proxy = $user->canprovide4;
		$canprovide5_proxy = $user->canprovide5;
		$near1_proxy = $user->near1;
		$near2_proxy = $user->near2;
		$near3_proxy = $user->near3;
		$near4_proxy = $user->near4;
		$near5_proxy = $user->near5;
			
			switch(true){
				case ($favs):
					$button1 = "btn btn-success";
					break;
				default:
					$button1 = 'btn btn-default';
					break;
			}
			
			$mails = DB::table('favmail_schema')->where('mail_owner', $this->id)->where('mail_id',$user->id)->first();
			$cross_mails = DB::table('favmail_schema')->where('mail_owner', $user->id)->where('mail_id', $this->id)->first();
			
			switch(true){
				case ($mails && $cross_mails):
					$button2 = "btn btn-success";
					break;
				case ($mails && !$cross_mails):
					$button2 = "btn btn-warning";
					break;
				case (!$mails && $cross_mails):
					$button2 = "btn btn-info";
					break;
				default:
					$button2 = 'btn btn-default';
					break;
			}
			
			$chats = DB::table('favchat_schema')->where('chat_owner', $this->id)->where('chat_id',$user->id)->first();
			$cross_chats = DB::table('favchat_schema')->where('chat_owner', $user->id)->where('chat_id', $this->id)->first();
			
			switch(true){
				case ($chats && $cross_chats):
					$button3 = "btn btn-success";
					break;
				case ($chats && !$cross_chats):
					$button3 = "btn btn-warning";
					break;
				case (!$chats && $cross_chats):
					$button3 = "btn btn-info";
					break;
				default:
					$button3 = 'btn btn-default';
					break;
			}
			
			$videos = DB::table('favvideo_schema')->where('video_owner', $this->id)->where('video_id',$user->id)->first();
			$cross_videos = DB::table('favvideo_schema')->where('video_owner', $user->id)->where('video_id', $this->id)->first();
			
			switch(true){
				case ($videos && $cross_videos):
					$button4 = "btn btn-success";
					break;
				case ($videos && !$cross_videos):
					$button4 = "btn btn-warning";
					break;
				case (!$videos && $cross_videos):
					$button4 = "btn btn-info";
					break;
				default:
					$button4 = 'btn btn-default';
					break;
			}
			
		$profile_user = array('id'=>$user->id,'user'=>$user->user, 'sex'=>$user->sex, 'profile_style'=>$profile_style, 'button1'=>$button1, 'button2'=>$button2, 'button3'=>$button3, 'button4'=>$button4, 'iam1_proxy'=>$iam1_proxy, 'iam2_proxy'=>$iam2_proxy, 'iam3_proxy'=>$iam3_proxy, 'iam4_proxy'=>$iam4_proxy, 'iam5_proxy'=>$iam5_proxy, 'lookingfor1_proxy'=>$lookingfor1_proxy, 'lookingfor2_proxy'=>$lookingfor2_proxy, 'lookingfor3_proxy'=>$lookingfor3_proxy, 'lookingfor4_proxy'=>$lookingfor4_proxy, 'lookingfor5_proxy'=>$lookingfor5_proxy, 'canprovide1_proxy'=>$canprovide1_proxy, 'canprovide2_proxy'=>$canprovide2_proxy, 'canprovide3_proxy'=>$canprovide3_proxy, 'canprovide4_proxy'=>$canprovide4_proxy, 'canprovide5_proxy'=>$canprovide5_proxy, 'near1_proxy'=>$near1_proxy, 'near2_proxy'=>$near2_proxy, 'near3_proxy'=>$near3_proxy, 'near4_proxy'=>$near4_proxy, 'near5_proxy'=>$near5_proxy);

		$image = $profile_image->first();
		
		if($image){
				
			if($image['w_coords'] > 0 && $image['h_coords'] > 0){	
				$width = $image['init_width'];
				$height = $image['init_height'];
				
				$resize_w = $width / $image['w_coords'];
				$resize_h = $height / $image['h_coords'];
					
				$resize_w2 = $image['w_coords'] / 300;
				$resize_h2 = $image['h_coords'] / 300;
				
				$x_calc = $image['x_coords'] / $resize_w2;
				$y_calc = $image['y_coords'] / $resize_h2;
				
				$w_calc = $image['w_coords'] * $resize_w / $resize_w2;
				$h_calc = $image['h_coords'] * $resize_h / $resize_h2;
				
				$profile_style = 'margin-left:-'.$x_calc.'px;margin-top:-'.$y_calc.'px;height:'.$h_calc.'px;width:'.$w_calc.'px;';
			
			}
			
			$pass_image = array('filename'=>"user_images/".$proxy_id."/".$image['filename'], 'profile_style'=>$profile_style);
		}else{
			$pass_image = array('filename'=>'avatar.gif', 'profile_style'=>$profile_style);
		}
		
		$reel_images = Images::where('owner', '=', $proxy_id);
		$reel = $reel_images->get();
		
		$master_reel = array();
		
		foreach($reel as $image){
			
			if($image->w_coords > 0 && $image->h_coords > 0){
				$width = $image->init_width;
				$height = $image->init_height;
					
				$resize_w = $width / $image->w_coords;
				$resize_h = $height / $image->h_coords;
						
				$resize_w2 = $image->w_coords / 300;
				$resize_h2 = $image->h_coords / 300;
					
				$x_calc = $image->x_coords / $resize_w2;
				$y_calc = $image->y_coords / $resize_h2;
					
				$w_calc = $image->w_coords * $resize_w / $resize_w2;
				$h_calc = $image->h_coords * $resize_h / $resize_h2;
			}else{
				$w_calc = $image->init_width;
				$h_calc = $image->init_height;
				
				$x_calc = 0;
				$y_calc = 0;
			}
				
			$master_reel = array_add($master_reel, $image->id, array('id'=>$image->id,'owner'=>$image->owner, 'filename'=>$image->filename, 'x_coords'=>$image->x_coords, 'y_coords'=>$image->y_coords, 'h_coords'=>$image->h_coords, 'w_coords'=>$image->w_coords, 'h_calc'=>$h_calc, 'w_calc'=>$w_calc, 'x_calc'=>$x_calc, 'y_calc'=>$y_calc));
		}
		

		
		return View::make('logged.index.profile_proxy', $this->nav_variables
		)->with('image_main',$pass_image)
		->with('master_reel',$master_reel)
		->with('mail_rows', $this->new_mail_array)
		->with('profile_user', $profile_user);
	}
	
	//Cropping page
	public function get_crop($id){
		$image = Images::where('id', '=', $id);
		$get_image = $image->first();
		
		if($image->count()){
			return View::make('logged.index.crop', $this->nav_variables
			)->with('image', $get_image)
			->with('mail_rows', $this->new_mail_array);
		}
		
		return App::abort(404);
	}
	
	//Directory Page
	public function get_home_directory()
	{
		
		return View::make('logged.index.directory', $this->nav_variables
			)->with('mail_rows', $this->new_mail_array)
			->with('professions', $this->professions)
			->with('sub_professions', $this->sub_professions);
	}
	
	//Home page
	public function get_home_search()
	{
		$master_users = array();
		
		$users = DB::table('users_schema')->where('id', '!=', $this->id)->get();
		foreach($users as $user){
			$favs =  DB::table('favs_schema')->where('fav_owner', $this->id)->where('fav_id',$user->id)->first();
			
			switch(true){
				case ($favs):
					$button1 = "btn btn-success";
					break;
				default:
					$button1 = 'btn btn-default';
					break;
			}
			
			$mails = DB::table('favmail_schema')->where('mail_owner', $this->id)->where('mail_id',$user->id)->first();
			$cross_mails = DB::table('favmail_schema')->where('mail_owner', $user->id)->where('mail_id', $this->id)->first();
			
			switch(true){
				case ($mails && $cross_mails):
					$button2 = "btn btn-success";
					break;
				case ($mails && !$cross_mails):
					$button2 = "btn btn-warning";
					break;
				case (!$mails && $cross_mails):
					$button2 = "btn btn-info";
					break;
				default:
					$button2 = 'btn btn-default';
					break;
			}
			
			$chats = DB::table('favchat_schema')->where('chat_owner', $this->id)->where('chat_id',$user->id)->first();
			$cross_chats = DB::table('favchat_schema')->where('chat_owner', $user->id)->where('chat_id', $this->id)->first();
			
			switch(true){
				case ($chats && $cross_chats):
					$button3 = "btn btn-success";
					break;
				case ($chats && !$cross_chats):
					$button3 = "btn btn-warning";
					break;
				case (!$chats && $cross_chats):
					$button3 = "btn btn-info";
					break;
				default:
					$button3 = 'btn btn-default';
					break;
			}
			
			$videos = DB::table('favvideo_schema')->where('video_owner', $this->id)->where('video_id',$user->id)->first();
			$cross_videos = DB::table('favvideo_schema')->where('video_owner', $user->id)->where('video_id', $this->id)->first();
			
			switch(true){
				case ($videos && $cross_videos):
					$button4 = "btn btn-success";
					break;
				case ($videos && !$cross_videos):
					$button4 = "btn btn-warning";
					break;
				case (!$videos && $cross_videos):
					$button4 = "btn btn-info";
					break;
				default:
					$button4 = 'btn btn-default';
					break;
			}
			
			$image =  Images::where('owner', '=', $user->id)->first();

			//This grabs avatar data
			if($image['w_coords'] > 0 && $image['h_coords'] > 0){
				$width = $image['init_width'];
				$height = $image['init_height'];
					
				$resize_w = $width / $image['w_coords'];
				$resize_h = $height / $image['h_coords'];
						
				$resize_w2 = $image['w_coords'] / 50;
				$resize_h2 = $image['h_coords'] / 50;
					
				$x_calc = $image['x_coords'] / $resize_w2;
				$y_calc = $image['y_coords'] / $resize_h2;
					
				$w_calc = $image['w_coords'] * $resize_w / $resize_w2;
				$h_calc = $image['h_coords'] * $resize_h / $resize_h2;
				
			}else{
				$w_calc = $image['init_width'];
				$h_calc = $image['init_height'];
				
				$x_calc = 0;
				$y_calc = 0;
			}
			
			if($image){
				$avatar = "user_images/".$image['id']."/".$image['filename'];
			}else{
				$avatar = 'avatar.gif';
				$w_calc = 50;
				$h_calc = 50;
			}
			
			$profile_style = 'margin-left:-'.$x_calc.'px;margin-top:-'.$y_calc.'px;height:'.$h_calc.'px;width:'.$w_calc.'px;';
			
			$master_users = array_add($master_users, $user->id, array('id'=>$user->id,'user'=>$user->user, 'sex'=>$user->sex, 'avatar'=>$avatar, 'profile_style'=>$profile_style, 'button1'=>$button1, 'button2'=>$button2, 'button3'=>$button3, 'button4'=>$button4));
		}
		
		
		
		
		
		return View::make('logged.index.search', $this->nav_variables
		)->with('users_list', $users)
		->with('master_list', $master_users)
		->with('mail_rows', $this->new_mail_array);
	}
	
	//Sub Pages/
	public function get_home_views()
	{
		$master_viewers = array();
		$views = Views::where('viewed_id', '=', $this->id);
		$viewers = $views->get();
		
		foreach($viewers as $viewer){
			$viewer_list = Users::where('id', '=', $viewer->viewer_id)->first();
			
			$image =  Images::where('owner', '=', $viewer_list->id)->first();
		
			$favs =  DB::table('favs_schema')->where('fav_owner', $this->id)->where('fav_id',$viewer_list->id)->first();
			
			switch(true){
				case ($favs):
					$button1 = "btn btn-success";
					break;
				default:
					$button1 = 'btn btn-default';
					break;
			}
			
			$mails = DB::table('favmail_schema')->where('mail_owner', $this->id)->where('mail_id',$viewer_list->id)->first();
			$cross_mails = DB::table('favmail_schema')->where('mail_owner', $viewer_list->id)->where('mail_id', $this->id)->first();
			
			switch(true){
				case ($mails && $cross_mails):
					$button2 = "btn btn-success";
					break;
				case ($mails && !$cross_mails):
					$button2 = "btn btn-warning";
					break;
				case (!$mails && $cross_mails):
					$button2 = "btn btn-info";
					break;
				default:
					$button2 = 'btn btn-default';
					break;
			}
			
			$chats = DB::table('favchat_schema')->where('chat_owner', $this->id)->where('chat_id',$viewer_list->id)->first();
			$cross_chats = DB::table('favchat_schema')->where('chat_owner', $viewer_list->id)->where('chat_id', $this->id)->first();
			
			switch(true){
				case ($chats && $cross_chats):
					$button3 = "btn btn-success";
					break;
				case ($chats && !$cross_chats):
					$button3 = "btn btn-warning";
					break;
				case (!$chats && $cross_chats):
					$button3 = "btn btn-info";
					break;
				default:
					$button3 = 'btn btn-default';
					break;
			}
			
			$videos = DB::table('favvideo_schema')->where('video_owner', $this->id)->where('video_id',$viewer_list->id)->first();
			$cross_videos = DB::table('favvideo_schema')->where('video_owner', $viewer_list->id)->where('video_id', $this->id)->first();
			
			switch(true){
				case ($videos && $cross_videos):
					$button4 = "btn btn-success";
					break;
				case ($videos && !$cross_videos):
					$button4 = "btn btn-warning";
					break;
				case (!$videos && $cross_videos):
					$button4 = "btn btn-info";
					break;
				default:
					$button4 = 'btn btn-default';
					break;
			}
			
			//This grabs avatar data
			if($image['w_coords'] > 0 && $image['h_coords'] > 0){
				$width = $image['init_width'];
				$height = $image['init_height'];
					
				$resize_w = $width / $image['w_coords'];
				$resize_h = $height / $image['h_coords'];
						
				$resize_w2 = $image['w_coords'] / 50;
				$resize_h2 = $image['h_coords'] / 50;
					
				$x_calc = $image['x_coords'] / $resize_w2;
				$y_calc = $image['y_coords'] / $resize_h2;
					
				$w_calc = $image['w_coords'] * $resize_w / $resize_w2;
				$h_calc = $image['h_coords'] * $resize_h / $resize_h2;
				
			}else{
				$w_calc = $image['init_width'];
				$h_calc = $image['init_height'];
				
				$x_calc = 0;
				$y_calc = 0;
			}
			
			if($image){
				$avatar = "user_images/".$image['id']."/".$image['filename'];
			}else{
				$avatar = 'avatar.gif';
				$w_calc = 50;
				$h_calc = 50;
			}
			
			$profile_style = 'margin-left:-'.$x_calc.'px;margin-top:-'.$y_calc.'px;height:'.$h_calc.'px;width:'.$w_calc.'px;';
			
			
			$master_viewers = array_add($master_viewers, $viewer_list->id, array('id'=>$viewer_list->id, 'user'=>$viewer_list->user, 'sex'=>$viewer_list->sex, 'avatar'=>$avatar, 'profile_style'=>$profile_style, 'button1'=>$button1, 'button2'=>$button2, 'button3'=>$button3, 'button4'=>$button4));
		}
		
		return View::make('logged.indexsub.views', $this->nav_variables
		)->with('fav_rows', $this->user_rows)
		->with('view_list',$master_viewers)
		->with('mail_rows', $this->new_mail_array);
	}
	
	//Display your marked favs
	public function get_home_favs()
	{
		
		return View::make('logged.indexsub.favs', $this->nav_variables
		)->with('fav_rows', $this->user_rows)
		->with('mail_rows', $this->new_mail_array);
	}
	
	//Display chat page
	public function get_home_chat()
	{
		return View::make('logged.indexsub.chat', $this->nav_variables
		)->with('fav_rows', $this->user_rows)
		->with('mail_rows', $this->new_mail_array);
	}
	
	//Display video page
	public function get_home_video()
	{
		return View::make('logged.indexsub.video', $this->nav_variables
		)->with('fav_rows', $this->user_rows)
		->with('mail_rows', $this->new_mail_array);
	}
	
	//This is for joining other users rooms
	public function get_home_chat_proxy($room)
	{
		return View::make('logged.indexsub.chat', array(
		'id'=>$this->id, 
		'session_hash'=>$this->session_hash, 
		'user_name'=>$this->user_name, 
		'new_mail_count'=>$this->new_mail_count,
		'btc_balance'=>$this->btc_balance,
		'btc_address'=>$this->btc_address,
		'btc_txs'=>$this->btc_txs,
		'btc_total_received'=>$this->btc_total_received,
		'btc_total_sent'=>$this->btc_total_sent,
		'room_proxy'=>$room)
		)->with('fav_rows', $this->user_rows)
		->with('mail_rows', $this->new_mail_array)
		->with($this->nav_variables);
	}
	
	//This is for joining other users videos
	public function get_home_video_proxy($room)
	{
		return View::make('logged.indexsub.video', $this->nav_variables
		)->with('fav_rows', $this->user_rows)
		->with('mail_rows', $this->new_mail_array);
	}

}
