@extends('layouts.logged')
@include('logged.index.child.nav')
@include('logged.index.child.footer')

@section('body')
<div class='row-fluid' ng-controller='ProfileCtrl'>
	<div class='col-md-12' style='background-color:white;border-radius:25px;border:2px solid #cacaca;'>
		<div class='col-md-2'>
			<div style='min-width:300px;min-height:300px;max-width:300px;max-height:300px;'><div style='overflow:hidden;'>
				<img id="profile-image" style="{{ $image_main['profile_style'] }}" 
				src="/L-project/public/images/{{ $image_main['filename'] }}" />
			</div>
			</div>
		</div>
			
		<div class='col-md-10'>
			<div class='col-md-2' id='iam-display'>
				<center><span style='font-size: 175%;'>I Am</span></center>
				<input id='iam1' type='text' class="form-control" name='iam-1' value='{{$iam1}}' style='' />
				<input id='iam2' type='text' class="form-control" name='iam-2' value='{{$iam2}}' style='margin-top:15px;' />
				<input id='iam3' type='text' class="form-control" name='iam-3' value='{{$iam3}}' style='margin-top:15px;' />
				<input id='iam4' type='text' class="form-control" name='iam-4' value='{{$iam4}}' style='margin-top:15px;' />
				<input id='iam5' type='text' class="form-control" name='iam-5' value='{{$iam5}}' style='margin-top:15px;' />
			</div>
			<div class='col-md-2' id='looking-display'>
				<center><span style='font-size: 175%;'>And Looking For</span></center>
				<input id='lookingfor1' type='text' class="form-control" name='lookingfor-1' value='{{$lookingfor1}}' style='' />
				<input id='lookingfor2' type='text' class="form-control" name='lookingfor-2' value='{{$lookingfor2}}' style='margin-top:15px;' />
				<input id='lookingfor3' type='text' class="form-control" name='lookingfor-3' value='{{$lookingfor3}}' style='margin-top:15px;' />
				<input id='lookingfor4' type='text' class="form-control" name='lookingfor-4' value='{{$lookingfor4}}' style='margin-top:15px;' />
				<input id='lookingfor5' type='text' class="form-control" name='lookingfor-5' value='{{$lookingfor5}}' style='margin-top:15px;' />
			</div>
			<div class='col-md-2' id='provide-display'>
				<center><span style='font-size: 175%;'>And Can Provide</span></center>
				<input id='canprovide1' type='text' class="form-control" name='canprovide-1' value='{{$canprovide1}}' style='' />
				<input id='canprovide2' type='text' class="form-control" name='canprovide-2' value='{{$canprovide2}}' style='margin-top:15px;' />
				<input id='canprovide3' type='text' class="form-control" name='canprovide-3' value='{{$canprovide3}}' style='margin-top:15px;' />
				<input id='canprovide4' type='text' class="form-control" name='canprovide-4' value='{{$canprovide4}}' style='margin-top:15px;' />
				<input id='canprovide5' type='text' class="form-control" name='canprovide-5' value='{{$canprovide5}}' style='margin-top:15px;' />
			</div>
			<div class='col-md-2' id='near-display'>
				<center><span style='font-size: 175%;'>Near</span></center>
				<input id='near1' type='text' class="form-control" name='near-1' value='{{$near1}}' style='' />
				<input id='near2' type='text' class="form-control" name='near-2' value='{{$near2}}' style='margin-top:15px;' />
				<input id='near3' type='text' class="form-control" name='near-3' value='{{$near3}}' style='margin-top:15px;' />
				<input id='near4' type='text' class="form-control" name='near-4' value='{{$near4}}' style='margin-top:15px;' />
				<input id='near5' type='text' class="form-control" name='near-5' value='{{$near5}}' style='margin-top:15px;' />
			</div>
			<div class='col-md-4'>
				<button id='save-profile-tags' ng-click='saveProfileTags();' style='margin-top:35px;width:100%;border:2px solid black;' class='btn btn-info btn-xs'>Save</button>
				<div style='margin-top:7px;'>
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
					 <a href='crop/{{ $image["id"] }}'><img style='margin-left:-{{ $image["x_calc"] }}px;margin-top:-{{ $image["y_calc"] }}px;height:{{ $image["h_calc"] }}px;width{{ $image["w_calc"] }}:px;' src="/L-project/public/images/user_images/{{$id}}/{{ $image['filename'] }}" /></a>
					</div>
				</div>
				@endforeach
			</div>
		</div>
	</div>
</div>		
@stop

@section('js_packages')
<script type='text/javascript' src='/L-project/public/js/drag_and_drop.js'></script>
@stop
