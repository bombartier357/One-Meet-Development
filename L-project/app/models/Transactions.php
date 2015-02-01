<?php

class Transactions extends Eloquent {
	public $table = 'transactions_schema';
	
	//Guarded variables
	protected $guarded = array('id');
	protected $fillable = array('from_id', 'to_id', 'amount', 'type', 'from_rating', 'to_rating', 'from_comment', 'to_comment', 'from_accepted', 'to_accepted');
}
 
