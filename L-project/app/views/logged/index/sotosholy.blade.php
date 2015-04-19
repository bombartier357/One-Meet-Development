@extends('layouts.games')
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
		<div id='video'>
			<div id="local-attributes" class='game-window' style='border:1px solid #cacaca;width:201px;height:152px;float:left;'>
				<video id='localVideo' autoplay></video>
			</div>
			
			<div id='remoteVideos' class='video-remote' style='border:1px solid #cacaca;width:201px;height:452px;float:right;'></div>
		</div>
		<div style='width:300px;height:400px;float:left;margin-top:300px;margin-left:-100px;border:1px solid #cacaca;'>
			<div style='width:100%;'>
				<div style='width:33%;float:left;'>Player</div><div style='width:33%;float:left;'>Sotoshi</div>
				<div style='width:33%;float:left;'>Property</div>
			</div>
			<div style='width:100%;'>
				<div style='width:33%;float:left;'>{{$sotosholy['player1_name']}}</div><div style='width:33%;float:left;'>{{$sotosholy['player1_balance']}}</div>
				<div style='width:33%;float:left;'>
					<div style='width:80px;height:79px;border:1px solid #cacaca;'>
						<div style='width:12px;height:12px;border:1px solid #cacaca;float:left;'></div>
						<div style='width:6px;height:12px;border:1px solid #cacaca;float:left;'></div>
						<div style='width:6px;height:12px;border:1px solid #cacaca;float:left;'></div>
						<div style='width:6px;height:12px;border:1px solid #cacaca;float:left;'></div>
						<div style='width:6px;height:12px;border:1px solid #cacaca;float:left;'></div>
						<div style='width:6px;height:12px;border:1px solid #cacaca;float:left;'></div>
						<div style='width:6px;height:12px;border:1px solid #cacaca;float:left;'></div>
						<div style='width:6px;height:12px;border:1px solid #cacaca;float:left;'></div>
						<div style='width:6px;height:12px;border:1px solid #cacaca;float:left;'></div>
						<div style='width:6px;height:12px;border:1px solid #cacaca;float:left;'></div>
						<div style='width:12px;height:12px;border:1px solid #cacaca;float:left;'></div>
						<div style='width:12px;height:54px;border:1px solid #cacaca;float:left;'>
							<div style='width:12px;height:6px;border:1px solid #cacaca;float:left;'></div>
							<div style='width:12px;height:6px;border:1px solid #cacaca;float:left;'></div>
							<div style='width:12px;height:6px;border:1px solid #cacaca;float:left;'></div>
							<div style='width:12px;height:6px;border:1px solid #cacaca;float:left;'></div>
							<div style='width:12px;height:6px;border:1px solid #cacaca;float:left;'></div>
							<div style='width:12px;height:6px;border:1px solid #cacaca;float:left;'></div>
							<div style='width:12px;height:6px;border:1px solid #cacaca;float:left;'></div>
							<div style='width:12px;height:6px;border:1px solid #cacaca;float:left;'></div>
							<div style='width:12px;height:6px;border:1px solid #cacaca;float:left;'></div>
						</div>
						<div style='width:54px;height:54px;border:1px solid #cacaca;float:left;'></div>
						<div style='width:12px;height:54px;border:1px solid #cacaca;float:left;'>
							<div style='width:12px;height:6px;border:1px solid #cacaca;float:left;'></div>
							<div style='width:12px;height:6px;border:1px solid #cacaca;float:left;'></div>
							<div style='width:12px;height:6px;border:1px solid #cacaca;float:left;'></div>
							<div style='width:12px;height:6px;border:1px solid #cacaca;float:left;'></div>
							<div style='width:12px;height:6px;border:1px solid #cacaca;float:left;'></div>
							<div style='width:12px;height:6px;border:1px solid #cacaca;float:left;'></div>
							<div style='width:12px;height:6px;border:1px solid #cacaca;float:left;'></div>
							<div style='width:12px;height:6px;border:1px solid #cacaca;float:left;'></div>
							<div style='width:12px;height:6px;border:1px solid #cacaca;float:left;'></div>
						</div>
						<div style='width:12px;height:12px;border:1px solid #cacaca;float:left;'></div>
						<div style='width:6px;height:12px;border:1px solid #cacaca;float:left;'></div>
						<div style='width:6px;height:12px;border:1px solid #cacaca;float:left;'></div>
						<div style='width:6px;height:12px;border:1px solid #cacaca;float:left;'></div>
						<div style='width:6px;height:12px;border:1px solid #cacaca;float:left;'></div>
						<div style='width:6px;height:12px;border:1px solid #cacaca;float:left;'></div>
						<div style='width:6px;height:12px;border:1px solid #cacaca;float:left;'></div>
						<div style='width:6px;height:12px;border:1px solid #cacaca;float:left;'></div>
						<div style='width:6px;height:12px;border:1px solid #cacaca;float:left;'></div>
						<div style='width:6px;height:12px;border:1px solid #cacaca;float:left;'></div>
						<div style='width:12px;height:12px;border:1px solid #cacaca;float:left;'></div>
					</div>
				</div>
			</div>
			<div style='width:100%;'>
				<div style='width:33%;float:left;'>{{$sotosholy['player2_name']}}</div><div style='width:33%;float:left;'>{{$sotosholy['player2_balance']}}</div>
				<div style='width:33%;float:left;'>
					<div style='width:80px;height:79px;border:1px solid #cacaca;'>
						<div style='width:12px;height:12px;border:1px solid #cacaca;float:left;'></div>
						<div style='width:6px;height:12px;border:1px solid #cacaca;float:left;'></div>
						<div style='width:6px;height:12px;border:1px solid #cacaca;float:left;'></div>
						<div style='width:6px;height:12px;border:1px solid #cacaca;float:left;'></div>
						<div style='width:6px;height:12px;border:1px solid #cacaca;float:left;'></div>
						<div style='width:6px;height:12px;border:1px solid #cacaca;float:left;'></div>
						<div style='width:6px;height:12px;border:1px solid #cacaca;float:left;'></div>
						<div style='width:6px;height:12px;border:1px solid #cacaca;float:left;'></div>
						<div style='width:6px;height:12px;border:1px solid #cacaca;float:left;'></div>
						<div style='width:6px;height:12px;border:1px solid #cacaca;float:left;'></div>
						<div style='width:12px;height:12px;border:1px solid #cacaca;float:left;'></div>
						<div style='width:12px;height:54px;border:1px solid #cacaca;float:left;'>
							<div style='width:12px;height:6px;border:1px solid #cacaca;float:left;'></div>
							<div style='width:12px;height:6px;border:1px solid #cacaca;float:left;'></div>
							<div style='width:12px;height:6px;border:1px solid #cacaca;float:left;'></div>
							<div style='width:12px;height:6px;border:1px solid #cacaca;float:left;'></div>
							<div style='width:12px;height:6px;border:1px solid #cacaca;float:left;'></div>
							<div style='width:12px;height:6px;border:1px solid #cacaca;float:left;'></div>
							<div style='width:12px;height:6px;border:1px solid #cacaca;float:left;'></div>
							<div style='width:12px;height:6px;border:1px solid #cacaca;float:left;'></div>
							<div style='width:12px;height:6px;border:1px solid #cacaca;float:left;'></div>
						</div>
						<div style='width:54px;height:54px;border:1px solid #cacaca;float:left;'></div>
						<div style='width:12px;height:54px;border:1px solid #cacaca;float:left;'>
							<div style='width:12px;height:6px;border:1px solid #cacaca;float:left;'></div>
							<div style='width:12px;height:6px;border:1px solid #cacaca;float:left;'></div>
							<div style='width:12px;height:6px;border:1px solid #cacaca;float:left;'></div>
							<div style='width:12px;height:6px;border:1px solid #cacaca;float:left;'></div>
							<div style='width:12px;height:6px;border:1px solid #cacaca;float:left;'></div>
							<div style='width:12px;height:6px;border:1px solid #cacaca;float:left;'></div>
							<div style='width:12px;height:6px;border:1px solid #cacaca;float:left;'></div>
							<div style='width:12px;height:6px;border:1px solid #cacaca;float:left;'></div>
							<div style='width:12px;height:6px;border:1px solid #cacaca;float:left;'></div>
						</div>
						<div style='width:12px;height:12px;border:1px solid #cacaca;float:left;'></div>
						<div style='width:6px;height:12px;border:1px solid #cacaca;float:left;'></div>
						<div style='width:6px;height:12px;border:1px solid #cacaca;float:left;'></div>
						<div style='width:6px;height:12px;border:1px solid #cacaca;float:left;'></div>
						<div style='width:6px;height:12px;border:1px solid #cacaca;float:left;'></div>
						<div style='width:6px;height:12px;border:1px solid #cacaca;float:left;'></div>
						<div style='width:6px;height:12px;border:1px solid #cacaca;float:left;'></div>
						<div style='width:6px;height:12px;border:1px solid #cacaca;float:left;'></div>
						<div style='width:6px;height:12px;border:1px solid #cacaca;float:left;'></div>
						<div style='width:6px;height:12px;border:1px solid #cacaca;float:left;'></div>
						<div style='width:12px;height:12px;border:1px solid #cacaca;float:left;'></div>
					</div>
				</div>
			</div>
			<div style='width:100%;'>
				<div style='width:33%;float:left;'>{{$sotosholy['player3_name']}}</div><div style='width:33%;float:left;'>{{$sotosholy['player3_balance']}}</div>
				<div style='width:33%;float:left;'>
					<div style='width:80px;height:79px;border:1px solid #cacaca;'>
						<div style='width:12px;height:12px;border:1px solid #cacaca;float:left;'></div>
						<div style='width:6px;height:12px;border:1px solid #cacaca;float:left;'></div>
						<div style='width:6px;height:12px;border:1px solid #cacaca;float:left;'></div>
						<div style='width:6px;height:12px;border:1px solid #cacaca;float:left;'></div>
						<div style='width:6px;height:12px;border:1px solid #cacaca;float:left;'></div>
						<div style='width:6px;height:12px;border:1px solid #cacaca;float:left;'></div>
						<div style='width:6px;height:12px;border:1px solid #cacaca;float:left;'></div>
						<div style='width:6px;height:12px;border:1px solid #cacaca;float:left;'></div>
						<div style='width:6px;height:12px;border:1px solid #cacaca;float:left;'></div>
						<div style='width:6px;height:12px;border:1px solid #cacaca;float:left;'></div>
						<div style='width:12px;height:12px;border:1px solid #cacaca;float:left;'></div>
						<div style='width:12px;height:54px;border:1px solid #cacaca;float:left;'>
							<div style='width:12px;height:6px;border:1px solid #cacaca;float:left;'></div>
							<div style='width:12px;height:6px;border:1px solid #cacaca;float:left;'></div>
							<div style='width:12px;height:6px;border:1px solid #cacaca;float:left;'></div>
							<div style='width:12px;height:6px;border:1px solid #cacaca;float:left;'></div>
							<div style='width:12px;height:6px;border:1px solid #cacaca;float:left;'></div>
							<div style='width:12px;height:6px;border:1px solid #cacaca;float:left;'></div>
							<div style='width:12px;height:6px;border:1px solid #cacaca;float:left;'></div>
							<div style='width:12px;height:6px;border:1px solid #cacaca;float:left;'></div>
							<div style='width:12px;height:6px;border:1px solid #cacaca;float:left;'></div>
						</div>
						<div style='width:54px;height:54px;border:1px solid #cacaca;float:left;'></div>
						<div style='width:12px;height:54px;border:1px solid #cacaca;float:left;'>
							<div style='width:12px;height:6px;border:1px solid #cacaca;float:left;'></div>
							<div style='width:12px;height:6px;border:1px solid #cacaca;float:left;'></div>
							<div style='width:12px;height:6px;border:1px solid #cacaca;float:left;'></div>
							<div style='width:12px;height:6px;border:1px solid #cacaca;float:left;'></div>
							<div style='width:12px;height:6px;border:1px solid #cacaca;float:left;'></div>
							<div style='width:12px;height:6px;border:1px solid #cacaca;float:left;'></div>
							<div style='width:12px;height:6px;border:1px solid #cacaca;float:left;'></div>
							<div style='width:12px;height:6px;border:1px solid #cacaca;float:left;'></div>
							<div style='width:12px;height:6px;border:1px solid #cacaca;float:left;'></div>
						</div>
						<div style='width:12px;height:12px;border:1px solid #cacaca;float:left;'></div>
						<div style='width:6px;height:12px;border:1px solid #cacaca;float:left;'></div>
						<div style='width:6px;height:12px;border:1px solid #cacaca;float:left;'></div>
						<div style='width:6px;height:12px;border:1px solid #cacaca;float:left;'></div>
						<div style='width:6px;height:12px;border:1px solid #cacaca;float:left;'></div>
						<div style='width:6px;height:12px;border:1px solid #cacaca;float:left;'></div>
						<div style='width:6px;height:12px;border:1px solid #cacaca;float:left;'></div>
						<div style='width:6px;height:12px;border:1px solid #cacaca;float:left;'></div>
						<div style='width:6px;height:12px;border:1px solid #cacaca;float:left;'></div>
						<div style='width:6px;height:12px;border:1px solid #cacaca;float:left;'></div>
						<div style='width:12px;height:12px;border:1px solid #cacaca;float:left;'></div>
					</div>
				</div>
			</div>
			<div style='width:100%;'>
				<div style='width:33%;float:left;'>{{$sotosholy['player4_name']}}</div><div style='width:33%;float:left;'>{{$sotosholy['player4_balance']}}</div>
				<div style='width:33%;float:left;'>
						<div style='width:80px;height:79px;border:1px solid #cacaca;'>
						<div style='width:12px;height:12px;border:1px solid #cacaca;float:left;'></div>
						<div style='width:6px;height:12px;border:1px solid #cacaca;float:left;'></div>
						<div style='width:6px;height:12px;border:1px solid #cacaca;float:left;'></div>
						<div style='width:6px;height:12px;border:1px solid #cacaca;float:left;'></div>
						<div style='width:6px;height:12px;border:1px solid #cacaca;float:left;'></div>
						<div style='width:6px;height:12px;border:1px solid #cacaca;float:left;'></div>
						<div style='width:6px;height:12px;border:1px solid #cacaca;float:left;'></div>
						<div style='width:6px;height:12px;border:1px solid #cacaca;float:left;'></div>
						<div style='width:6px;height:12px;border:1px solid #cacaca;float:left;'></div>
						<div style='width:6px;height:12px;border:1px solid #cacaca;float:left;'></div>
						<div style='width:12px;height:12px;border:1px solid #cacaca;float:left;'></div>
						<div style='width:12px;height:54px;border:1px solid #cacaca;float:left;'>
							<div style='width:12px;height:6px;border:1px solid #cacaca;float:left;'></div>
							<div style='width:12px;height:6px;border:1px solid #cacaca;float:left;'></div>
							<div style='width:12px;height:6px;border:1px solid #cacaca;float:left;'></div>
							<div style='width:12px;height:6px;border:1px solid #cacaca;float:left;'></div>
							<div style='width:12px;height:6px;border:1px solid #cacaca;float:left;'></div>
							<div style='width:12px;height:6px;border:1px solid #cacaca;float:left;'></div>
							<div style='width:12px;height:6px;border:1px solid #cacaca;float:left;'></div>
							<div style='width:12px;height:6px;border:1px solid #cacaca;float:left;'></div>
							<div style='width:12px;height:6px;border:1px solid #cacaca;float:left;'></div>
						</div>
						<div style='width:54px;height:54px;border:1px solid #cacaca;float:left;'></div>
						<div style='width:12px;height:54px;border:1px solid #cacaca;float:left;'>
							<div style='width:12px;height:6px;border:1px solid #cacaca;float:left;'></div>
							<div style='width:12px;height:6px;border:1px solid #cacaca;float:left;'></div>
							<div style='width:12px;height:6px;border:1px solid #cacaca;float:left;'></div>
							<div style='width:12px;height:6px;border:1px solid #cacaca;float:left;'></div>
							<div style='width:12px;height:6px;border:1px solid #cacaca;float:left;'></div>
							<div style='width:12px;height:6px;border:1px solid #cacaca;float:left;'></div>
							<div style='width:12px;height:6px;border:1px solid #cacaca;float:left;'></div>
							<div style='width:12px;height:6px;border:1px solid #cacaca;float:left;'></div>
							<div style='width:12px;height:6px;border:1px solid #cacaca;float:left;'></div>
						</div>
						<div style='width:12px;height:12px;border:1px solid #cacaca;float:left;'></div>
						<div style='width:6px;height:12px;border:1px solid #cacaca;float:left;'></div>
						<div style='width:6px;height:12px;border:1px solid #cacaca;float:left;'></div>
						<div style='width:6px;height:12px;border:1px solid #cacaca;float:left;'></div>
						<div style='width:6px;height:12px;border:1px solid #cacaca;float:left;'></div>
						<div style='width:6px;height:12px;border:1px solid #cacaca;float:left;'></div>
						<div style='width:6px;height:12px;border:1px solid #cacaca;float:left;'></div>
						<div style='width:6px;height:12px;border:1px solid #cacaca;float:left;'></div>
						<div style='width:6px;height:12px;border:1px solid #cacaca;float:left;'></div>
						<div style='width:6px;height:12px;border:1px solid #cacaca;float:left;'></div>
						<div style='width:12px;height:12px;border:1px solid #cacaca;float:left;'></div>
					</div>
				</div>
			</div>
		</div>

			<div class='grid' style='margin-left:30%;margin-top:100px;height:655px;width:655px;'>
					<div id='spot-20' class='target-cell' style='border:1px solid #cacaca;height:100px;width:100px;float:left;'>
						<i style='margin-left:33px;margin-top:25px;' class='fa fa-pause fa-3x'></i><center>HODL!</center>
					</div>
					<div id='spot-21' class='target-cell' style='border:1px solid #cacaca;height:100px;width:50px;float:left;'>
						<div style='transform: rotate(180deg);'>
							<center>
								<div style='margin-top:35px;'><font size='1'>22,000 s</font></div>
								<div style='margin-left:4px;margin-top:21px;'>
									<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
									<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
									<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
									<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
								</div>
							</center>
						</div>
						<div style='width:100%;height:20px;background-color:red;margin-top:30px;'></div>
					</div>
					<div id='spot-22' class='target-cell' style='border:1px solid #cacaca;height:100px;width:50px;float:left;'>
						<div style='transform: rotate(180deg);'>
							<center>
								<div style='margin-top:20px;'><i class='fa fa-ticket fa-2x'></i></br>Sotoshi</br>Dice</div>
								<div style='margin-left:4px;margin-top:5px;'>
									<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
									<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
									<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
									<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
								</div>
							</center>
						</div>
					</div>
					<div id='spot-23' class='target-cell' style='border:1px solid #cacaca;height:100px;width:50px;float:left;'>
						<div style='transform: rotate(180deg);'>
							<center>
								<div style='margin-top:35px;'><font size='1'>22,000 s</font></div>
								<div style='margin-left:4px;margin-top:21px;'>
									<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
									<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
									<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
									<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
								</div>
							</center>
						</div>
						<div style='width:100%;height:20px;background-color:red;margin-top:30px;'></div>
					</div>
					<div id='spot-24' class='target-cell' style='border:1px solid #cacaca;height:100px;width:50px;float:left;'>
						<div style='transform: rotate(180deg);'>
							<center>
								<div style='margin-top:35px;'><font size='1'>24,000 s</font></div>
								<div style='margin-left:4px;margin-top:21px;'>
									<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
									<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
									<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
									<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
								</div>
							</center>
						</div>
						<div style='width:100%;height:20px;background-color:red;margin-top:30px;'></div>
					</div>
					<div id='spot-25' class='target-cell' style='border:1px solid #cacaca;height:100px;width:50px;float:left;'>
						<div style='transform: rotate(180deg);'>
							<center>
								<div style='margin-top:25px;'><i class='fa fa-signal fa-2x'></i></br><font size='1'>Bandwidth</br>20,000 s</font></div>
								<div style='margin-left:4px;margin-top:11px;'>
									<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
									<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
									<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
									<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
								</div>
							</center>
						</div>
					</div>
					<div id='spot-26' class='target-cell' style='border:1px solid #cacaca;height:100px;width:50px;float:left;'>
						<div style='transform: rotate(180deg);'>
							<center>
								<div style='margin-top:35px;'><font size='1'>26,000 s</font></div>
								<div style='margin-left:4px;margin-top:21px;'>
									<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
									<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
									<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
									<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
								</div>
							</center>
						</div>
						<div style='width:100%;height:20px;background-color:yellow;margin-top:30px;'></div>
					</div>
					<div id='spot-27' class='target-cell' style='border:1px solid #cacaca;height:100px;width:50px;float:left;'>
						<div style='transform: rotate(180deg);'>
							<center>
								<div style='margin-top:35px;'><font size='1'>26,000 s</font></div>
								<div style='margin-left:4px;margin-top:21px;'>
									<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
									<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
									<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
									<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
								</div>
							</center>
						</div>
						<div style='width:100%;height:20px;background-color:yellow;margin-top:30px;'></div>
					</div>
					<div id='spot-28' class='target-cell' style='border:1px solid #cacaca;height:100px;width:50px;float:left;'>
						<div style='transform: rotate(180deg);'>
							<center>
								<div style='margin-top:20px;'><i class='fa fa-line-chart fa-2x'></i></br><font size='1'>Margin</br>Trading</br>15,000 s</font></div>
								<div style='margin-left:4px;margin-top:5px;'>
									<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
									<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
									<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
									<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
								</div>
							</center>
						</div>
					</div>
					<div id='spot-29' class='target-cell' style='border:1px solid #cacaca;height:100px;width:50px;float:left;'>
						<div style='transform: rotate(180deg);'>
							<center>
								<div style='margin-top:35px;'><font size='1'>28,000 s</font></div>
								<div style='margin-left:4px;margin-top:21px;'>
									<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
									<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
									<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
									<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
								</div>
							</center>
						</div>
						<div style='width:100%;height:20px;background-color:yellow;margin-top:30px;'></div>
					</div>
					<div id='spot-30' class='target-cell' style='border:1px solid #cacaca;height:100px;width:100px;float:left;'>
						<center>
							<i style='margin-top:20px;' class='fa fa-legal fa-3x'></i></br>Silk Road Bust
						</center>
					</div>
					</br>
					<div style='height:450px;width:100px;float:left;'>
						<div id='spot-19' class='target-cell' style='height:50px;width:100px;border:1px solid #cacaca;float:left;'>
							<div style='width:20px;height:100%;float:right;background-color:orange;'></div>
							<div style='transform: rotate(90deg);'>
								<center>
									<div style='margin-top:25px;'><font size='1'>20,000 s</font></div>
									<div style='margin-left:21px;margin-top:29px;'>
										<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
										<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
										<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
										<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
									</div>
								</center>
							</div>
						</div>
						<div id='spot-18' class='target-cell' style='height:50px;width:100px;border:1px solid #cacaca;float:left;'>
							<div style='width:20px;height:100%;float:right;background-color:orange;'></div>
							<div style='transform: rotate(90deg);'>
								<center>
									<div style='margin-top:25px;'><font size='1'>18,000 s</font></div>
									<div style='margin-left:21px;margin-top:29px;'>
										<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
										<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
										<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
										<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
									</div>
								</center>
							</div>
						</div>
						<div id='spot-17' class='target-cell' style='height:50px;width:100px;border:1px solid #cacaca;float:left;'>
							<div style='transform: rotate(90deg);'>
								<center>
									<div style='margin-top:-10px;'><i class='fa fa-cubes fa-2x'></i></br>Solved</br>Block</div>
									<div style='margin-left:29px;margin-top:2px;'>
										<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
										<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
										<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
										<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
									</div>
								</center>
							</div>
						</div>
						<div id='spot-16' class='target-cell' style='height:50px;width:100px;border:1px solid #cacaca;float:left;'>
							<div style='width:20px;height:100%;float:right;background-color:orange;'></div>
							<div style='transform: rotate(90deg);'>
								<center>
									<div style='margin-top:25px;'><font size='1'>18,000 s</font></div>
									<div style='margin-left:21px;margin-top:29px;'>
										<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
										<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
										<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
										<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
									</div>
								</center>
							</div>
						</div>
						<div id='spot-15' class='target-cell' style='height:50px;width:100px;border:1px solid #cacaca;float:left;'>
							<div style='transform: rotate(90deg);'>
								<center>
									<div style='margin-top:-3px;'><i class='fa fa-signal fa-2x'></i></br><font size='1'>Bandwidth</br>20,000 s</font></div>
									<div style='margin-left:28px;margin-top:7px;'>
										<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
										<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
										<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
										<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
									</div>
								</center>
							</div>
						</div>
						<div id='spot-14' class='target-cell' style='height:50px;width:100px;border:1px solid #cacaca;float:left;'>
							<div style='width:20px;height:100%;float:right;background-color:#FA58F4;'></div>
							<div style='transform: rotate(90deg);'>
								<center>
									<div style='margin-top:25px;'><font size='1'>16,000 s</font></div>
									<div style='margin-left:21px;margin-top:29px;'>
										<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
										<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
										<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
										<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
									</div>
								</center>
							</div>
						</div>
						<div id='spot-13' class='target-cell' style='height:50px;width:100px;border:1px solid #cacaca;float:left;'>
							<div style='width:20px;height:100%;float:right;background-color:#FA58F4;'></div>
							<div style='transform: rotate(90deg);'>
								<center>
									<div style='margin-top:25px;'><font size='1'>14,000 s</font></div>
									<div style='margin-left:21px;margin-top:29px;'>
										<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
										<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
										<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
										<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
									</div>
								</center>
							</div>
						</div>
						<div id='spot-12' class='target-cell' style='height:50px;width:100px;border:1px solid #cacaca;float:left;'>
							<div style='transform: rotate(90deg);'>
								<center>
									<div style='margin-top:-10px;'><i class='fa fa-bolt fa-2x'></i><font size='1'></br>GPU</br>Power</br>15,000 s</font></div>
									<div style='margin-left:29px;margin-top:2px;'>
										<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
										<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
										<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
										<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
									</div>
								</center>
							</div>
						</div>
						<div id='spot-11' class='target-cell' style='height:50px;width:100px;border:1px solid #cacaca;float:left;'>
							<div style='width:20px;height:100%;float:right;background-color:#FA58F4;'></div>
							<div style='transform: rotate(90deg);'>
								<center>
									<div style='margin-top:25px;'><font size='1'>14,000 s</font></div>
									<div style='margin-left:21px;margin-top:29px;'>
										<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
										<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
										<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
										<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
									</div>
								</center>
							</div>
						</div>
					</div>
					<div id='ingame-dashboard' style='height:450px;width:450px;border:1px solid #cacaca;float:left;'>
						<div style=''>
							<i class='fa fa-bank fa-5x'></i> Bank Balance: <div id='game-bank-balance'>0</div>
						</div>
						
					</div>
					<div style='height:450px;width:100px;float:left;'>
						<div id='spot-31' class='target-cell' style='height:50px;width:100px;border:1px solid #cacaca;float:left;'>
							<div style='width:20px;height:100%;float:left;background-color:green;'></div>
							<div style='transform: rotate(270deg);'>
								<center>
									<div style='margin-top:25px;'><font size='1'>30,000 s</font></div>
									<div style='margin-left:37px;margin-top:28px;'>
										<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
										<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
										<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
										<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
									</div>
								</center>
							</div>
						</div>
						<div id='spot-32' class='target-cell' style='height:50px;width:100px;border:1px solid #cacaca;float:left;'>
							<div style='width:20px;height:100%;float:left;background-color:green;'></div>
							<div style='transform: rotate(270deg);'>
								<center>
									<div style='margin-top:25px;'><font size='1'>30,000 s</font></div>
									<div style='margin-left:37px;margin-top:28px;'>
										<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
										<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
										<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
										<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
									</div>
								</center>
							</div>
						</div>
						<div id='spot-33' class='target-cell' style='height:50px;width:100px;border:1px solid #cacaca;float:left;'>
							<div style='transform: rotate(270deg);'>
								<center>
									<div style='margin-top:-10px;'><i class='fa fa-cubes fa-2x'></i></br>Solved</br>Block</div>
									<div style='margin-left:28px;margin-top:2px;'>
										<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
										<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
										<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
										<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
									</div>
								</center>
							</div>
						</div>
						<div id='spot-34' class='target-cell' style='height:50px;width:100px;border:1px solid #cacaca;float:left;'>
							<div style='width:20px;height:100%;float:left;background-color:green;'></div>
							<div style='transform: rotate(270deg);'>
								<center>
									<div style='margin-top:25px;'><font size='1'>32,000 s</font></div>
									<div style='margin-left:37px;margin-top:28px;'>
										<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
										<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
										<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
										<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
									</div>
								</center>
							</div>
						</div>
						<div id='spot-35' class='target-cell' style='height:50px;width:100px;border:1px solid #cacaca;float:left;'>
							<div style='transform: rotate(270deg);'>
								<center>
									<div style='margin-top:-4px;'><i class='fa fa-signal fa-2x'></i></br><font size='0'>Bandwidth</br>20,000 s </font></div>
									<div style='margin-left:28px;margin-top:7px;'>
										<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
										<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
										<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
										<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
									</div>
								</center>
							</div>
						</div>
						<div id='spot-36' class='target-cell' style='height:50px;width:100px;border:1px solid #cacaca;float:left;'>
							<div style='transform: rotate(270deg);'>
								<center>
									<div style='margin-top:-10px;'><i class='fa fa-ticket fa-2x'></i></br>Sotoshi</br>Dice</div>
									<div style='margin-left:28px;margin-top:2px;'>
										<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
										<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
										<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
										<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
									</div>
								</center>
							</div>
						</div>
						<div id='spot-37' class='target-cell' style='height:50px;width:100px;border:1px solid #cacaca;float:left;'>
							<div style='width:20px;height:100%;float:left;background-color:blue;'></div>
							<div style='transform: rotate(270deg);'>
								<center>
									<div style='margin-top:25px;'><font size='1'>35,000 s</font></div>
									<div style='margin-left:37px;margin-top:28px;'>
										<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
										<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
										<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
										<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
									</div>
								</center>
							</div>
						</div>
						<div id='spot-38' class='target-cell' style='height:50px;width:100px;border:1px solid #cacaca;float:left;'>
							<center>
								<div style='transform: rotate(270deg);'>
									<div style=''>Audit</br><font size='0'>10% or</br>20,000 s</font></div>
									<div style='margin-left:28px;margin-top:11px;'>
										<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
										<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
										<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
										<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
									</div>
								</div>
							</center>
						</div>
						<div id='spot-39' class='target-cell' style='height:50px;width:100px;border:1px solid #cacaca;float:left;'>
							<div style='width:20px;height:100%;float:left;background-color:blue;'></div>
							<div style='transform: rotate(270deg);'>
								<center>
									<div style='margin-top:25px;'><font size='1'>40,000 s</font></div>
									<div style='margin-left:37px;margin-top:28px;'>
										<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
										<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
										<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
										<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
									</div>
								</center>
							</div>
						</div>
					</div>
					<div id='spot-10' class='target-cell' style='height:100px;width:100px;border:1px solid #cacaca;float:left;'>
						<img style='float:right;' src='images/Mt-Gox-Logo.png' width='75px'/>
						<center>
							<div style='margin-left:53px;margin-top:85px;'>
								<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
								<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
								<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
								<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
							</div>
						</center>
					</div>
					<div id='spot-9' class='target-cell' style='height:100px;width:50px;border:1px solid #cacaca;float:left;'>
						<div style='width:100%;height:20px;background-color:#81F7F3;'></div>
						<center>
							<div style='margin-top:25px;'><font size='1'>12,000 s</font></div>
							<div style='margin-left:4px;margin-top:26px;'>
								<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
								<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
								<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
								<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
							</div>
						</center>
					</div>
					<div id='spot-8' class='target-cell' style='height:100px;width:50px;border:1px solid #cacaca;float:left;'>
						<div style='width:100%;height:20px;background-color:#81F7F3;'></div>
						<center>
							<div style='margin-top:25px;'><font size='1'>10,000 s</font></div>
							<div style='margin-left:4px;margin-top:26px;'>
								<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
								<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
								<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
								<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
							</div>
						</center>
					</div>
					<div id='spot-7' class='target-cell' style='height:100px;width:50px;border:1px solid #cacaca;float:left;'>
						<center>
							<div style='margin-top:10px;'><i class='fa fa-ticket fa-2x'></i>Sotoshi Dice</div>
							<div style='margin-left:4px;margin-top:8px;'>
								<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
								<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
								<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
								<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
							</div>
						</center>
					</div>
					<div id='spot-6' class='target-cell' style='height:100px;width:50px;border:1px solid #cacaca;float:left;'>
						<div style='width:100%;height:20px;background-color:#81F7F3;'></div>
						<center>
							<div style='margin-top:25px;'><font size='1'>10,000 s</font></div>
							<div style='margin-left:4px;margin-top:26px;'>
								<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
								<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
								<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
								<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
							</div>
						</center>
					</div>
					<div id='spot-5' class='target-cell' style='height:100px;width:50px;border:1px solid #cacaca;float:left;'>
						<center>
							<div style='margin-top:10px;'><i class='fa fa-signal fa-2x'></i></br><font size='1'>Bandwidth</br>20,000 s</font></div>
							<div style='margin-left:4px;margin-top:19px;'>
								<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
								<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
								<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
								<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
							</div>
						</center>
					</div>
					<div id='spot-4' class='target-cell' style='height:100px;width:50px;border:1px solid #cacaca;float:left;'>
						<center>
							<div style='margin-top:10px;'><i class='fa fa-pie-chart fa-2x'></i>Trading Fees</div>
							<div style='margin-left:4px;margin-top:8px;'>
								<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
								<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
								<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
								<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
							</div>
						</center>
					</div>
					<div id='spot-3' class='target-cell' style='height:100px;width:50px;border:1px solid #cacaca;float:left;'>
						<div style='width:100%;height:20px;background-color:brown;'></div>
						<center>
							<div style='margin-top:25px;'><font size='1'>6,000 s</font></div>
							<div style='margin-left:4px;margin-top:26px;'>
								<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
								<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
								<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
								<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
							</div>
						</center>
					</div>
					<div id='spot-2' class='target-cell' style='height:100px;width:50px;border:1px solid #cacaca;float:left;'>
						<center><div style='margin-top:10px;'><i class='fa fa-cubes fa-2x'></i>Solved Block</div></center>
						<center>
							<div style='margin-left:4px;margin-top:8px;'>
								<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
								<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
								<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
								<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
							</div>
						</center>
					</div>
					<div id='spot-1' class='target-cell' style='height:100px;width:50px;border:1px solid #cacaca;float:left;'>
						<div style='width:100%;height:20px;background-color:brown;'></div>
						<center>
							<div style='margin-top:25px;'><font size='1'>6,000 s</font></div>
							<div style='margin-left:4px;margin-top:26px;'>
								<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
								<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
								<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
								<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
							</div>
						</center>
					</div>
					<div id='spot-0' class='target-cell' style='height:100px;width:100px;border:1px solid #cacaca;float:left;'>
						GO</br><i class='fa fa-long-arrow-left fa-5x'></i>
						<center>
							<div style='margin-left:4px;margin-top:-5px;'>
								<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
								<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
								<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
								<div style='width:10px;height:10px;border:1px solid #cacaca;float:left;'></div>
							</div>
						</center>
					</div>
				</div>
</div>
@stop

@section('js_packages')
@stop

@section('hidden_variables')
<input type='hidden' id='join-room' value='0' />
<input type='hidden' id='gameiid' value='{{$sotosholy["id"]}}' />
@stop
