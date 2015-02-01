console.log('crop_image.js LOADED');

function crop(image_id){
	var x = $('#x-coords').val();
	var y = $('#y-coords').val();
	var w = $('#width-coords').val();
	var h = $('#height-coords').val();
	
	console.log(x+"."+y+"."+w+"."+h);
	
	var ajax_local = '/L-project/public/logged/ajax/crop_image';
    $.post(ajax_local,{id:image_id,x_coords:x,y_coords:y,w_coords:w,h_coords:h})
		.done(function(){
			location.reload();
			});
}

function delete_image(id, owner){
	var del_button = confirm('Are you sure you would like to delete this picture?  This cannot be undone.');
	
	if(del_button){
		var ajax_local = '/L-project/public/logged/ajax/delete_image';
		$.post(ajax_local,{id:id,owner:owner})
		.done(function(data){
			//location.reload();
			window.location.replace('/L-project/public/logged/profile/');
			//alert(data);
			});
	}
}

function make_private_image(id, owner){
	var make_private = confirm('Are you sure you would like to make this picture private?  You will have to manually add permissions for members so they can see this picture in the future.');
	
	if(make_private){
		var ajax_local = 'ajax.php';
		$.post(ajax_local,{id:id,type:'make_private_image'})
		.done(function(){
			location.reload();
			});
	}
}


$(document).ready(function() 
{
	var image = document.getElementById('crop-this-image').onload = function () {
		new Cropper(this, {
			min_width:  300,
			min_height: 300,
			update: function (coordinates){
				$('#x-coords').val(coordinates['x']);
				$('#y-coords').val(coordinates['y']);
				$('#width-coords').val(coordinates['width']);
				$('#height-coords').val(coordinates['width']);
			}
			// options
		});
	}
	
	
});
