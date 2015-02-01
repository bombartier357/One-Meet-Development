<?php

class Images extends Eloquent {
	public $table = 'images_schema';
	
	//Guarded variables
	protected $guarded = array('id');
	protected $fillable = array('owner', 'filename', 'x_coords', 'y_coords', 'w_coords', 'h_coords', 'init_height', 'init_width', 'order_img');
}
