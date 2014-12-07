console.log('user_interactions.js LOADED');

	function open_video(room)
		{
			window.location = 'index.php?logged=yes&page=home&subpage=video&join-room='+room;
		}	
		
	function open_chat(room)
		{
			window.location = 'index.php?logged=yes&page=home&subpage=chat_rooms&chatroom='+room;
		}	
		

	
	function open_message(id, sender_name, receiver_name){
			$("#mail-window").dialog({
				//autoOpen: true,
				bgiframe: true,
				resizable:false,
				height: 550,
				width: 550,
				modal: true,
				title:'Mail'
			
			});
			
			$("#sender-name").text(sender_name);
			$("#receiver-name").text(receiver_name);
	}


