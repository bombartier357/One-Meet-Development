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
	<div ng-controller='SearchCtrl' style='height:800px;background-color:white;margin-left:-15px;border:1px solid #cacaca;border-radius: 25px;' class='col-md-10' id='home-screen'>
		<center>
			<table class='table table-striped' style='margin-top:5px;'>
					<tr>
			<th>Avatar</th><th>User</th><th>Sex</th><th><span style='float:right;'>Actions</span></th>
			</tr>
			@foreach ($fav_rows as $fav)
				<tr><td ng-click="nav_profile({{ $fav['id'] }});">
					<div style='min-width:50px;min-height:50px;max-width:50px;max-height:50px;'><div style='overflow:hidden;'>
						<img  style="{{ $fav['profile_style'] }}" src="/L-project/public/images/{{ $fav['filename'] }}" />
					</div>
					</div>
			</td><td ng-click="nav_profile({{ $fav['id'] }});">{{$fav['user']}}</td><td ng-click="nav_profile({{ $fav['id'] }});">{{$fav['sex']}}</td>
				 <td>
					 <div style='float:right;'>
						<button id='make-favorite{{$fav["id"]}}' ng-click='make_favorite({{$fav["id"]}},1);' type='button' class='{{ $fav["button1"] }} btn-lg'>
							<span class='glyphicon glyphicon-star' aria-hidden='true'></span>
						</button>
						<button id='make-message{{$fav["id"]}}' ng-click='make_favmail({{$fav["id"]}},1);' type='button' class='{{ $fav["button2"] }} btn-lg'>
							<span class='glyphicon glyphicon-envelope' aria-hidden='true'></span>
						</button>
						<button id='make-chat{{$fav["id"]}}' ng-click='make_favchat({{$fav["id"]}},1);' type='button' class='{{ $fav["button3"] }} btn-lg'>
							<span class='glyphicon glyphicon-comment' aria-hidden='true'></span>
						</button>
						<button id='make-video{{$fav["id"]}}' ng-click='make_favvideo({{$fav["id"]}},1)' type='button' class='{{ $fav["button4"] }} btn-lg'>
							<span class='glyphicon glyphicon-facetime-video' aria-hidden='true'></span>
						</button>
					</div>
				 </td>
				 </tr>
			@endforeach
			</table>
		</center>
	</div>
@stop

@section('js_packages')
@stop
