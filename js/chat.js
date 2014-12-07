console.log("chat.js LOADED");


var grab_chats=setInterval(function () {chat_grabber()}, 10000);

function chat_grabber() {
    var room = $("#join-room").val();
    
    var ajax_local = 'ajax.php?chatroom='+room;
    $.ajax(
        {
            url: ajax_local,
            error: function() {
			alert('chat_grabber ajax error!');
			},
            dataType: "html",
            complete: function(){ 
            },		
            success: function(data) 
            {
				//alert(ajax_local);
				$("#chat-rooms").html(data);
				console.log('grabbing chat rows for room:'+room);
            }
        });
}

function send_message(){
	var id = $("#user-id").val();
	var room = $("#join-room").val();
	var text = $("#send-message").val();
    console.log(id+'.'+room+'.'+text);
    var ajax_local = 'ajax.php';
    $.post(ajax_local,{my_id:id,to_room:room,message:text})
		.done(function(){
			chat_grabber();
			});
    
    $("#send-message").val('');
}


/////////////////////////////////JQUERY
$(document).ready(function() 
{	
	chat_grabber();


	$("#send-message").keyup(function(event){
		if(event.keyCode == 13){
			$("#button-send-message").click();
		}
	});



});
///////////////////////////////////////
