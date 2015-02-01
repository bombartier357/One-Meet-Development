@extends('layouts.logged')
@include('logged.index.child.nav')
@include('logged.index.child.footer')

@section('header')
<link href='/L-project/public/css/croppic.css' rel='stylesheet'> 
@stop

@section('body')
<div class='col-md-12' >
	<div class='col-md-12' id='matches'>
		<center><button onclick='crop({{ $image->id }});' class='btn btn-success'>Crop</button><button onclick='delete_image({{ $image->id }}, {{ $id }});' id='delete-image-button' class='btn btn-danger'>DELETE</button><button onclick='make_private_image(".$_GET['imageid'].");' class='btn btn-info'>Make Private</button></center>
			<div class='col-md-6'>
				<center><img id="crop-this-image" style="flat:left;" src="/L-project/public/images/user_images/{{$id}}/{{$image->filename}}" /></center>
			</div>
			<div class='col-md-6'>
					<center><div style='overflow:hidden;width:{{ $image->w_coords }}px;height:{{ $image->h_coords }}px;'><img id='cropped-image' style='margin-left:-{{ $image->x_coords }}px;margin-top:-{{ $image->y_coords }}px;' src='/L-project/public/images/user_images/{{$id}}/{{$image->filename}}' /></div></center>
			</div>
	</div>
</div>
@stop

@section('hidden_variables')
<input type='hidden' id='x-coords' />
<input type='hidden' id='y-coords' />
<input type='hidden' id='width-coords' />
<input type='hidden' id='height-coords' />
@stop

@section('js_packages')
<script src='/L-project/public/js/cropper.min.js'></script>
<script src='/L-project/public/js/crop_image.js'></script>
@stop
