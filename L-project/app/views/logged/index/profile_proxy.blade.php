@extends('layouts.logged')
@include('logged.index.child.nav')
@include('logged.index.child.footer')

@section('body')
<div class='row-fluid'>
	<div class='col-md-12' style='background-color:white;border-radius:25px;border:2px solid #cacaca;'>
		<div class='col-md-2'>
			<div style='min-width:300px;min-height:300px;max-width:300px;max-height:300px;'><div style='overflow:hidden;'>
				<img id="profile-image" style="{{ $image_main['profile_style'] }}" 
				src="/L-project/public/images/{{ $image_main['filename'] }}" />
			</div>
			</div>
		</div>
		
		<div ng-controller='SearchCtrl' class='col-md-10'>
			<div class='col-md-2' id='iam-display'>
				<center><span style='font-size: 175%;'>I Am</span></center>
				<input type='text' class="form-control" name='iam-1' value='{{$profile_user["iam1_proxy"]}}' style='' />
				<input type='text' class="form-control" name='iam-2' value='{{$profile_user["iam2_proxy"]}}' style='margin-top:15px;' />
				<input type='text' class="form-control" name='iam-3' value='{{$profile_user["iam3_proxy"]}}' style='margin-top:15px;' />
				<input type='text' class="form-control" name='iam-4' value='{{$profile_user["iam4_proxy"]}}' style='margin-top:15px;' />
				<input type='text' class="form-control" name='iam-5' value='{{$profile_user["iam5_proxy"]}}' style='margin-top:15px;' />
			</div>
			<div class='col-md-2' id='looking-display'>
				<center><span style='font-size: 175%;'>And Looking For</span></center>
				<input type='text' class="form-control" name='lookingfor-1' value='{{$profile_user["lookingfor1_proxy"]}}' style='' />
				<input type='text' class="form-control" name='lookingfor-2' value='{{$profile_user["lookingfor2_proxy"]}}' style='margin-top:15px;' />
				<input type='text' class="form-control" name='lookingfor-3' value='{{$profile_user["lookingfor3_proxy"]}}' style='margin-top:15px;' />
				<input type='text' class="form-control" name='lookingfor-4' value='{{$profile_user["lookingfor4_proxy"]}}' style='margin-top:15px;' />
				<input type='text' class="form-control" name='lookingfor-5' value='{{$profile_user["lookingfor5_proxy"]}}' style='margin-top:15px;' />
			</div>
			<div class='col-md-2' id='provide-display'>
				<center><span style='font-size: 175%;'>And Can Provide</span></center>
				<input type='text' class="form-control" name='canprovide-1' value='{{$profile_user["canprovide1_proxy"]}}' style='' />
				<input type='text' class="form-control" name='canprovide-2' value='{{$profile_user["canprovide2_proxy"]}}' style='margin-top:15px;' />
				<input type='text' class="form-control" name='canprovide-3' value='{{$profile_user["canprovide3_proxy"]}}' style='margin-top:15px;' />
				<input type='text' class="form-control" name='canprovide-4' value='{{$profile_user["canprovide4_proxy"]}}' style='margin-top:15px;' />
				<input type='text' class="form-control" name='canprovide-5' value='{{$profile_user["canprovide5_proxy"]}}' style='margin-top:15px;' />
			</div>
			<div class='col-md-2' id='near-display'>
				<center><span style='font-size: 175%;'>Near</span></center>
				<input type='text' class="form-control" name='near-1' value='{{$profile_user["near1_proxy"]}}' style='' />
				<input type='text' class="form-control" name='near-2' value='{{$profile_user["near2_proxy"]}}' style='margin-top:15px;' />
				<input type='text' class="form-control" name='near-3' value='{{$profile_user["near3_proxy"]}}' style='margin-top:15px;' />
				<input type='text' class="form-control" name='near-4' value='{{$profile_user["near4_proxy"]}}' style='margin-top:15px;' />
				<input type='text' class="form-control" name='near-5' value='{{$profile_user["near5_proxy"]}}' style='margin-top:15px;' />
			</div>
			<div class='col-md-4' id='user-actions'>
				<div style='float:right;margin-top:15px;margin-left:5px;'>
					<button id='make-favorite{{$profile_user["id"]}}' ng-click='make_favorite({{$profile_user["id"]}},1);' type='button' class='{{ $profile_user["button1"] }} btn-lg'>
						<span class='glyphicon glyphicon-star' aria-hidden='true'></span>
					</button>
					<button id='make-message{{$profile_user["id"]}}' ng-click='make_favmail({{$profile_user["id"]}},1);' type='button' class='{{ $profile_user["button2"] }} btn-lg'>
						<span class='glyphicon glyphicon-envelope' aria-hidden='true'></span>
					</button>
					<button id='make-chat{{$profile_user["id"]}}' ng-click='make_favchat({{$profile_user["id"]}},1);' type='button' class='{{ $profile_user["button3"] }} btn-lg'>
						<span class='glyphicon glyphicon-comment' aria-hidden='true'></span>
					</button>
					<button id='make-video{{$profile_user["id"]}}' ng-click='make_favvideo({{$profile_user["id"]}},1)' type='button' class='{{ $profile_user["button4"] }} btn-lg'>
						<span class='glyphicon glyphicon-facetime-video' aria-hidden='true'></span>
					</button>
				</div>
				<button ng-click='confirm_send_btc({{$profile_user["id"]}});' id='send-coin-user' type='button' class='btn btn-default btn-lg' style='float:right;border:2px solid #cacaca;margin-top:15px;margin-left:5px;'><i class='fa fa-bitcoin'></i><i class='fa fa-level-down'></i></button>
				<button id='request-coin-user' type='button' class='btn btn-default btn-lg' style='float:right;border:2px solid #cacaca;margin-top:15px;'><i class='fa fa-bitcoin'></i><i class='fa fa-level-up'></i></button>
				<div style='margin-top:65px;'>
					<center><span style='font-size: 175%;'>Bio</span></center>
					<textarea style='border-radius:10px;' cols='75' rows='8'></textarea></textarea>
				</div>
			</div>
		</div>
	</div>
	<div class='col-md-12' id='image-reel' style='border-radius:25px;margin-top:5px;border:2px solid #cacaca;'>Images
			{{ Form::open(array('url'=>'images/upload', 'method'=>'POST', 'files'=>true)) }}
				{{ Form::label('upload_image', 'Upload an image') }}
				<p></p>
				{{ Form::file('upload_image') }}
				{{ Form::hidden('upload_id', $id) }}
				{{ Form::submit('Upload') }}
			{{ Form::close() }}
			<div id='image-display'>
				<div class='col-md-1' >
					<div style='width:120px;height:250px;' ondrop='drop(event)' ondragover='allowDrop(event)'></div>
				</div>
				<div class='col-md-11'>
					@foreach ($master_reel as $image)
					<div style='min-width:300px;min-height:300px;max-width:300px;max-height:300px;float:left;'>
						<div style='overflow:hidden;'>
						 <a href='/L-project/public/logged/crop/{{ $image["id"] }}'><img style='margin-left:-{{ $image["x_calc"] }}px;margin-top:-{{ $image["y_calc"] }}px;height:{{ $image["h_calc"] }}px;width{{ $image["w_calc"] }}:px;' src="/L-project/public/images/user_images/{{$image['owner']}}/{{ $image['filename'] }}" /></a>
						</div>
					</div>
					@endforeach
				</div>
		</div>
	</div>	
</div>
		
<input type='hidden' id='viewing-profile-proxy-id' />
@stop

@section('js_packages')
<script type='text/javascript' src='/L-project/public/js/drag_and_drop.js'></script>
@stop
