console.log('crop_image.js LOADED');

var image = document.getElementById('crop-this-image').onload = function () {
    new Cropper(this, {
		min_width:  400,
		min_height: 200
        // options
    });
}
