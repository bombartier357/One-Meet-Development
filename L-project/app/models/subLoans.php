<?php

class subLoans extends Eloquent {
	public $table = 'loan_sub_schema';
	
	//Guarded variables
	protected $guarded = array('id');
	protected $fillable = array('loan_id', 'owner_id', 'amount', 'currency');
}
