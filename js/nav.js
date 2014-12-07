console.log('nav.js LOADED');

function nav_logout()
	{
		window.location = 'index.php';
	}
	
function nav_settings()
	{
		$("#settings-window").dialog({
				//autoOpen: true,
				bgiframe: true,
				resizable:true,
				height: 550,
				width: 550,
				modal: true,
				title:'Settings'
			
			});
	}
	
function nav_mail()
	{
		$("#receive-mail-window").dialog({
				//autoOpen: true,
				bgiframe: true,
				resizable:true,
				height: 550,
				width: 550,
				modal: true,
				title:'Mailbox'
			
			});
	}

$(document).ready(function() 
{	
	
});
