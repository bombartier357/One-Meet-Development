<?
//echo "ajax.php LOADED";

$con = new PDO('mysql:host=localhost;dbname=botcry5_date;charset=utf8', 'botcry5_trader', 'traderb0tz', array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
			
		if (!$con)
		{
			die('Could not connect: ' . mysql_error());
		}

//Action buttons for giving permission to other users access to contact you/
if(isset($_GET['actionbuttons']) && isset($_POST['myid']) && isset($_POST['favid']) && isset($_POST['type'])){
	$my_id = $_POST['myid'];
	//echo "myid:".$my_id."<p></p>";
	$fav_id = $_POST['favid'];
	//echo "fav_id:".$fav_id."<p></p>";
	$type = $_POST['type'];
	//echo "type:".$type."<p></p>";
	
	//We need to match up favs to see if the connection needs to be made/
	$query = $con->prepare("SELECT * FROM favs WHERE fav_id = ? && fav_owner = ? && type >= 1");
	$query->bindValue(1, $my_id, PDO::PARAM_INT);
	$query->bindValue(2, $fav_id, PDO::PARAM_INT);
	$query->execute();
	$count = $query->rowCount();
	
	//This sets new fav if not one already there/
	$query2 = $con->prepare("SELECT * FROM favs WHERE fav_owner = ? && fav_id = ?");
	$query2->bindValue(1, $my_id, PDO::PARAM_INT);
	$query2->bindValue(2, $fav_id, PDO::PARAM_INT);
	$query2->execute();
	$count2 = $query2->rowCount();
	
	if($count == 1){
		$row = $query->fetch(PDO::FETCH_ASSOC);
	}
	
	if($count2 == 1){

		if($count == 1 && $row['type'] == $type && $type != 1){
			$type = $type + 1;
			//echo "newtype:".$type;
			$query3 = $con->prepare("UPDATE favs SET type = ? WHERE fav_id = ? && fav_owner = ?");
			$query3->bindValue(1, $type, PDO::PARAM_INT);
			$query3->bindValue(2, $my_id, PDO::PARAM_INT);
			$query3->bindValue(3, $fav_id, PDO::PARAM_INT);
			$result3 = $query3->execute();
		}
		
		$query4 = $con->prepare("UPDATE favs SET type = ? WHERE fav_owner = ? && fav_id = ?");
		$query4->bindValue(1, $type, PDO::PARAM_INT);
		$query4->bindValue(2, $my_id, PDO::PARAM_INT);
		$query4->bindValue(3, $fav_id, PDO::PARAM_INT);
		$result4 = $query4->execute();
		
		if(!$result4) echo "Fav Failure!<p></p>";
	}else{
		if($count == 1 && $row['type'] == $type && $type != 1){
			$type = $type + 1;
		}
		
		$query4 = $con->prepare("INSERT INTO favs SET fav_owner = ?, fav_id = ?, type = ?");
		$query4->bindValue(1, $my_id, PDO::PARAM_INT);
		$query4->bindValue(2, $fav_id, PDO::PARAM_INT);
		$query4->bindValue(3, $type, PDO::PARAM_INT);
		$result4 = $query4->execute();

		if(!$result4) echo "Fav Failure!<p></p>";
	}
	
	
}

//This allows for the joining of others chat rooms/
if(isset($_GET['chatroom'])){
	//We need to match up favs to see if the connection needs to be made/
	$query = $con->prepare("SELECT * FROM chat_rooms WHERE room_name = ?");
	$query->bindValue(1, $_GET['chatroom'], PDO::PARAM_STR);
	$query->execute();
	$count = $query->rowCount();
	$row = $query->fetch(PDO::FETCH_ASSOC);
	
	if($count == 0){
		die('Chat room does not exist!');
	}elseif($count == 1){
		$query2 = $con->prepare("SELECT * FROM chat WHERE room_id = ?");
		$query2->bindValue(1, $row['id'], PDO::PARAM_STR);
		$query2->execute();
		while($row2 = $query2->fetch(PDO::FETCH_ASSOC)){
			$query3 = $con->prepare("SELECT * FROM users WHERE id = ?");
			$query3->bindValue(1, $row2['sender_id'], PDO::PARAM_STR);
			$query3->execute();
			$row3 = $query3->fetch(PDO::FETCH_ASSOC);
			
			$query4 = $con->prepare("SELECT * FROM images WHERE owner = ? LIMIT 1");
			$query4->bindValue(1, $row3['id'], PDO::PARAM_STR);
			$query4->execute();
			$row4 = $query4->fetch(PDO::FETCH_ASSOC);
			$count4 = $query4->rowCount();
			
			if($count4 == 0){
				$show_profile = 'images/avatar.gif';
			}else{
				$show_profile = 'images/user_images/'.$row3['id'].'/'.$row4['filename'];
			}
			
			echo '<img id="chat-profile-pic" width="50px" src="'.$show_profile.'" />'.$row3['user'].': '.$row2['text']."<p></p>";
		}
	}
}

//This sends the chat/
if(isset($_POST['my_id']) && isset($_POST['to_room']) && isset($_POST['message'])){
	
	$query = $con->prepare("SELECT * FROM chat_rooms WHERE room_name = ?");
	$query->bindValue(1, $_POST['to_room'], PDO::PARAM_INT);
	$query->execute();
	$count = $query->rowCount();
	
	if($count == 1){
	$row = $query->fetch(PDO::FETCH_ASSOC);
	
	$query2 = $con->prepare("INSERT INTO chat SET room_id = ?, sender_id = ?, text = ?");
	$query2->bindValue(1, $row['id'], PDO::PARAM_INT);
	$query2->bindValue(2, $_POST['my_id'], PDO::PARAM_INT);
	$query2->bindValue(3, $_POST['message'], PDO::PARAM_STR);
	$query2->execute();
	}
}


//This updates coordinates for image cropping/
if(isset($_POST['id']) && isset($_POST['x_coords']) && isset($_POST['y_coords']) && isset($_POST['w_coords']) && isset($_POST['h_coords'])){
	$query = $con->prepare("UPDATE images SET x_coords = ?, y_coords = ?, w_coords = ?, h_coords = ? WHERE id = ?");
	$query->bindValue(1, $_POST['x_coords'], PDO::PARAM_INT);
	$query->bindValue(2, $_POST['y_coords'], PDO::PARAM_INT);
	$query->bindValue(3, $_POST['w_coords'], PDO::PARAM_INT);
	$query->bindValue(4, $_POST['h_coords'], PDO::PARAM_INT);
	$query->bindValue(5, $_POST['id'], PDO::PARAM_INT);
	$query->execute();
}
?>
