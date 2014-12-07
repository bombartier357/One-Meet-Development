console.log('action_buttons.js LOADED');

function make_favorite(fav_id, type){
	var my_id = $('#user-id').val();
	
	console.log('JS firing! FAV-ID' + fav_id + 'MY_ID' + my_id + 'TYPE' + type)
	var dataString = 'favid='+ fav_id + '&myid=' + my_id + '&type=' + type;

	$.ajax({
	  type: "POST",
	  url: "ajax.php?actionbuttons",
	  data: dataString,
	  cache: false,
	  success: function(data)
	  {
		  //alert(data);
		  if(type == 0)
		  {
			 $('#make-favorite'+fav_id).addClass('btn btn-success btn-lg').removeClass('btn btn-default btn-lg'); 
		  }else if(type == 1)
		  {
			 $('#request-message'+fav_id).addClass('btn btn-warning btn-lg').removeClass('btn btn-default btn-lg'); 
		  }
		
	  } 
		//END AJAX/  
	});
	
}

