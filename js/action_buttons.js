//$(document).ready(function() 
//{	
	//$('#make-favorite').click(function() {
	
	function make_favorite(fav_id, my_id){
	 // Make your datastring (you can get other values with var a = $('#id').val(); 
	 var dataString = 'favid='+ fav_id + '&myid=' + my_id;

		$.ajax({
		  type: "POST",
		  url: "ajax.php?actionbuttons",
		  data: dataString,
		  cache: false,
		  success: function(data)
		  {
				  alert('it worked!');
		  } 
		//END AJAX/  
		});
	
	}
	//END #SUBMIT FUNCTION/
	//});
//END DOCUMENT READY/	 
//});
