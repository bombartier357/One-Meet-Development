@extends('layouts.logged')
@include('logged.index.child.nav')
@include('logged.index.child.footer')

@section('body')
<div class='col-md-2' id='stats'>
	<div><a href='{{ URL::route("logged-home-views")}}'><button style='width:100%;border-radius: 15px;border:2px solid #cacaca;' class='btn btn-default'>Views</button></a></div>
	<div><a href='{{ URL::route("logged-home-favs")}}'><button style='width:100%;border-radius: 15px;border:2px solid #cacaca;margin-top:2px;' class='btn btn-default'>Favorites</button></a></div>
	<div><a href='{{ URL::route("logged-home-chat")}}'><button style='width:100%;border-radius: 15px;border:2px solid #cacaca;margin-top:2px;' class='btn btn-default'>Chat Rooms</button></a></div>
	<div><a href='{{ URL::route("logged-home-video")}}'><button style='width:100%;border-radius: 15px;border:2px solid #cacaca;margin-top:2px;' class='btn btn-default'>Video</button></a></div>
	<div class='col-md-12' id='video-favorites' style='border-radius:25px;border:2px solid #cacaca;margin-top:2px;'>
		<center><div class="spin" style='margin-top:5%;'/></div></center>
		 <div ng-controller="FavCtrl" class='col-md-12' id='fav-list' style='display:none;'><center><div style='margin-top:10px;'>Favorites</div></center><hr>
			<div ng-repeat="info in fav_info" class="dropdown clearfix">
				<button title="{[{info.login_diff}]}" style="width:100%;border-radius: 15px;margin-top:1px;border:2px solid #cacaca"class="{[{info.online_style}]} dropdown-toggle" type="button" id="fav-dropdown{[{info.id}]}" data-toggle="dropdown" aria-expanded="true">
					<span class="carat"></span>{[{info.user}]}</button>
					<ul class="dropdown-menu" role="menu" aria-labelledby="fav-dropdown{[{info.user}]}">
					  <li role="presentation"><button ng-click="makeSnailMail(info.id, '{{ $user_name }}', info.user);" style="width:100%;border:2px solid white;" class="btn btn-default {[{info.button2_perm}]}">Message</button></li>
					  <li role="presentation"><button ng-click="joinChatRoom(info.chat_home);" style="width:100%;border:2px solid white;" class="btn btn-default {[{info.button3_perm}]}">Open Chat</button></li>
					  <li role="presentation"><button ng-click="open_video(info.id);" style="width:100%;border:2px solid white;" class="btn btn-default {[{info.button4_perm}]}">Video</button></li>
					</ul>
			</div>

		</div>
	</div>
</div>
<div ng-controller="ChatCtrl" style='height:800px;background-color:white;margin-left:-15px;border:1px solid #cacaca;border-radius: 25px;' class='col-md-10' id='home-screen'>
<center><div class="spin" style='margin-top:20%;'/></div></center>
	<div class='row-fluid' id='chat-box' style='display:none;'>
		<div class='col-md-12' id='chat-rooms' style='border-radius:15px;'>
			<div style='float:right;'>
				<button ng-click='nav_to_rooms();' class='btn btn-default' style='border-radius:25px;float:right;'>Rooms</button>
			</div>
			<div ng-repeat="info in room_info" id='room-info'>
				<div>Room: {[{info.room_name}]}</div><div>Online Users:{[{info.logged_count}]}</div><div>Admin: {[{info.admin}]}</div>
			</div>
			<hr>
			<table class='table table-bordered'>
				<tr ng-repeat="rows in data">
					<td><img style='max-width:50px;' src="{[{rows.profile_image}]}" /><span>{[{rows.sender_name}]} </span><span style='color:#cacaca'>{[{rows.created_at.date}]}</span><span style='margin-left:20px;'>{[{rows.text}]}</span></td>
				</tr>
			</table>
		</div>
		<div class='col-md-2' style='border-radius:15px;border:1px solid #cacaca;'>
			<table class='table table-striped'>
				<tr>
					<th>User Name</th>
					</tr>
				<tr ng-repeat="logged in logged_users">
					<td>{[{logged.user}]}</td>
				</tr>
			</table>
		</div>
		<div class='col-md-10' id='chat-input'>
			<input class='form-control' id='send-message' type='text' style='width:95%;border-radius:15px;float:left;margin-left:-10px;' class='input-group input-group-lg' placholder='Message' />
			<button style='float:right;border-radius:15px;' id='button-send-message' ng-click="makeMessage();" class='btn btn-default'>Send</button>
		</div>
	</div>
	<div id='room-display' style='width:100%;border:1px solid #cacaca;border-radius:15px;'>
		<button ng-click='chatCreateRoom();' class='btn btn-default' style='border-radius:15px;float:left;'>New Room</button>
		<button ng-click='nav_to_home_chat();' class='btn btn-default' style='border-radius:15px;float:right;'>Back</button>
		<table class='table table-striped'>
			<tr>
				<th>Name</th><th>Access</th><th>Users</th>
			</tr>
			<tr ng-repeat="room_data in rooms">
				<td ng-click="joinChatRoom(room_data.id);">{[{room_data.room_name}]}</td><td>{[{room_data.access}]}</td><td>{[{room_data.logged_count}]}</td>
			</tr>
		</table>
	</div>
	<div id='create-chat-room'>
		Room Name: <input class='form-control' type='text' id='create-room-name' />
		</br>
		Room Access:
		</br>
		<input type='radio' name='room-access' value='public' />Public<input style='margin-left:15px;' type='radio' name='room-access' value='private' />Private
		</br>
		<center><button ng-click='createRoom();' class='btn btn-default' id='create-room-button'>Create Room</button></center>
	</div>
</div>
@stop

@section('js_packages')
@stop

@section('hidden_variables')
<input type='hidden' id='join-room' value='<?php if(isset($room_proxy)){ echo $room_proxy; }else{ echo $room;} ?>' />
<input type='hidden' id='chat-rows' />
@stop
