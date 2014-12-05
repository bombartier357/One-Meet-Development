<?
$con = new PDO('mysql:host=localhost;dbname=botcry5_date;charset=utf8', 'botcry5_trader', 'traderb0tz', array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
			
		if (!$con)
		{
			die('Could not connect: ' . mysql_error());
		}

if(isset('actionbuttons')){
	$my_id = $_POST['myid'];
	$fav_id = $_POST['favid'];
}

?>
