@extends('layouts.logged')
@include('logged.index.child.nav')
@include('logged.index.child.footer')

@section('body')
<div class='col-md-12' id='search' style='background-color:white;border-radius:25px;' ng-controller='SearchCtrl'>
			<div style='background-color:white;margin-top:5px;' class='col-md-12'>Search
			<div class='col-md-12' id='search-form'>
			<div class='row'>
			  <div class='col-lg-2'>
			  <form class='form-inline' role='form'>
				<div class='form-group'>
					<div class='input-group'>
					<span class='input-group-btn'>
						<button ng-click='makeSearch()' class='btn btn-default' type='button'>Go!</button>
					</span>
					<input id='search-input' type='text' class='form-control' placeholder='User Name'>
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
			</div></div>
			<div id='search-results' style='overflow-y: hidden;'>
				<table class='table table-striped'>
					<tr>
			<th>Avatar</th><th>User</th><th>Sex</th><th><span style='float:right;'>Actions</span></th>
			</tr>
			<tr ng-repeat="search in search_data"><td ng-click="nav_profile(search.id);">
					 <div style='min-width:50px;min-height:50px;max-width:50px;max-height:50px;'><div style='overflow:hidden;'>
						<img  style="{[{search.profile_style}]}" src="/L-project/public/images/{[{search.avatar}]}" />
					</div>
					 </td><td ng-click="nav_profile(search.id);" ng-bind="search.user"></td><td ng-click="nav_profile(search.id);" ng-bind="search.sex"></td>
				 <td>
					 <div style='float:right;'>
						<button id='make-favorite{[{search.id}]}' ng-click='make_favorite(search.id,1);' type='button' class='{[{search.button1}]} btn-lg'>
							<span class='glyphicon glyphicon-star' aria-hidden='true'></span>
						</button>
						<button id='make-message{[{search.id}]}' ng-click='make_favmail(search.id,1);' type='button' class='{[{search.button2}]} btn-lg'>
							  <span class='glyphicon glyphicon-envelope' aria-hidden='true'></span>
						</button>
						<button id='make-chat{[{search.id}]}' ng-click='make_favchat(search.id,1);' type='button' class='{[{search.button3}]} btn-lg'>
							  <span class='glyphicon glyphicon-comment' aria-hidden='true'></span>
						</button>
						<button id='make-video{[{search.id}]}' ng-click='make_favvideo(search.id,1)' type='button' class='{[{search.button4}]} btn-lg'>
							  <span class='glyphicon glyphicon-facetime-video' aria-hidden='true'></span>
						</button>
					</div>
				</td>
			</tr>
			@foreach ($master_list as $list)
				 <tr class='init-search-rows'>
					 <td ng-click="nav_profile({{ $list['id'] }});">
						 <div style='min-width:50px;min-height:50px;max-width:50px;max-height:50px;'><div style='overflow:hidden;'>
							<img  style="{{ $list['profile_style'] }}" src="/L-project/public/images/{{ $list['avatar'] }}" />
						 </div>
					</td>
					<td ng-click="nav_profile({{ $list['id'] }});">{{$list['user']}}</td><td ng-click="nav_profile({{ $list['id'] }});">{{$list['sex']}}</td>
					<td>
						<div style='float:right;'>
							<button id='make-favorite{{$list["id"]}}' ng-click='make_favorite({{ $list["id"] }},1);' type='button' class='{{ $list["button1"] }} btn-lg'>
								<span class='glyphicon glyphicon-star' aria-hidden='true'></span>
							</button>
							<button id='make-message{{$list["id"]}}' ng-click='make_favmail({{ $list["id"] }},1);' type='button' class='{{ $list["button2"] }} btn-lg'>
								  <span class='glyphicon glyphicon-envelope' aria-hidden='true'></span>
							</button>
							<button id='make-chat{{$list["id"]}}' ng-click='make_favchat({{ $list["id"] }},1);' type='button' class='{{ $list["button3"] }} btn-lg'>
								  <span class='glyphicon glyphicon-comment' aria-hidden='true'></span>
							</button>
							<button id='make-video{{$list["id"]}}' ng-click='make_favvideo({{ $list["id"] }},1)' type='button' class='{{ $list["button4"] }} btn-lg'>
								  <span class='glyphicon glyphicon-facetime-video' aria-hidden='true'></span>
							</button>
						</div>
					</td>
				</tr>
			@endforeach
			
			</table>
		</div>
	<div>Pagination</div>
</div>
@stop

@section('js_packages')
@stop


