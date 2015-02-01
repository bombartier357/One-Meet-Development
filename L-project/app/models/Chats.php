<?php

class Chats extends Eloquent {
	public $table = 'chat_schema';
	
	//Guarded variables
	protected $guarded = array('id');
	protected $fillable = array('room_id', 'sender_id', 'text');
}
