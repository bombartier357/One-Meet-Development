<?php

class Directories extends Eloquent {
	public $table = 'directory_schema';
	
	//Guarded variables
	protected $guarded = array('id');
	protected $fillable = array('name', 'phone', 'address', 'specialty', 'sub_specialty', 'lat', 'lon');
}
