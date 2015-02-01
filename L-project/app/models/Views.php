<?php

class Views extends Eloquent {
	public $table = 'views_schema';
	
	//Guarded variables
	protected $guarded = array('id');
	protected $fillable = array('viewer_id', 'viewed_id');
}
