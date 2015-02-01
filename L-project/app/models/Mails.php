<?php

class Mails extends Eloquent {
	public $table = 'mail_schema';
	
	//Guarded variables
	protected $guarded = array('id');
	protected $fillable = array('sender_id', 'receiver_id', 'subject', 'text');
}
