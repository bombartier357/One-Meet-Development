console.log('crop_image.js LOADED');

function crop(image_id){
	var x = $('#x-coords').val();
	var y = $('#y-coords').val();
	var w = $('#width-coords').val();
	var h = $('#height-coords').val();
	
	console.log(x+"."+y+"."+w+"."+h);
	
	var ajax_local = 'ajax.php';
    $.post(ajax_local,{id:image_id,x_coords:x,y_coords:y,w_coords:w,h_coords:h})
		.done(function(){
			location.reload();
			});
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
