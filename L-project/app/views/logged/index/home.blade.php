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

<style>
.target-cell:hover{
	background-color:red;
}
</style>
<div id='game-master' style='height:800px;background-color:white;margin-left:-15px;border:2px solid #cacaca;border-radius: 25px;' class='col-md-10' id='home-screen'>
	<style>
		.target-cell:hover{
			background-color:blue;
		}
	</style>
	<center>Welcome to One-Meet.</br>Meet, play, exchange.</center>
	<center>
		<div ng-controller='LoginCtrl' style='width:500px;margin-top:100px;border:1px solid #cacaca;display:none;'>
			<input type='text' id='username-login' placeholder='User' />
			<input type='password' id='username-password' placeholder='Password' />
			<button ng-click='loginUser();' class='btn btn-default'>Login</button>
			<button class='btn btn-info'>Register</button>
		</div>
	</center>
		
		<div ng-controller='SotosholyCtrl' id='new-sotosholy-window' style='display:none;'>
			<input style='width:200px;' type='number' min='0.01' max='5' step='0.01' id='sotosholy-bounty-input' placeholder='Game Bounty' />
			<input style='width:100px;' type='number' min='2' max='4' step='1' id='sotosholy-max-player-input' placeholder='Max Players' />
			<button ng-click='createJoinGame();' class='btn btn-success'>Create Game</button>
		</div>
						<center>
							<div id='game-list' ng-controller='SotosholyCtrl' style='width:100%;height:100%;'>
								<button ng-click='promptCreateGame();' style='float:right;' class='btn btn-success'>Create</button>
								<div style='width:100%;height:100%;border:1px solid #cacaca;'>
									<table class='table table-striped'>
										<tr>Game List</tr>
										<tr><th>Users</th><th>Bounty</th></tr>
										<tr ng-repeat='games in gameList' ng-click='joinGame(games.id);'>
											<td><span ng-bind='games.max_players'></span>/4</td>
											<td><span ng-bind='games.bounty'></span> per player</td>
										</tr>
									</table>
								</div>
							</div>
						</center>
						
				
</div>
@stop

@section('js_packages')
@stop

@section('hidden_variables')
<input type='hidden' id='join-room' value='0' />
@stop
