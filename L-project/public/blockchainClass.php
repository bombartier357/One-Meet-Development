<?php

class blockchainClass{
	
	private $guid="fe857b4d-67e9-4a35-abc2-4fcce9ed0bc7";
	private $firstpassword="Traderb0tz!";
	private $secondpassword="PASSWORD_HERE";
	//public $amounta = "10000000";
	//public $amountb = "400000";
	//public $addressa = "1A8JiWcwvpY7tAopUkSnGuEYHmzGYfZPiq";
	//public $addressb = "1ExD2je6UNxL5oSu6iPUhn9Ta7UrN8bjBy";
	
	/*public $recipients = urlencode('{
					  "'.$this->addressa.'": '.$this->amounta.',
					  "'.$this->addressb.'": '.$this->amountb.'
				   }');*/
				   
	public function __construct(){
		
	}
	
	public function get_balance($address){
		$confirmations = 6;
		$json_url = "https://blockchain.info/merchant/".$this->guid."/address_balance?password=".$this->firstpassword."&address=".$address."&confirmations=".$confirmations;

		$json_data = file_get_contents($json_url);
		
		$json_feed = json_decode($json_data);

		$balance = 0;//$json_feed->balance;
		
		return $balance;
	}
	
	public function generate_address($user, $id){
		$json_url = "https://blockchain.info/merchant/".$this->guid."/new_address?password=".$this->firstpassword."&second_password=".$this->secondpassword."&label=".$user.$id;

		$json_data = file_get_contents($json_url);
		
		$json_feed = json_decode($json_data);

		$address = $json_feed->address;
		
		return $address;
	}
}

?>
