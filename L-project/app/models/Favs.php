<?php

class Favs extends Eloquent {
	public $table = 'favs_schema';
	
	//Guarded variables
	protected $guarded = array('id');
	protected $fillable = array('fav_owner', 'fav_id', 'type');
}
