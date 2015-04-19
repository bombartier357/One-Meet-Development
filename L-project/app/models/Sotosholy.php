<?php

class Sotosholy extends Eloquent {
	public $table = 'sotosholy_schema';
	
	//Guarded variables
	protected $guarded = array('id');
	protected $fillable = array('max_players', 'bounty', 'turn', 'turn_time', 'start', 'start_time', 'player1', 'player2', 'player3', 'player4', 'player1_balance', 'player2_balance', 'player3_balance', 'player4_balance', 'player1_color', 'player2_color', 'player3_color', 'player4_color', 'player1_property', 'player2_property', 'player3_property', 'player4_property');
}
