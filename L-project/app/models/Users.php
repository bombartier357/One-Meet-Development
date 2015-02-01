<?php

class Users extends Eloquent {
	public $table = 'users_schema';
	
	//Guarded variables
	protected $guarded = array('id');
	protected $fillable = array('user', 'email', 'sex', 'password', 'video_room', 'chat_room', 'auto_mail', 'auto_chat', 'auto_video', 'iam1', 'iam2', 'iam3', 'iam4', 'iam5', 'lookingfor1', 'lookingfor2', 'lookingfor3', 'lookingfor4', 'lookingfor5', 'canprovide1', 'canprovide2', 'canprovide3', 'canprovide4', 'canprovide5', 'near1', 'near2', 'near3', 'near4', 'near5');
}
 
