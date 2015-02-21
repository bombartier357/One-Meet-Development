console.log('angApp.js loaded!');

//Begin document
(function(){
	
	setTimeout(function(){
		$('.spin').spin('hide');
		$('.spin').css('display', 'none');
		$('#chat-box').show();
		$('#fav-list').show();
	}, 1500);

	//ANGULAR//////////////////////////////////////////////////////////
	var app = angular.module('angApp', [])
	app.config(function($interpolateProvider) {
		$interpolateProvider.startSymbol('{[{');
		$interpolateProvider.endSymbol('}]}');
	});
	
	///////////////////////////////////////////////////////////////////////////TRANSACTION CTRL///////////////////////////////////////////
	app.controller("TransactionsCtrl", function($scope, $http) {
		var my_id = $('#user-id').val();
		get_push_transactions();
		get_pull_transactions();
		
		function get_push_transactions(){
			$http({
				url: '/L-project/public/logged/ajax/get_push_transactions',
				method: "POST",
				data: {"id":my_id}
			}).success(function(data, status, headers, config) {
				$scope.pushData = data;
				//console.log(data);
			}).error(function(data, status, headers, config) {
				//console.log(data);
				swal("Something went wrong!", "There was an while looking up your push transactions.  If this error persists, please contact the site administrator.", "error");
			});
		}
		
		function get_pull_transactions(){
			$http({
				url: '/L-project/public/logged/ajax/get_pull_transactions',
				method: "POST",
				data: {"id":my_id}
			}).success(function(data, status, headers, config) {
				$scope.pullData = data;
				//console.log(data[0]);
			}).error(function(data, status, headers, config) {
				//console.log(data);
				swal("Something went wrong!", "There was an while looking up your pull transactions.  If this error persists, please contact the site administrator.", "error");
			});
		}
		
		$scope.acceptToggle = function(tx_id, type){
			var my_id = $('#user-id').val();
			$http({
				url: '/L-project/public/logged/ajax/accept_transaction',
				method: "POST",
				data: {"id":my_id, "tx_id":tx_id, "type":type}
			}).success(function(data, status, headers, config) {
				//$scope.pullData = data;
				console.log(data);
				if(data.from_accepted == 0 && data.to_accepted == 0){
					swal({title:"Reject this transaction?", text:"Are you sure you would like to reject this transaction?  This action is irriversible.", type:"warning", showCancelButton: true, confirmButtonText: "Yes, cancel transaction.", cancelButtonText:"Go back."}, function(){
							setTimeout(function(){
								swal("Transaction rejected!", "This transaction has been rejected.", "error");
								$('#pull-to-accepted-button-'+data.id).attr('class', 'btn btn-danger btn-small');
								$('#pull-from-accepted-button-'+data.id).attr('class', 'btn btn-danger btn-small');
								$('#push-to-accepted-button-'+data.id).attr('class', 'btn btn-danger btn-small');
								$('#push-from-accepted-button-'+data.id).attr('class', 'btn btn-danger btn-small');
								},500);
						});
				}else if(data.from_accepted == 1 && data.to_accepted == 1){
					swal({title:"Accept this transaction?", text:"Are you sure you would like to accept this transaction?  Once accepted, the funds will be transferred between users.  This will be irriversible.", type:"warning", showCancelButton: true, confirmButtonText: "Yes, accept transaction.", cancelButtonText:"Go back."}, function(){
							swal("Transaction accepted!", "This transaction has been accepted.", "success");
							$('#pull-to-accepted-button-'+data.id).attr('class', 'btn btn-info btn-small');
							$('#pull-from-accepted-button-'+data.id).attr('class', 'btn btn-info btn-small');
							$('#push-to-accepted-button-'+data.id).attr('class', 'btn btn-info btn-small');
							$('#push-from-accepted-button-'+data.id).attr('class', 'btn btn-info btn-small');
						});
				}else if(data.from_accepted == 0 && data.to_accepted == 1){
					$('#pull-to-accepted-button-'+data.id).attr('class', 'btn btn-success btn-small');
					$('#pull-from-accepted-button-'+data.id).attr('class', 'btn btn-default btn-small');
					$('#push-to-accepted-button-'+data.id).attr('class', 'btn btn-success btn-small');
					$('#push-from-accepted-button-'+data.id).attr('class', 'btn btn-default btn-small');
				}else if(data.from_accepted == 1 && data.to_accepted == 0){
					$('#pull-to-accepted-button-'+data.id).attr('class', 'btn btn-default btn-small');
					$('#pull-from-accepted-button-'+data.id).attr('class', 'btn btn-success btn-small');
					$('#push-to-accepted-button-'+data.id).attr('class', 'btn btn-default btn-small');
					$('#push-from-accepted-button-'+data.id).attr('class', 'btn btn-success btn-small');
				}
			}).error(function(data, status, headers, config) {
				//console.log(data);
				swal("Something went wrong!", "There was an while accepting this push transactions.  If this error persists, please contact the site administrator.", "error");
			});
		}
		
	});
	
	
	/////////////////////////////////////////////////////////////////////////////PROFILE CTRL////////////////////////////////////////////
	
	app.controller("ProfileCtrl", function($scope, $http) {
		var my_id = $('#user-id').val();
		
		$scope.saveProfileTags = function()
		{
			var iam1 = $('#iam1').val();
			var iam2 = $('#iam2').val();
			var iam3 = $('#iam3').val();
			var iam4 = $('#iam4').val();
			var iam5 = $('#iam5').val();
			
			var lookingfor1 = $('#lookingfor1').val();
			var lookingfor2 = $('#lookingfor2').val();
			var lookingfor3 = $('#lookingfor3').val();
			var lookingfor4 = $('#lookingfor4').val();
			var lookingfor5 = $('#lookingfor5').val();
			
			var canprovide1 = $('#canprovide1').val();
			var canprovide2 = $('#canprovide2').val();
			var canprovide3 = $('#canprovide3').val();
			var canprovide4 = $('#canprovide4').val();
			var canprovide5 = $('#canprovide5').val();
			
			var near1 = $('#near1').val();
			var near2 = $('#near2').val();
			var near3 = $('#near3').val();
			var near4 = $('#near4').val();
			var near5 = $('#near5').val();
			
			$http({
					url: '/L-project/public/logged/ajax/save_profile_tags',
					method: "POST",
					data: {"id":my_id, 'iam1':iam1, 'iam2':iam2, 'iam3':iam3, 'iam4':iam4, 'iam5':iam5, 'lookingfor1':lookingfor1, 'lookingfor2':lookingfor2, 'lookingfor3':lookingfor3, 'lookingfor4':lookingfor4, 'lookingfor5':lookingfor5, 'canprovide1':canprovide1, 'canprovide2':canprovide2, 'canprovide3':canprovide3, 'canprovide4':canprovide4, 'canprovide5':canprovide5, 'near1':near1, 'near2':near2, 'near3':near3, 'near4':near4, 'near5':near5}
				}).success(function(data, status, headers, config) {
					//console.log(data);
					swal("Tags saved!", "Your profile tags have been updated.", "success");
				}).error(function(data, status, headers, config) {
					//console.log(data);
					swal("Something went wrong!", "There was an while saving your tags.  If this error persists, please contact the site administrator.", "error");
				});
		}
	});
	
	
	
	///////////////////////////////////////////////////////////////////////////////NAVCTRL///////////////////////////////////////////////////////////
	app.controller("NavCtrl", function($scope, $http, $interval) {
		$interval(check_logged, 300000);
		
		function check_logged()
		{
			var my_id = $('#user-id').val();
			//console.log('check_logged');
			$http({
					url: '/L-project/public/logged/ajax/check_logged',
					method: "POST",
					data: {"id":my_id}
				}).success(function(data, status, headers, config) {

				}).error(function(data, status, headers, config) {
					//console.log(data);
				});
		}
		
		$scope.nav_settings = function()
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
		
		$scope.nav_logout = function()
		{
			window.location = '/L-project/public/';
		}
		
		$scope.nav_mail = function()
		{
			$("#receive-mail-window").dialog({
					//autoOpen: true,
					bgiframe: true,
					resizable:true,
					height: 'auto',
					width: 550,
					modal: true,
					title:'Mailbox'
				
				});
		}
		
		$scope.nav_bitcoin = function()
		{
			$("#bitcoin-console").dialog({
					//autoOpen: true,
					bgiframe: true,
					resizable:true,
					height: 800,
					width: 1200,
					modal: true,
					title:'Bitcoin Console'
				
				});
		}
		
		$scope.mailDetails = function(mail_id) {
			
			$http({
					url: '/L-project/public/logged/ajax/mail_details',
					method: "POST",
					data: {"mail_id":mail_id}
				}).success(function(data, status, headers, config) {
					
					//Reply variables...
					$('#to-id').val(data.sender_id);
					$('#to-name').val(data.from);
					$('#from-name').val(data.to);
					$('#from-name-holder').text(data.to);
					$('#to-name-holder').text(data.from);
					//Display pre mail details
					$('#mail-read-from').text(data.from);
					$('#mail-read-subject').text(data.subject);
					$('#mail-read-createdat').text(data.createdat.date);
					$('#mail-read-text').text(data.text);
					$("#display-mail-details").dialog({
						//autoOpen: true,
						bgiframe: true,
						resizable:true,
						height: 'auto',
						width: 550,
						modal: true,
						title:'Mail Details'
					
					});
					//alert('searched');
				}).error(function(data, status, headers, config) {
					//$scope.status = status;
				});
		}
		
		$scope.saveSettings = function() {
			var my_id = $('#user-id').val();
			var auto_mail = $('input:radio[name=auto-mail]:checked').val();
			if(!auto_mail){
				auto_mail = 0;
			}
			var auto_chat = $('input:radio[name=auto-chat]:checked').val();
			if(!auto_chat){
				auto_chat = 0;
			}
			var auto_video = $('input:radio[name=auto-video]:checked').val();
			if(!auto_video){
				auto_video = 0;
			}

			$http({
					url: '/L-project/public/logged/ajax/save_settings',
					method: "POST",
					data: {"user_id":my_id, 'auto_mail':auto_mail, 'auto_chat':auto_chat, 'auto_video':auto_video}
				}).success(function(data, status, headers, config) {
					swal("Settings Saved!", "Your user settings have been saved.", "success");
					$("#settings-window").dialog('close');
				}).error(function(data, status, headers, config) {
					//$scope.status = status;
					swal("Something went wrong!", "There was an error while saving your settings.  If this error persists, please contact the site administrator.", "error");
				});
		}
		
		$scope.replySnailMail = function() {
			
			$("#make-mail-window").dialog({
				//autoOpen: true,
				bgiframe: true,
				resizable:true,
				height: 'auto',
				width: 550,
				modal: true,
				title:'Make Mail',
				close: function(event, ui){$('#to-id').val('');$('#to-name').val('');$('#from-name').val('');$('#from-name-holder').text('');$('#to-name-holder').text('');}
			
			});
			
		}
		
		
	//END NAV FNCT
	});
	
	///////////////////////////////////////////////////////////////////////////////////////FAVCTRL//////////////////////////////////////////////////////////////////////////////
	app.controller("FavCtrl", function($scope, $http, $interval) {
		retrieveFavInfo();
		$interval(retrieveFavInfo, 10000);
		
		
		
		function retrieveFavInfo() {
			var id = $("#user-id").val();
			$http.get('/L-project/public/logged/ajax/check_favs/'+id).
			success(function(data) {
			  $scope.fav_info = data;
			  //console.log($scope.data);
			}).
			error(function(data) {
			  // log error
			});
		}
		
		$scope.makeSnailMail = function(to_id, from_name, to_name){
			$('#to-id').val(to_id);
			$('#to-name').val(to_name);
			$('#from-name').val(from_name);
			$('#from-name-holder').text(from_name);
			$('#to-name-holder').text(to_name);
			
			$("#make-mail-window").dialog({
				//autoOpen: true,
				bgiframe: true,
				resizable:true,
				height: 'auto',
				width: 550,
				modal: true,
				title:'Make Mail',
				close: function(event, ui){$('#to-id').val('');$('#to-name').val('');$('#from-name').val('');}
			
			});
			
		}
		
		$scope.sendSnailMail = function(){
			var my_id = $('#user-id').val();
			var to_id = $('#to-id').val();
			var subject = $('#subject-holder').val();
			var message = $('textarea#message-holder').val();
			//console.log(my_id+to_id+subject+message);
			
			$http({
					url: '/L-project/public/logged/ajax/send_message',
					method: "POST",
					data: {"sender_id":my_id, "to_id":to_id, 'subject':subject, "message":message}
				}).success(function(data, status, headers, config) {
					swal("Mail Sent!", "Your message has been delivered to the user\' inbox", "success");
					$("#make-mail-window").dialog("close");
				}).error(function(data, status, headers, config) {
					//$scope.status = status;
					swal("Something went wrong!", "There was an error while sending the mail.  If this error persists, please contact the site administrator.", "error");
				});
		}
		
		$scope.joinChatRoom = function(room_id){
			var room = $("#join-room").val(room_id);
			var user_id = $('#user-id').val();
			if(room != user_id){
				window.location = '/L-project/public/logged/home/chat/'+room_id;
			}
		}
		
		$scope.open_video = function(room_id){
			var room = $("#join-room").val(room_id);
			var user_id = $('#user-id').val();
			if(room != user_id){
				window.location = '/L-project/public/logged/home/video/'+room_id;
			}
		}
	});
	
	//////////////////////////////////////////////////////////////////////////////////////////CHATCTRL//////////////////////////////////////////////
	app.controller("ChatCtrl", function($scope, $http, $interval) {
		retrieveChatRows();
		retrieveRoomsList();
		retrieveRoomInfo();
		retrieveRoomLogged();
		$interval(retrieveRoomLogged, 3000);
		$interval(retrieveRoomInfo, 3000);
		$interval(retrieveChatRows, 3000);
		$interval(retrieveRoomsList, 15000);
		$('#room-display').hide();
		$("#create-chat-room").hide();
		
		//AJAX GRAB CURRENT ROOM INFO
		function retrieveRoomInfo() {
			var room_id = $("#join-room").val();
			$http.get('/L-project/public/logged/ajax/room_info/'+room_id).
			success(function(data) {
			  $scope.room_info = data;
			  //console.log($scope.data);
			}).
			error(function(data) {
			  // log error
			});
		}
		
		//AJAX GRAB CURRENTLY LOGGED USERS IN ROOM
		function retrieveRoomLogged() {
			var room_id = $("#join-room").val();
			$http.get('/L-project/public/logged/ajax/room_logged/'+room_id).
			success(function(data) {
			  $scope.logged_users = data;
			  //console.log($scope.logged_users);
			}).
			error(function(data) {
			  // log error
			});
		}
		
		//AJAX GRAB CHAT ROWS
		function retrieveChatRows() {
			var room = $("#join-room").val();
			$http.get('/L-project/public/logged/ajax/chat/'+room).
			success(function(data) {
			  $scope.data = data;
			  //console.log($scope.data);
			}).
			error(function(data) {
			  // log error
			});
		}
		
		//AJAX GRAB ROOMS
		function retrieveRoomsList() {
			var chat_room = $("#join-room").val();
			var my_id = $('#user-id').val();
			$http.get('/L-project/public/logged/ajax/rooms/'+chat_room).
			success(function(data) {
			  $scope.rooms = data;
			  $http.post('/L-project/public/logged/ajax/logged_room', {id:my_id, room:chat_room});
			}).
			error(function(data) {
			  // log error
			});
		}
		
		$scope.createRoom = function(){
			var room_name = $("#create-room-name").val();
			var access = $("input:radio[name=room-access]:checked").val();
			var owner = $('#user-id').val();
			
			$http({
					url: '/L-project/public/logged/ajax/create_room',
					method: "POST",
					data: {"room_name":room_name, "access":access, "owner":owner}
				}).success(function(data, status, headers, config) {
					//$scope.data = data;
					swal("Your chat room has been created!", "Your chat room has been successfully created.  We are redirecting you now.", "success");
					window.location = '/L-project/public/logged/home/chat/'+data;
				}).error(function(data, status, headers, config) {
					//$scope.status = status;
					swal("Something went wrong!", "There was an error when creating the room.  If this error persists, please contact the site administrator.", "error");
				});
		}
		
		$scope.joinChatRoom = function(room_id){
			var room = $("#join-room").val(room_id);
			var user_id = $('#user-id').val();
			if(room != user_id){
				window.location = '/L-project/public/logged/home/chat/'+room_id;
			}
		}
		
		$scope.nav_to_rooms = function(){
			$('#room-display').show();
			$('#chat-box').hide();
		}
		
		$scope.nav_to_home_chat = function(){
			$('#room-display').hide();
			$('#chat-box').show();
		}
		
		$scope.chatCreateRoom = function(){
			$("#create-chat-room").dialog({
					//autoOpen: true,
					bgiframe: true,
					resizable:true,
					height: 300,
					width: 300,
					modal: true,
					title:'Create Chat Room'
				
				});
		}
		
		$scope.makeMessage = function() {
			var id = $("#user-id").val();
			var room = $("#join-room").val();
			var text = $("#send-message").val();
			
			$http({
					url: '/L-project/public/logged/ajax/send_chat',
					method: "POST",
					data: {"my_id":id, "to_room":room, "message":text}
				}).success(function(data, status, headers, config) {
					$("#send-message").val('');
					retrieveChatRows();
					//$scope.data = data;
				}).error(function(data, status, headers, config) {
					//$scope.status = status;
					swal("Something went wrong!", "There was an error while sending your message.  If this error persists, please contact the site administrator.", "error");
				});
		};
		
		
	//END MSG FNCT
	});
	
	app.controller("SearchCtrl", function($scope, $http) {
		//$interval(retrieveFavInfo, 3000);
		
		$scope.confirm_send_btc = function(proxy_id)
		{
			$("#send-btc-modal").dialog({
					//autoOpen: true,
					bgiframe: true,
					resizable:false,
					height: 200,
					width: 400,
					modal: true,
					title:'Send Bitcoin'
				
				});
			$('#viewing-profile-proxy-id').val(proxy_id);
		}
		
		$scope.makeSearch = function() {
			var search_string = $("#search-input").val();
			var my_id = $("#user-id").val();
			
			$http({
					url: '/L-project/public/logged/ajax/search',
					method: "POST",
					data: {"search_string":search_string, 'my_id':my_id}
				}).success(function(data, status, headers, config) {
					//$("#send-message").val('');
					$scope.search_data = data;
					$('.init-search-rows').hide();
					//alert('searched');
				}).error(function(data, status, headers, config) {
					//$scope.status = status;
					swal("Something went wrong!", "There was an error while searching for users.  If this error persists, please contact the site administrator.", "error");
				});
		};
		
		$scope.make_favorite = function(fav_id, type){
			var my_id = $('#user-id').val();
			
			$http({
					url: '/L-project/public/logged/ajax/make_favorite',
					method: "POST",
					data: {"favid":fav_id, 'myid':my_id, 'type':type}
				}).success(function(data, status, headers, config) {
					$scope.fav_data = data;
					//console.log(data);
					  if(type == 1)
					  {
						 $('#make-favorite'+fav_id).addClass('btn btn-success btn-lg').removeClass('btn btn-default btn-lg'); 
					  }
				}).error(function(data, status, headers, config) {
					//$scope.status = status;
					console.log(data);
					swal("Something went wrong!", "There was an error while adding this user to your favorites.  If this error persists, please contact the site administrator.", "error");
				});
	
		}
		
		$scope.make_favmail = function(fav_id, type){
			var my_id = $('#user-id').val();
		
			$http({
						url: '/L-project/public/logged/ajax/make_favmail',
						method: "POST",
						data: {"favid":fav_id, 'myid':my_id, 'type':type}
					}).success(function(data, status, headers, config) {
						$scope.mail_data = data;
						//console.log(data);
						  if(type == 1)
						  {
							 $('#make-message'+fav_id).addClass('btn btn-warning btn-lg').removeClass('btn btn-default btn-lg'); 
						  }
					}).error(function(data, status, headers, config) {
						//$scope.status = status;
						swal("Something went wrong!", "There was an error while requesting mail permissions for this user.  If this error persists, please contact the site administrator.", "error");
					});
		}
		
		$scope.make_favchat = function(fav_id, type){
			var my_id = $('#user-id').val();
			
			$http({
						url: '/L-project/public/logged/ajax/make_favchat',
						method: "POST",
						data: {"favid":fav_id, 'myid':my_id, 'type':type}
					}).success(function(data, status, headers, config) {
						$scope.chat_data = data;
						//console.log(data);
						  if(type == 1)
						  {
							 $('#make-chat'+fav_id).addClass('btn btn-warning btn-lg').removeClass('btn btn-default btn-lg'); 
						  }
					}).error(function(data, status, headers, config) {
						//$scope.status = status;
						swal("Something went wrong!", "There was an error while requesting chat permissions for this user.  If this error persists, please contact the site administrator.", "error");
					});
			
		}
		
		$scope.make_favvideo = function(fav_id, type){
			var my_id = $('#user-id').val();
			
			$http({
						url: '/L-project/public/logged/ajax/make_favvideo',
						method: "POST",
						data: {"favid":fav_id, 'myid':my_id, 'type':type}
					}).success(function(data, status, headers, config) {
						$scope.chat_data = data;
						//console.log(data);
						  if(type == 1)
						  {
							 $('#make-video'+fav_id).addClass('btn btn-warning btn-lg').removeClass('btn btn-default btn-lg'); 
						  }
					}).error(function(data, status, headers, config) {
						//$scope.status = status;
						swal("Something went wrong!", "There was an error while requesting video permissions for this user.  If this error persists, please contact the site administrator.", "error");
					});
			
		}
		
		$scope.nav_profile = function(id)
		{
			window.location = '/L-project/public/logged/profile/'+id;
		}
		
		
	//END SRC FNCT
	});

	app.controller("VideoCtrl", function($scope, $http, $interval) {
		$interval(checkNewUsers, 3000);
		checkNewUsers();
		
		//This modifies the video window depending on how many users are in video chat...
		function checkNewUsers(){
			var i = -1;
			var pixels;
			
			$('video').each(function(){
				i++;
				
				if(i % 4 == 0){
					$('video').append($("p"));
				}
			 });
			 
			pixels = 100 / i;
			
			$('video').css('width', pixels+'%');
			$('video').css('max-height', '600px');
		}
		
		
	//END VID FNCT
	});
//END DKRD
})();
