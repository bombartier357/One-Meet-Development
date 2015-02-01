<?php

class Rooms extends Eloquent {
	public $table = 'chat_rooms_schema';
	
	//Guarded variables
	protected $guarded = array('id');
	protected $fillable = array('owner_id', 'room_name', 'type');
}
