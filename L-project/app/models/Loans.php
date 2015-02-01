<?php

class Loans extends Eloquent {
	public $table = 'loans_schema';
	
	//Guarded variables
	protected $guarded = array('id');
	protected $fillable = array('owner', 'amount', 'interest', 'penalty', 'period', 'period_count', 'starting', 'peg_dollar', 'peg_price', 'funded', 'payments_ontime', 'payments_late');
}
