<?php

class AjaxCtrl extends BaseController {


	public function make_favorite()
	{
		
		$my_id = Input::get('myid');
		$fav_id = Input::get('favid');
		$type = Input::get('type');
		$favs = DB::table('favs_schema')->where('fav_owner', $my_id)->where('fav_id',$fav_id)->first();
		
		if($favs){
			$favs = DB::table('favs_schema')->where('fav_owner', $my_id)->where('fav_id',$fav_id)->delete();
		}else{
			DB::table('favs_schema')->insert(
				array('fav_owner' => $my_id, 'fav_id' => $fav_id, 'type' => 1)
			);
		}

	}
	
	public function make_favmail()
	{
		
		$my_id = Input::get('myid');
		$fav_id = Input::get('favid');
		$type = Input::get('type');
		$favs = DB::table('favmail_schema')->where('mail_owner', $my_id)->where('mail_id',$fav_id)->first();
		
		$check_auto = Users::where('id', '=', $fav_id)->first();
		
		if($favs){
			$del_favs = DB::table('favmail_schema')->where('mail_owner', $my_id)->where('mail_id',$fav_id)->delete();
		}else{
			DB::table('favmail_schema')->insert(
				array('mail_owner' => $my_id, 'mail_id' => $fav_id, 'type' => 1));
			if($check_auto && $check_auto->auto_mail == 1){
				DB::table('favmail_schema')->insert(
					array('mail_owner' => $fav_id, 'mail_id' => $my_id, 'type' => 1));
			}
		}

	}
	
	public function make_favchat()
	{
		
		$my_id = Input::get('myid');
		$fav_id = Input::get('favid');
		$type = Input::get('type');
		$favs = DB::table('favchat_schema')->where('chat_owner', $my_id)->where('chat_id',$fav_id)->first();
		
		$check_auto = Users::where('id', '=', $fav_id)->first();
		
		if($favs){
			$del_favs = DB::table('favchat_schema')->where('chat_owner', $my_id)->where('chat_id',$fav_id)->delete();
		}else{
			DB::table('favchat_schema')->insert(
				array('chat_owner' => $my_id, 'chat_id' => $fav_id, 'type' => 1));
			if($check_auto && $check_auto->auto_chat == 1){
				DB::table('favchat_schema')->insert(
					array('chat_owner' => $fav_id, 'chat_id' => $my_id, 'type' => 1));
			}
		}

	}
	
	public function make_favvideo()
	{
		
		$my_id = Input::get('myid');
		$fav_id = Input::get('favid');
		$type = Input::get('type');
		$favs = DB::table('favvideo_schema')->where('video_owner', $my_id)->where('video_id',$fav_id)->first();
		
		$check_auto = Users::where('id', '=', $fav_id)->first();
		
		if($favs){
			$del_favs = DB::table('favvideo_schema')->where('video_owner', $my_id)->where('video_id',$fav_id)->delete();
		}else{
			DB::table('favvideo_schema')->insert(
				array('video_owner' => $my_id, 'video_id' => $fav_id, 'type' => 1));
			if($check_auto && $check_auto->auto_video == 1){
				DB::table('favvideo_schema')->insert(
					array('video_owner' => $fav_id, 'video_id' => $my_id, 'type' => 1));
			}
		}

	}
	
	//Updates image table with new crop dimensions
	public function crop_image()
	{
		$image_id = Input::get('id');
		$x_coords = Input::get('x_coords');
		$y_coords = Input::get('y_coords');
		$w_coords = Input::get('w_coords');
		$h_coords = Input::get('h_coords');
		
		$images = Images::where('id', '=', $image_id);
		$update = $images->update(array('x_coords'=>$x_coords,'y_coords'=>$y_coords,'w_coords'=>$w_coords,'h_coords'=>$h_coords));
	}
	
	public function delete_image()
	{
		
	}
	
	//Creates snail mail row message
	public function send_message()
	{
		$from = Input::get('sender_id');
		$to = Input::get('to_id');
		$subject = Input::get('subject');
		$message = Input::get('message');
		
		Mails::create(array(
			'sender_id'=>$from,
			'receiver_id'=>$to,
			'subject'=>$subject,
			'text'=>$message
		));
	}
	
	//Runs periodically to update chat..
	public function get_chat($room_id)
	{
		$final_rows = array();
		$chat = Chats::where('room_id', '=', $room_id)->orderBy('created_at')->get();
		
		foreach($chat as $rows){
			$user = Users::find($rows->sender_id);
			$profile_image = Images::where("owner", "=", $user->id)->first();
			if($profile_image){
				$image_path = '/L-project/public/images/user_images/'.$user->id.'/'.$profile_image->filename;
			}else{
				$image_path = '/L-project/public/images/avatar.gif';
			}
			$final_rows = array_add($final_rows, $rows->id, array('id'=>$rows->id,'room_id'=>$rows->room_id, 'sender_id'=>$rows->sender_id, 'text'=>$rows->text, 'created_at'=>$rows->created_at, 'sender_name'=>$user->user, 'profile_image'=>$image_path));
		}
		
		return $final_rows;
	}
	
	//Gets current room info
	public function get_room_info($room_id){
		$final_row = array();
		$room = Rooms::where('id', '=', $room_id)->first();
		$owner_info = Users::where('id', '=', $room->owner_id)->first();
		$logged_count = Users::where('chat_room', '=', $room_id)->count();
		
		$final_row = array_add($final_row, $room->id, array('id'=>$room_id, 'room_name'=>$room->room_name, 'admin'=>$owner_info->user, 'logged_count'=>$logged_count));
		
		return $final_row;
	}
	
	//Creates new room
	public function create_room(){
		$room_name = Input::get('room_name');
		$access = Input::get('access');
		$owner = Input::get('owner');
		
		$room = Rooms::create(array(
			'room_name'=>$room_name,
			'type'=>$access,
			'owner_id'=>$owner
		));
		
		return $room->id;
	}
	
	//Makes public list of rooms and includes count of logged users...
	public function get_rooms(){
		$final_rows = array();
		$rooms = Rooms::where('type', '!=', 'home')->get();
		
		foreach($rooms as $room){
			$logged_count = Users::where('chat_room', '=', $room->id)->count();
			$final_rows = array_add($final_rows, $room->id, array('id'=>$room->id, 'room_name'=>$room->room_name, 'logged_count'=>$logged_count, 'access'=>$room->type));
		}
		
		return $final_rows;
	}
	
	//Gets list of currently logged in users to the room you are in...
	public function get_room_logged($room_id){
		$final_rows = array();
		$logged_users = Users::where('chat_room', '=', $room_id)->get();
		
		foreach($logged_users as $logged){
			$final_rows = array_add($final_rows, $logged->id, array('id'=>$logged->id, 'user'=>$logged->user));
		}
		
		return $final_rows;
	}
	
	//This sets database of room you are joining...
	public function logged_room(){
		$id = Input::get('id');
		$room = Input::get('room');
		
		$query = Users::where('id', '=', $id)->update(array('chat_room'=>$room));
		return $query;
	}
	
	//Creates new chat row...
	public function send_chat()
	{
		$my_id = Input::get('my_id');
		$to_room = Input::get('to_room');
		$message = Input::get('message');
		
		$chat = new Chats;
		$chat->sender_id = $my_id;
		$chat->room_id = $to_room;
		$chat->text = $message;
		$chat->save();
	}
	
	//Touch to update timestamp
	public function check_logged()
	{
		$id = Input::get('id');
		
		$user = Users::where('id', '=', $id)->first();
		$user->touch();
	}
	
	//Saves user settings
	public function save_settings(){
		$user_id = Input::get('user_id');
		$auto_mail = Input::get('auto_mail');
		$auto_chat = Input::get('auto_chat');
		$auto_video = Input::get('auto_video');
		
		Users::where('id', '=', $user_id)->update(array('auto_mail'=>$auto_mail, 'auto_chat'=>$auto_chat, 'auto_video'=>$auto_video));
	}
	
	public function save_profile_tags(){
		$user_id = Input::get('id');
		
		$iam1 = Input::get('iam1');
		$iam2 = Input::get('iam2');
		$iam3 = Input::get('iam3');
		$iam4 = Input::get('iam4');
		$iam5 = Input::get('iam5');
		
		$lookingfor1 = Input::get('lookingfor1');
		$lookingfor2 = Input::get('lookingfor2');
		$lookingfor3 = Input::get('lookingfor3');
		$lookingfor4 = Input::get('lookingfor4');
		$lookingfor5 = Input::get('lookingfor5');
		
		$canprovide1 = Input::get('canprovide1');
		$canprovide2 = Input::get('canprovide2');
		$canprovide3 = Input::get('canprovide3');
		$canprovide4 = Input::get('canprovide4');
		$canprovide5 = Input::get('canprovide5');
		
		$near1 = Input::get('near1');
		$near2 = Input::get('near2');
		$near3 = Input::get('near3');
		$near4 = Input::get('near4');
		$near5 = Input::get('near5');
		
		$user = Users::find($user_id);
		$user->iam1 = $iam1;
		$user->iam2 = $iam2;
		$user->iam3 = $iam3;
		$user->iam4 = $iam4;
		$user->iam5 = $iam5;
		$user->lookingfor1 = $lookingfor1;
		$user->lookingfor2 = $lookingfor2;
		$user->lookingfor3 = $lookingfor3;
		$user->lookingfor4 = $lookingfor4;
		$user->lookingfor5 = $lookingfor5;
		$user->canprovide1 = $canprovide1;
		$user->canprovide2 = $canprovide2;
		$user->canprovide3 = $canprovide3;
		$user->canprovide4 = $canprovide4;
		$user->canprovide5 = $canprovide5;
		$user->near1 = $near1;
		$user->near2 = $near2;
		$user->near3 = $near3;
		$user->near4 = $near4;
		$user->near5 = $near5;
		$user->save();
	}
	
	//Send bitcoins to another user
	public function send_bitcoins_users(){
		$my_id = Input::get('id');
		$send_to = Input::get('send_to');
		$amount = Input::get('amount') * 100000000;
		
		$from = Users::find($my_id);
		$to = Users::find($send_to);
		
		if($from && $to){
			if($from->temp_coins >= $amount){
				$transaction = Transactions::create(array(
					'from_id'=>$from->id,
					'to_id'=>$to->id,
					'amount'=>$amount,
					'type'=>'push',
					'from_accepted'=>1
				));
				$from->temp_coins = $from->temp_coins - $amount;
				$from->save();
				$to->temp_coins = $to->temp_coins + $amount;
				$to->save();
				return;
			}else{
				return "You do not have enough bitcoins to do that!";
			}
		}
	}
	
	//Make loan payment
	public function make_payment(){
		$my_id = Input::get('id');
		$loan_id = Input::get('loan_id');
		
		$loan = Loans::find($loan_id);   
		
		$now = date('Y-m-d H:i:s');
		$next_payment_secs = strtotime($loan->starting."+".($loan->payments_ontime + $loan->payments_late + 1)." ".$loan->period."") - strtotime($now);
		$next_payment = date('Y-m-d H:i:s', strtotime(($loan->starting."+".($loan->payments_ontime + $loan->payments_late + 1)." ".$loan->period)));
		
		if($next_payment_secs < 0){
			$late = 1;
			$interest = $loan->interest + $loan->penalty + ($loan->payments_late * $loan->penalty);
			$amount = $loan->amount * $interest / 100 + ($loan->amount / $loan->period_count);
			$loan->payments_late = $loan->payments_late + 1;
			$loan->save();
		}else{
			$late = 0;
			$interest = $loan->interest;
			$amount = $loan->amount * $interest / 100 + ($loan->amount / $loan->period_count);
			$loan->payments_ontime = $loan->payments_ontime + 1;
			$loan->save();
		}
		
		$today = new DateTime($now);
		$sched_payment = new DateTime($next_payment);
		$diff = $today->diff($sched_payment);

		//echo $diff->y."</br>";
		//echo $diff->m."</br>";
		//echo $diff->d;
		
		$subLoan = subLoans::where('loan_id', '=', $loan_id)->get();
		
		$total_sub_amount = 0;
		foreach($subLoan as $sub){
			$sub_amount = $sub->amount * $interest / 100 + ($sub->amount / $loan->period_count);
			$total_sub_amount = $total_sub_amount + $sub_amount;
			
			$lender_update_coins = Users::find($sub->owner_id);
			$lender_update_coins->temp_coins = $lender_update_coins->temp_coins + $sub_amount;
			$lender_update_coins->save();
		}
		
		$borrower_update_coins = Users::find($loan->owner);
		$borrower_update_coins->temp_coins = $borrower_update_coins->temp_coins - $amount;
		$borrower_update_coins->save();
		
		if($loan->peg_dollar == 0){
			$amount = $amount / 100000000;
		}else{
			$amount = $amount / 100;
		}
		
		$payment_array = array('interest'=>$interest, 'amount'=>$amount, 'next_payment'=>$next_payment, 'payment_secs'=>$next_payment_secs, 'late'=>$late, 'diff_year'=>$diff->y, 'diff_month'=>$diff->m, 'diff_day'=>$diff->d, 'total_subs_amount'=>($total_sub_amount / 100000000));
		
		return $payment_array;
	}
	
	//Accepts transactions both pull/push
	public function accept_transaction(){
		$my_id = Input::get('id');
		$tx_id = Input::get('tx_id');
		$type = Input::get('type');
		
		$transaction = Transactions::find($tx_id);
		if($type == 'push' && $transaction->from_accepted == 0){
			$transaction->from_accepted = 1;
		}elseif($type == 'push' && $transaction->from_accepted == 1){
			$transaction->from_accepted = 0;
		}elseif($type == 'pull' && $transaction->to_accepted == 0){
			$transaction->to_accepted = 1;
		}elseif($type == 'pull' && $transaction->to_accepted == 1){
			$transaction->to_accepted = 0;
		}
		$transaction->save();
		
		return $transaction;
	}
	
	//Get push transactions
	public function get_push_transactions(){
		$return_array = array();
		$my_id = Input::get('id');
		$counter = 0;
		
		$transactions = Transactions::where('from_id', '=', $my_id)->where('type', '=', 'push')->get();
		
		foreach($transactions as $transaction){
			if($transaction->from_accepted == 0){
				$from_accepted_button = 'default';
			}else{
				$from_accepted_button = 'success';
			}
			
			if($transaction->to_accepted == 0){
				$to_accepted_button = 'default';
			}else{
				$to_accepted_button = 'success';
			}
			
			if($transaction->from_rating == 0){
				$from_rating_button = 'default';
			}elseif($transaction->from_rating == 0){
				$from_rating_button	= 'danger';
			}else{
				$from_rating_button = 'warning';
			}
			
			if($transaction->to_rating == 0){
				$to_rating_button = 'default';
			}elseif($transaction->to_rating == 0){
				$to_rating_button	= 'danger';
			}else{
				$to_rating_button = 'warning';
			}
			
			if($transaction->from_comment == ''){
				$from_comment_button = 'default';
			}else{
				$from_comment_button = 'success';
			}
			
			if($transaction->to_comment == ''){
				$to_comment_button = 'default';
			}else{
				$to_comment_button = 'success';
			}
			
			$return_array = array_add($return_array, $counter, array('id'=>$transaction->id, 'from_id'=>$transaction->from_id, 'to_id'=>$transaction->to_id, 'amount'=>$transaction->amount, 'type'=>$transaction->type, 'from_accepted'=>$from_accepted_button, 'to_accepted'=>$to_accepted_button, 'from_rating'=>$from_rating_button, 'to_rating'=>$to_rating_button, 'from_comment'=>$from_comment_button, 'to_comment'=>$to_comment_button, 'created_at'=>$transaction->created_at, 'updated_at'=>$transaction->updated_at));
		$counter++;
		}
		return $return_array;
	}
	
	//Get pull transactions
	public function get_pull_transactions(){
		$return_array = array();
		$my_id = Input::get('id');
		$counter = 0;
		
		$transactions = Transactions::where('to_id', '=', $my_id)->where('type', '=', 'push')->get();
		
		foreach($transactions as $transaction){
			if($transaction->from_accepted == 0){
				$from_accepted_button = 'default';
			}else{
				$from_accepted_button = 'success';
			}
			
			if($transaction->to_accepted == 0){
				$to_accepted_button = 'default';
			}else{
				$to_accepted_button = 'success';
			}
			
			if($transaction->from_rating == 0){
				$from_rating_button = 'default';
			}elseif($transaction->from_rating == 0){
				$from_rating_button	= 'danger';
			}else{
				$from_rating_button = 'warning';
			}
			
			if($transaction->to_rating == 0){
				$to_rating_button = 'default';
			}elseif($transaction->to_rating == 0){
				$to_rating_button	= 'danger';
			}else{
				$to_rating_button = 'warning';
			}
			
			if($transaction->from_comment == ''){
				$from_comment_button = 'default';
			}else{
				$from_comment_button = 'success';
			}
			
			if($transaction->to_comment == ''){
				$to_comment_button = 'default';
			}else{
				$to_comment_button = 'success';
			}
			
			$return_array = array_add($return_array, $counter, array('id'=>$transaction->id, 'from_id'=>$transaction->from_id, 'to_id'=>$transaction->to_id, 'amount'=>$transaction->amount, 'type'=>$transaction->type, 'from_accepted'=>$from_accepted_button, 'to_accepted'=>$to_accepted_button, 'from_rating'=>$from_rating_button, 'to_rating'=>$to_rating_button, 'from_comment'=>$from_comment_button, 'to_comment'=>$to_comment_button, 'created_at'=>$transaction->created_at, 'updated_at'=>$transaction->updated_at));
		$counter++;
		}
		return $return_array;
	}
	
	//Make loan request
	public function loan_request(){
		$user_id = Input::get('id');
		$interest = Input::get('interest');
		$penalty = Input::get('penalty');
		$period_length = Input::get('period_length');
		$start_date = Input::get('start_date');
		$period_count = Input::get('period_count');
		$peg_dollar = Input::get('peg_dollar');
		
		if($peg_dollar == 0){
			$loan_amount = Input::get('loan_amount') * 100000000;
		}else{
			$loan_amount = Input::get('loan_amount') * 100;
		}
		
		Loans::create(array(
			'owner'=>$user_id,
			'amount'=>$loan_amount,
			'interest'=>$interest,
			'penalty'=>$penalty,
			'period'=>$period_length,
			'period_count'=>$period_count,
			'starting'=>$start_date,
			'peg_dollar'=>$peg_dollar
		));
	}
	
	public function list_open_loans(){
		$loan_rows = array();
		$current_date = date("Y-m-d");
		$loans = Loans::where('funded', '=', 0)->where('starting', '>', $current_date)->get();
		
		foreach($loans as $loan){
			$user = Users::where('id', '=', $loan->owner)->first();
			
			if($loan->peg_dollar == 0){
				$currency = 'btc';
				$amount = $loan->amount/100000000;
			}else{
				$currency = 'dollar\'s';
				$amount = $loan->amount/100;
			}
			
			$loan_rows = array_add($loan_rows, $loan->id,array(
					'user'=>$user->user,
					'id'=>$loan->id,
					'amount'=>$amount,
					'period'=>$loan->period,
					'period_count'=>$loan->period_count,
					'starting'=>$loan->starting,
					'interest'=>$loan->interest,
					'penalty'=>$loan->penalty,
					'created_at'=>$loan->created_at,
					'currency'=>$currency,
					'current_date'=>$current_date
				));
		}
		
		return $loan_rows;
	}
	
	public function get_lending_stats(){
		$lending_stats = array();
		$my_id = Input::get('id');
		
		$my_lending = subLoans::where('owner_id', '=', $my_id)->get();
		
		foreach($my_lending as $lending){
			$master_loan = Loans::find($lending->loan_id);
			if($master_loan->funded == 1 && ($master_loan->payments_ontime + $master_loan->payments_late) < $master_loan->period_count){
				$user = Users::find($master_loan->owner);
				
				if($lending->currency == 0){
					$currency = 'btc';
					$calced_amount = $lending->amount / 100000000;
				}else{
					$currency = 'dollar\'s';
					$calced_amount = $lending->amount / 100;
				}
				
				$now = date('Y-m-d H:i:s');
				$next_payment_secs = strtotime($master_loan->starting."+".($master_loan->payments_ontime + $master_loan->payments_late + 1)." ".$master_loan->period."") - strtotime($now);
				
				$lending_stats = array_add($lending_stats, $lending->id,array(
						'user'=>$user->user,
						'id'=>$lending->id,
						'loan_id'=>$lending->loan_id,
						'owner_id'=>$lending->owner_id,
						'amount'=>$calced_amount,
						'currency'=>$currency,
						'loan_total'=>$master_loan->amount,
						'loan_interest'=>$master_loan->interest,
						'loan_penalty'=>$master_loan->penalty,
						'loan_period'=>$master_loan->period,
						'loan_period_count'=>$master_loan->period_count,
						'loan_starting'=>$master_loan->starting,
						'next_payment_secs'=>$next_payment_secs
					));
			}
		}
		
		return $lending_stats;
	}
	
	public function get_borrowing_stats(){
		$borrowing_stats = array();
		$my_id = Input::get('id');
		
		$my_borrowing = Loans::where('owner', '=', $my_id)->where('funded', '=', 1)->get();
		
		foreach($my_borrowing as $borrowing){
			if($borrowing->period_count <= ($borrowing->payments_ontime + $borrowing->payments_late)){
				continue;
			}
			
			$sub_stats = array();
			$sub_loans = subLoans::where('loan_id', '=', $borrowing->id)->get();
			
			if($borrowing->peg_dollar == 0){
				$currency = 'btc';
				$calced_amount = $borrowing->amount / 100000000;
			}else{
				$currency = 'dollar\'s';
				$calced_amount = $borrowing->amount / 100;
			}
			
			$now = date('Y-m-d H:i:s');
			$next_payment_secs = strtotime($borrowing->starting."+".($borrowing->payments_ontime + $borrowing->payments_late + 1)." ".$borrowing->period."") - strtotime($now);
			
			
			
			foreach($sub_loans as $sub){
				$owner_details = Users::find($sub->owner_id);
				
				if($borrowing->peg_dollar == 0){
					$calced_sub = $sub->amount / 100000000;
				}else{
					$calced_sub = $sub->amount / 100;
				}
				
				$sub_stats = array_add($sub_stats, $sub->id,array(
						'id'=>$sub->id,
						'master_loan'=>$borrowing->id,
						'owner_name'=>$owner_details->user,
						'amount'=>$sub->amount,
						'calced_sub'=>$calced_sub
				));		
			}
					
			$borrowing_stats = array_add($borrowing_stats, $borrowing->id,array(
						'id'=>$borrowing->id,
						'amount'=>$borrowing->amount,
						'interest'=>$borrowing->interest,
						'penalty'=>$borrowing->penalty,
						'period'=>$borrowing->period,
						'period_count'=>$borrowing->period_count,
						'starting'=>$borrowing->starting,
						'currency'=>$currency,
						'calced_amount'=>$calced_amount,
						'next_payment_secs'=>$next_payment_secs,
						'sub_loans'=>$sub_stats
			));
		}
		
		return $borrowing_stats;
	}
	
	public function get_loan_details(){
		$loan_id = Input::get('loan_id');
		$loans = Loans::find($loan_id);
		
		$user = Users::where('id', '=', $loans->owner)->first();
			
		$sub_loan = subLoans::where('loan_id', '=', $loan_id);
		$sub_loans = $sub_loan->get();
		$sub_count = $sub_loan->count();
		
		$build_array = array();
		$holder = 0;
		$total_sub_amount = 0;
		foreach($sub_loans as $subs_array){
			$total_sub_amount += $subs_array->amount;
			$owner_name = Users::find($subs_array->owner_id);
			
			if($loans->peg_dollar == 0){
				$sub_amount = $subs_array->amount/100000000;
			}else{
				$sub_amount = $subs_array->amount/100;
			}
			
			$build_array = array_add($build_array, $holder,array(
					'sub_id'=>$subs_array->id,
					'sub_owner_id'=>$subs_array->owner_id,
					'sub_owner_user'=>$owner_name->user,
					'sub_owner_amount'=>$sub_amount, 
					'sub_owner_createdat'=>$subs_array->created_at
				));
			$holder++;
		}
		
		if($loans->peg_dollar == 0){
			$currency = 'btc';
			$amount = $loans->amount/100000000;
			$max_allowed_amount = ($loans->amount - $total_sub_amount) / 100000000;
		}else{
			$currency = 'dollar\'s';
			$amount = $loans->amount/100;
			$max_allowed_amount = ($loans->amount - $total_sub_amount) / 100;
		}
		
		$loan_details = array(
				'user'=>$user->user,
				'id'=>$loans->id,
				'amount'=>$amount,
				'period'=>$loans->period,
				'period_count'=>$loans->period_count,
				'starting'=>$loans->starting,
				'interest'=>$loans->interest,
				'penalty'=>$loans->penalty,
				'payments_ontime'=>$loans->payments_ontime,
				'payments_late'=>$loans->payments_late,
				'created_at'=>$loans->created_at,
				'currency'=>$currency,
				'peg_dollar'=>$loans->peg_dollar,
				'subs_loan_array'=>$build_array,
				'subs_loan_count'=>$sub_count,
				'total_sub_amount'=>$total_sub_amount,
				'max_allowed_amount'=>$max_allowed_amount
			);
		
		
		return $loan_details;
	}
	
	//Final take loan confirmation
	public function loan_final_confirm(){
		$loan_id = Input::get('loan_id');
		$owner = Input::get('owner');
		$amount = Input::get('amount');
		$currency = Input::get('currency');
		
		$master_loan = Loans::where('id', '=', $loan_id)->first();
		$slave_loans = subLoans::where('loan_id', '=', $loan_id)->sum('amount');
		
		if($slave_loans + $amount >= $master_loan->amount){
			Loans::where('id', '=', $loan_id)->update(array('funded'=>1));
		}
		
		subLoans::create(array(
			'loan_id'=>$loan_id,
			'owner_id'=>$owner,
			'amount'=>$amount,
			'currency'=>$currency
		));
		
	}
	
	//Gets mail details
	public function retrieve_mail_details()
	{
		$mail_id = Input::get('mail_id');
		
		$details = Mails::where('id', '=', $mail_id)->first();
		$from = Users::where('id', '=', $details->sender_id)->first();
		$to = Users::where('id', '=', $details->receiver_id)->first();
		
		$final_rows =  array('id'=>$details->id, 'from'=>$from->user, 'to'=>$to->user, 'subject'=>$details->subject, 'text'=>$details->text, 'createdat'=>$details->created_at, 'sender_id'=>$details->sender_id, 'receiver_id'=>$details->receiver_id);
		
		return $final_rows;
	}
	
	//Checks favs periodically
	public function check_favs($id){
		$fav_rows = array();
		//This creates an array of the logged user's favorites.  This can be called on any page using this controller.
		$favs = DB::table('favs_schema')->where('fav_owner', $id)->get();
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
			$mails = DB::table('favmail_schema')->where('mail_owner', $id)->where('mail_id',$fav->fav_id)->first();
			$cross_mails = DB::table('favmail_schema')->where('mail_owner', $fav->fav_id)->where('mail_id', $id)->first();
			
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
			$chats = DB::table('favchat_schema')->where('chat_owner', $id)->where('chat_id',$fav->fav_id)->first();
			$cross_chats = DB::table('favchat_schema')->where('chat_owner', $fav->fav_id)->where('chat_id', $id)->first();
			
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
			$videos = DB::table('favvideo_schema')->where('video_owner', $id)->where('video_id',$fav->fav_id)->first();
			$cross_videos = DB::table('favvideo_schema')->where('video_owner', $fav->fav_id)->where('video_id', $id)->first();
			
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
			
			//This determines when the selected fav last login time was and if they are currently online or not
			if($user_data){
				$chat_home = DB::table('chat_rooms_schema')->where('owner_id', $fav->fav_id)->first();
				
				if($chat_home){
					$chat_room = $chat_home->id;
				}else{
					$chat_room = '';
				}

				$last_login = new DateTime($user_data->updated_at);
				$now = new DateTime();
				$obj_diff = $last_login->diff($now);
				$diff = $obj_diff->format("Last seen %d days, %h hours and %i minutes ago");
				$years_diff = $obj_diff->y;
				$months_diff = $obj_diff->m;
				$days_diff = $obj_diff->d;
				$hours_diff = $obj_diff->h;
				$mins_diff = $obj_diff->i;
				
				if($mins_diff < 1  && $hours_diff < 1 && $days_diff < 1 && $months_diff < 1 && $years_diff < 1){
					$online = 1;
					$html_style = 'btn btn-success';
				}elseif($mins_diff > 1 && $mins_diff < 3  && $hours_diff < 1 && $days_diff < 1 && $months_diff < 1 && $years_diff < 1){
					$online = 1;
					$html_style = 'btn btn-warning';
				}else{
					$online = 0;
					$html_style = 'btn btn-danger';
				}
				
				//Gotta pass this shit to the view, lets build a clever array for this...
				$fav_rows = array_add($fav_rows, $fav->fav_id,array(
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
					'chat_home'=>$chat_room
				));
			}
		}
		
		return $fav_rows;
	}

	//Creates search query
	public function make_search(){
		$final_rows = array();
		$search_string = Input::get('search_string');
		$my_id = Input::get('my_id');
		$search_users = Users::where('user', 'LIKE', '%'.$search_string.'%')->get();
		
		foreach($search_users as $search){
			
			$favs =  DB::table('favs_schema')->where('fav_owner', $my_id)->where('fav_id',$search->id)->first();
			
			switch(true){
				case ($favs):
					$button1 = "btn btn-success";
					break;
				default:
					$button1 = 'btn btn-default';
					break;
			}
			
			$mails = DB::table('favmail_schema')->where('mail_owner', $my_id)->where('mail_id',$search->id)->first();
			$cross_mails = DB::table('favmail_schema')->where('mail_owner', $search->id)->where('mail_id', $my_id)->first();
			
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
			
			$chats = DB::table('favchat_schema')->where('chat_owner', $my_id)->where('chat_id',$search->id)->first();
			$cross_chats = DB::table('favchat_schema')->where('chat_owner', $search->id)->where('chat_id', $my_id)->first();
			
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
			
			$videos = DB::table('favvideo_schema')->where('video_owner', $my_id)->where('video_id',$search->id)->first();
			$cross_videos = DB::table('favvideo_schema')->where('video_owner', $search->id)->where('video_id', $my_id)->first();
			
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
			
			$image =  Images::where('owner', '=', $search->id)->first();

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
			
			
			$final_rows = array_add($final_rows, $search->id, array('id'=>$search->id, 'user'=>$search->user, 'sex'=>$search->sex, 'avatar'=>$avatar, 'profile_style'=>$profile_style, 'button1'=>$button1, 'button2'=>$button2, 'button3'=>$button3, 'button4'=>$button4));
		}
		
		return $final_rows;
	}

}
