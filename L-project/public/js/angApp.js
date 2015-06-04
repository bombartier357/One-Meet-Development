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
		//Change templating sybol for Angular so that Blade and Angular can work together.
		$interpolateProvider.startSymbol('{[{');
		$interpolateProvider.endSymbol('}]}');
	});
	
	///////////////////////////////////////////////////////////////LOGIN CTRL///////////////////////////////////////////////////////////
	app.controller("LoginCtrl", function($scope, $http) {
		/*var my_id = $('#user-id').val();
		
		function loginUser(){
			var user = $("#username-login").val();
			var password = $("#username-password").val();
			
			$http({
				url: '/L-project/public/logged/ajax/post_login',
				method: "POST",
				data: {"user":user, "password":password}
			}).success(function(data, status, headers, config) {
				//$scope.gameList = data;
				//console.log(data);
			}).error(function(data, status, headers, config) {
				console.log(data);
				swal("Something went wrong!", "There was an while logging you in.  If this error persists, please contact the site administrator.", "error");
			});
		}
		
		//Pass function to scope
		$scope.loginUser = function(){
			loginUser();
		}
		*/
	});
	
	/////////////////////////////Sotosholy CTRL////////////////////////////////////////////////////////////////////
	//This controls Sotosholy Game within the application...
	app.controller("SotosholyCtrl", function($scope, $http, $interval) {
		/*
		var my_id = $('#user-id').val();
		$interval(checkTurn, 30000);
		
		//Check game info every 30 secs.
		function checkTurn(){
			var game_id = $("#game-id").val();
			
			$http({
				url: '/L-project/public/logged/ajax/join_game_info',
				method: "POST",
				data: {"my_id":my_id, "game_id":game_id}
			}).success(function(data, status, headers, config) {
				//$scope.gameList = data;
				console.log(data);
			}).error(function(data, status, headers, config) {
				console.log(data);
				swal("Something went wrong!", "There was an while looking up your push transactions.  If this error persists, please contact the site administrator.", "error");
			});
		}
		
		//Creates then joins new game.
		function createJoinGame(){
			var bounty = $("#sotosholy-bounty-input").val();
			var max_players = $("#sotosholy-max-player-input").val();
			
			$http({
				url: '/L-project/public/logged/ajax/create_join_sotosholy',
				method: "POST",
				data: {"id":my_id, "bounty":bounty, "max_players":max_players}
			}).success(function(data, status, headers, config) {
				//$scope.gameList = data;
				console.log(data);
			}).error(function(data, status, headers, config) {
				console.log(data);
				swal("Something went wrong!", "There was an while looking up your push transactions.  If this error persists, please contact the site administrator.", "error");
			});
		}
		
		$scope.createJoinGame = function(){
			createJoinGame();
		}
		
		//Create game dialog modal
		function promptCreateGame(){
			$("#new-sotosholy-window").dialog({
						//autoOpen: true,
						bgiframe: true,
						resizable:true,
						height: 550,
						width: 550,
						modal: true,
						title:'Create New Sotosholy Game'
					});
		}
		
		$scope.promptCreateGame = function(){
			promptCreateGame();
		}
		
		//Returns current game list
		function getGameList(){
			$http({
				url: '/L-project/public/logged/ajax/get_game_list',
				method: "POST",
				data: {"id":my_id}
			}).success(function(data, status, headers, config) {
				$scope.gameList = data;
				console.log(data);
			}).error(function(data, status, headers, config) {
				console.log(data);
				swal("Something went wrong!", "There was an while looking up your push transactions.  If this error persists, please contact the site administrator.", "error");
			});
		}
		
		getGameList();
		
		$scope.getGameList = function(){
			getGameList();
		}
		
		//Joins already created game.
		function joinGame(id){
			$http({
				url: '/L-project/public/logged/ajax/join_game_info',
				method: "POST",
				data: {"game_id":id, "my_id":my_id}
			}).success(function(data, status, headers, config) {
				//$scope.gameInfo = data;
				window.location = '/L-project/public/logged/sotosholy/'+id;
				console.log(data);
			}).error(function(data, status, headers, config) {
				console.log(data);
				swal("Something went wrong!", "There was an while looking up your push transactions.  If this error persists, please contact the site administrator.", "error");
			});
		}
		
		$scope.joinGame = function(id){
			joinGame(id);
		}
		*/
	});
	
	
	///////////////////////////////////////////////////////////////////////////TRANSACTION CTRL///////////////////////////////////////////
	app.controller("TransactionsCtrl", function($scope, $http) {
		/*
		var my_id = $('#user-id').val();
		//Get list of users btc txs.
		get_push_transactions();
		get_pull_transactions();
		
		//Outbound
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
		
		//Inbound
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
		
		//Toggle for accepting txs
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
	*/	
	});
	
	/////////////////////////////////////////////////////////////////////////////MAPS CTRL/////////////////////////////////////
	
	app.controller("MapsCtrl", function($scope, $http) {
		/*
		var geocoder;
		var map;
		var initialized = true;
		
		//Init geo map
		function initialize() {
			  geocoder = new google.maps.Geocoder();
			  var latlng = new google.maps.LatLng(-34.397, 150.644);
			  var mapOptions = {
				zoom: 8,
				center: latlng
			  }
			  map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
			}
			
		//Find lat/lon of address
		function codeAddress(address_var, id) {
		  var address = address_var;
		  geocoder.geocode( { 'address': address}, function(results, status) {
			if (status == google.maps.GeocoderStatus.OK) {
			  map.setCenter(results[0].geometry.location);
			  var marker = new google.maps.Marker({
				  map: map,
				  position: results[0].geometry.location
			  });
			  
			  var lat = parseFloat(results[0].geometry.location['k']);
			  var lon = parseFloat(results[0].geometry.location['D']);
			  console.log(results[0].geometry.location)
			  console.log(lat);
			  $http({
						url: '/L-project/public/logged/ajax/save_coords',
						method: "POST",
						data: {"id":id, "lat":lat, "lon":lon}
					}).success(function(data, status, headers, config) {
						console.log(data);
					}).error(function(data, status, headers, config) {
						console.log(data);
						swal("Something went wrong!", "There was an error in requesting loan information from the server.  If this error persists, please contact the site administrator.", "error");
					});
					
			} else {
			  alert('Geocode was not successful for the following reason: ' + status);
			}
		  });
		}
			
		//Pass map to scope.
		$scope.openMap = function(address_pass, id)
		{
			if(initialize){
				initialize();
				initialize = false;
			}
			
			$http({
						url: '/L-project/public/logged/ajax/get_list_coords',
						method: "POST",
						data: {"id":id}
					}).success(function(data, status, headers, config) {
						if(data.lat != 0 && data.lon != 0){
							var myLatlng = new google.maps.LatLng(data.lat,data.lon);
							map.setCenter(myLatlng);
							
							  var marker = new google.maps.Marker({
								  map: map,
								  position: myLatlng
							  });
						}else{
							codeAddress(address_pass, id);
						}
					}).error(function(data, status, headers, config) {
						console.log(data);
						swal("Something went wrong!", "There was an error in requesting loan information from the server.  If this error persists, please contact the site administrator.", "error");
					});
					
			  //Open map dialog
			  $("#map-canvas").dialog({
					//autoOpen: true,
					bgiframe: true,
					resizable:true,
					height: 800,
					width: 1000,
					modal: true,
					title:'Location'
				
				});
		}
			
		
			
			*/
		});
	
	
	//////////////////////////////////////////////////////////////////////////////DIRECTORY CTRL///////////////////////////////
	app.controller("DirectoryCtrl", function($scope, $http) {
		/*
		var my_id = $('#user-id').val();
		var search_input = $("#search-input").val();
		var page = 1;

		$('#page-down').text($('#page-counter').val());
		
		//Search user directory
		function searchDirectory(){
			page = $("#page-counter").val();
			var specialty = $('#filter-specialty').val();
			var sub_specialty = $('#filter-sub-specialty').val();

			$http({
						url: '/L-project/public/logged/ajax/search_directory',
						method: "POST",
						data: {"string":search_input, 'specialty':specialty, 'sub_specialty':sub_specialty, 'page':page}
					}).success(function(data, status, headers, config) {
						$scope.doctorData = data;	
						$('#page-up').text(parseInt(data.count / 100));
						//console.log(data);
					}).error(function(data, status, headers, config) {
						console.log(data);
						swal("Something went wrong!", "There was an error in requesting loan information from the server.  If this error persists, please contact the site administrator.", "error");
					});
		}
		
		//Pagination
		$('#page-counter').change(function(){
			searchDirectory();
		});
		
		//Pagination-advanced
		$('#filter-specialty').change(function(){
			searchDirectory();
		});
		
		//Pagination-advanced
		$('#filter-sub-specialty').change(function(){
			searchDirectory();
		});
		
		//Pagination-advanced
		$('#filter-phone-type').change(function(){
			searchDirectory();
		});
		
		//Pass pagination to scope.
		$scope.pageChange = function(direction){
			page = $("#page-counter").val();
			console.log(page);
			
			if(direction == 'up'){
				$('#page-counter').val(parseInt(page)+1);
				$('#page-down').text(parseInt(page)+1);
			}else{
				$('#page-counter').val(parseInt(page)-1);
				$('#page-down').text(parseInt(page)-1);
			}
			searchDirectory();
			
		}
		
		$scope.searchDirectory = function(){
			search_input = $("#search-input").val();
			var specialty = $('#filter-specialty').val();
			var sub_specialty = $('#filter-sub-specialty').val();
			$('#page-counter').val(1);
			$('#page-down').text('1');
			console.log(specialty+sub_specialty);
			$http({
					url: '/L-project/public/logged/ajax/search_directory',
					method: "POST",
					data: {"string":search_input, 'specialty':specialty, 'sub_specialty':sub_specialty, 'page':1}
				}).success(function(data, status, headers, config) {
					$scope.doctorData = data;	
					$('#page-up').text(parseInt(data.count/100));
					//console.log(data);
				}).error(function(data, status, headers, config) {
					console.log(data);
					swal("Something went wrong!", "There was an error in requesting loan information from the server.  If this error persists, please contact the site administrator.", "error");
				});
		}
	 */
	});
	/////////////////////////////////////////////////////////////////////////////PROFILE CTRL////////////////////////////////////////////
	
	app.controller("ProfileCtrl", function($scope, $http) {
		var my_id = $('#user-id').val();
		
		//Saves profile tags
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
	
	/////////////////////////////////////////////////////////////////////////////BITCOIN CTRL////////////////////////////////////////////
	app.controller("BitcoinCtrl", function($scope, $http) {
		/*
		//Ctrl variables
		var my_id = $('#user-id').val();
		var coinbase_price = $('#coinbase-price').val();
		var master_loan_data;
		var countdown_interval = {};
		
		//Ctrl display init
		$('#account-stats').show();
		$('#account-loans').hide();
		$('#account-transactions').hide();
		
		$('#request-a-loan').show();
		$('#open-loans').hide();
		$('#view-loan-details').hide();
		$('#view-loan-details-peg-dollar').hide();
		$('#lending-details').hide();
		$('#borrowing-details').hide();
		$('#take-loan-confirm').hide();
		
		//Init functions
		listOpenLoans();
		
		//Add rating to txs
		$scope.voteRating = function(direction, type, id){
			$http({
				url: '/L-project/public/logged/ajax/vote_rating',
				method: "POST",
				data: {"id":my_id, "vote_id":id, "type":type, "direction":direction}
			}).success(function(data, status, headers, config) {
				console.log(data);
			}).error(function(data, status, headers, config) {
				console.log(data);
				swal("Something went wrong!", "There was an error in requesting loan information from the server.  If this error persists, please contact the site administrator.", "error");
			});
		}
		
		//Refreshes the borrowing list
		function update_borrowing_list(){
			$http({
				url: '/L-project/public/logged/ajax/get_borrowing_stats',
				method: "POST",
				data: {"id":my_id}
			}).success(function(data, status, headers, config) {
				//console.log(data);
				$scope.borrowing_stats = data;
				var i;
				var count;
				var data_info = data;
				for(i in data_info){
					if(data_info.hasOwnProperty(i)){
						if(countdown_interval['countdown_interval'+data_info[i].id]){clearInterval(countdown_interval['countdown_interval'+data_info[i].id])};
						var div = 'next-due-'+data_info[i].id;
						addCountDownTimer(data_info[i].next_payment_secs, div, data_info[i].id);
						count++;
					}
				}
			}).error(function(data, status, headers, config) {
				//console.log(data);
				swal("Something went wrong!", "There was an error in requesting loan information from the server.  If this error persists, please contact the site administrator.", "error");
			});
		}
		
		//Expands subloan section
		$scope.expandSubLoans = function(loan_id){
			if(!$('.sub-loans-'+loan_id).is(':visible')){
				$('.sub-loans-'+loan_id).show();
			}else{
				$('.sub-loans-'+loan_id).hide();
			}
		}
		
		//Pass repayment to scope
		$scope.buttonLoanPayment = function(loan_id){
			$http({
					url: '/L-project/public/logged/ajax/loan_details',
					method: "POST",
					data: {"loan_id":loan_id}
				}).success(function(data, status, headers, config) {
					var loan_details = data;
					
					var status = 'On Time';
					var late_multiplier = 0;
					var currentDate = new Date();
					var dateObj = new Date(loan_details.starting);
					
					if(dateObj.getTime() <= currentDate.getTime()){
						var diff = new Date(currentDate.getTime() - dateObj.getTime());
						var time = 0;
					}else{
						var diff = new Date(dateObj.getTime() - currentDate.getTime());
						var time = 1;
					}
					var nextDate = new Date(dateObj);
					var lastDate = new Date(dateObj);
					
					if(loan_details.period == 'day'){
						nextDate.setDate(nextDate.getDate() + 2 + (1 * (loan_details.payments_ontime + loan_details.payments_late)));
						lastDate.setDate(lastDate.getDate() + 2 + (1 * loan_details.period_count));
					}else if(loan_details.period == 'week'){
						nextDate.setDate(nextDate.getDate() + 8 + (7 * (loan_details.payments_ontime + loan_details.payments_late)));
						lastDate.setDate(lastDate.getDate() + 1 + (7 * loan_details.period_count));
					}else if(loan_details.period == 'month'){
						nextDate.setMonth(nextDate.getMonth() + 1 + (1 * (loan_details.payments_ontime + loan_details.payments_late)));
						nextDate.setDate(nextDate.getDate() + 1);
						lastDate.setMonth(lastDate.getMonth() + 1 + (1 * loan_details.period_count));
						lastDate.setDate(lastDate.getDate() + 1);
					}else if(loan_details.period == 'year'){
						nextDate.setYear(nextDate.getFullYear() + 1 + (1 * (loan_details.payments_ontime + loan_details.payments_late)));
						nextDate.setDate(nextDate.getDate() + 1);
						lastDate.setYear(lastDate.getFullYear() + (1 * loan_details.period_count));
						lastDate.setDate(lastDate.getDate() + 1);
					}
					
					if(nextDate.getTime() <= currentDate.getTime()){
						status = 'Late';
						late_multiplier = loan_details.penalty;
					}
					
					var interest = loan_details.interest + late_multiplier + (loan_details.payments_late * loan_details.penalty);
					interest = parseFloat(interest.toPrecision(12));
					var amount = loan_details.amount * interest / 100 + (loan_details.amount / loan_details.period_count);
					var amount2 = parseFloat(amount);
					if(loan_details.peg_dollar == 0){
						var amount3 = amount2.toFixed(8);
					}else{
						var amount3 = amount2.toFixed(2);
					}
					
					//if(time == 0){
						//console.log(diff.getUTCFullYear() - 1970);
						//console.log(diff.getUTCMonth());
						//console.log(diff.getUTCDate() - 1);
					//}else{
						//console.log(diff.getUTCFullYear() - 1970);
						//console.log(diff.getUTCMonth());
						//console.log(diff.getUTCDate() + 1);
					//}
					
					//console.log(nextDate);
					swal({title:"Make loan payment?", text:("Are you sure you would like to make a payment now?  This will be irriversible. \n\nAmount : "+amount3+" "+loan_details.currency+" \nOriginal Amount : "+loan_details.amount+" "+loan_details.currency+" \nInterest : "+interest+"% \nTotal Completed Payments : "+loan_details.payments_ontime+" \nTotal Late Payments : "+loan_details.payments_late+" \nPayments Remaining : "+(loan_details.period_count - (loan_details.payments_ontime + loan_details.payments_late))+" \nPayment Status : "+status+" \n\nNext Payment Due : \n"+nextDate+" \n\nScheduled Last Payment : \n"+lastDate), type:"warning", showCancelButton: true, confirmButtonText: "Yes, make payment.", closeOnConfirm: false, closeOnCancel: true}, function(){
						setTimeout(function(){
							$http({
								url: '/L-project/public/logged/ajax/make_payment',
								method: "POST",
								data: {"id":my_id, 'loan_id':loan_id}
							}).success(function(data, status, headers, config) {
								console.log(data);
								swal("Payment Made!", "You have successully made a payment.", "success");
								update_borrowing_list()
							}).error(function(data, status, headers, config) {
								console.log(data);
								swal("Something went wrong!", "There was an error in making your payment.  If this error persists, please contact the site administrator.", "error");
							});
						}, 500);
					});
				}).error(function(data, status, headers, config) {
					console.log(data);
					swal("Something went wrong!", "There was an error in requesting loan information from the server.  If this error persists, please contact the site administrator.", "error");
				});
		}
		
		//Pass making new loan to scope
		$scope.makeLoanRequest = function()
		{
			var confirm_act = confirm('Are you sure you would like to make this loan request?  If it is filled this will irriversible.');
			if(confirm_act){
			var loan_amount = $('#loan-amount').val();
			var interest = $('#loan-interest').val();
			var penalty = $('#loan-penalty').val();
			var period_length = $('#loan-period-length').val();
			var start_date = $('#loan-start-date').val();
			var period_count = $('#loan-period-count').val();
			var peg_dollar = $('input:radio[name=peg-to-dollar]:checked').val();
			
			
			$http({
					url: '/L-project/public/logged/ajax/loan_request',
					method: "POST",
					data: {"id":my_id, 'loan_amount':loan_amount, 'interest':interest, 'penalty': penalty, 'period_length':period_length, 'start_date':start_date, 'period_count':period_count, 'peg_dollar':peg_dollar}
				}).success(function(data, status, headers, config) {
					//console.log(data);
					swal("Loan Listed!", "You have successully listed your loan.", "success");
				}).error(function(data, status, headers, config) {
					//console.log(data);
					swal("Something went wrong!", "There was an error in requesting loan information from the server.  If this error persists, please contact the site administrator.", "error");
				});
			}
		}
		
		//Pass loan details to scope
		$scope.viewLoanDetails = function(loan_id){
			$('#open-loans').hide();
			$('#lending-details').hide();
			$('#borrowing-details').hide();
			
			$http({
					url: '/L-project/public/logged/ajax/loan_details',
					method: "POST",
					data: {"loan_id":loan_id}
				}).success(function(data, status, headers, config) {
					$scope.loan_details = data;
					master_loan_data = data;
					
					if(master_loan_data.peg_dollar == 0){
						$('#view-loan-details').show();
						var html = '<tr><th>User</th><th>Amount</th><th>Date</th></tr>';
						for (var i = 0; i < data.subs_loan_count; i++){
							html += '<tr><td>'+data.subs_loan_array[i].sub_owner_user+'</td><td>'+(data.subs_loan_array[i].sub_owner_amount / 100000000)+'</td><td>'+data.subs_loan_array[i].sub_owner_createdat.date.substring(0,19)+'</td></tr>';
						}
						$('#append-location').html(html);
					}else{
						$('#view-loan-details-peg-dollar').show();
						$('.display-coinbase-price').text('$'+coinbase_price);
					}
		
				}).error(function(data, status, headers, config) {
					console.log(data);
					swal("Something went wrong!", "There was an error in requesting loan information from the server.  If this error persists, please contact the site administrator.", "error");
				});
		}
		
		//Take on a requested loan passed to scope
		$scope.takeLoan = function(loan_id, peg_dollar){
			if(peg_dollar == 0){
				var loan_contribution = $('#input-loan-contribution').val();	
			}else{
				var loan_contribution = $('#input-loan-contribution-peg-dollar').val();
				var calc = (loan_contribution / $('#coinbase-price').val());
				var btc_calced = calc.toFixed(8);
				$('#display-calced-btc-amount').text('or '+btc_calced+' btc @ $'+coinbase_price);
			}
			
			$('#loan-confirm-contribution').text(loan_contribution);
				$("#take-loan-confirm").dialog({
						//autoOpen: true,
						bgiframe: true,
						resizable:true,
						height: 550,
						width: 550,
						modal: true,
						title:'Loan Funding Overview'
					});
		}
		
		//Review everything before confirming to scope
		$scope.loanFinalConfirm = function(){
			var loan_id = master_loan_data.id;
			var currency = master_loan_data.peg_dollar;
			
			var loan_contribution;
			var currency_val;
			var peg_price;
			if(currency == 1){
				loan_contribution = $('#input-loan-contribution-peg-dollar').val();
				currency_val = 'usd';
				loan_contribution = loan_contribution * 100;
			}else{
				loan_contribution = $('#input-loan-contribution').val();
				loan_contribution = loan_contribution * 100000000;
				currency_val = 'btc';
			}

			$http({
					url: '/L-project/public/logged/ajax/loan_final_confirm',
					method: "POST",
					data: {"loan_id":loan_id, 'owner':my_id, 'amount':loan_contribution, 'currency':currency, 'my_id':my_id}
				}).success(function(data, status, headers, config) {
					swal('Loan Funded!',('You have funded '+loan_contribution+' '+currency_val+' of '+master_loan_data.amount+' '+currency_val+'.'), 'success');
					$("#take-loan-confirm").dialog('close');
					$('#open-loans').show();
					$('#lending-details').hide();
					$('#borrowing-details').hide();
					$('#view-loan-details').hide();
					$('#view-loan-details-peg-dollar').hide();
					listOpenLoans();
					//alert('You have successully listed your loan.');
				}).error(function(data, status, headers, config) {
					//console.log(data);
					swal("Something went wrong!", "There was an error in requesting loan information from the server.  If this error persists, please contact the site administrator.", "error");
				});
		}
		
		//List open loans and pass to scope
		$scope.listOpenLoans = function()
		{
			
			$http({
					url: '/L-project/public/logged/ajax/list_open_loans',
					method: "POST",
					data: {"id":my_id}
				}).success(function(data, status, headers, config) {
					//console.log(data);
					$scope.open_loans = data;
				}).error(function(data, status, headers, config) {
					//console.log(data);
					swal("Something went wrong!", "There was an error in requesting loan information from the server.  If this error persists, please contact the site administrator.", "error");
				});
		}
		
		//Just list the loans
		function listOpenLoans()
		{
			
			$http({
					url: '/L-project/public/logged/ajax/list_open_loans',
					method: "POST",
					data: {"id":my_id}
				}).success(function(data, status, headers, config) {
					//console.log(data);
					$scope.open_loans = data;
				}).error(function(data, status, headers, config) {
					//console.log(data);
					swal("Something went wrong!", "There was an error in requesting loan information from the server.  If this error persists, please contact the site administrator.", "error");
				});
		}
		
		//Navigation
		$scope.btc_console_switcher_open = function()
		{
			$('#request-a-loan').hide();
			$('#open-loans').show();
			$('#view-loan-details').hide();
			$('#view-loan-details-peg-dollar').hide();
			$('#lending-details').hide();
			$('#borrowing-details').hide();
			listOpenLoans();
		}
		
		//Navigation
		$scope.btc_console_switcher_lending = function()
		{
			$('#request-a-loan').hide();
			$('#open-loans').hide();
			$('#view-loan-details').hide();
			$('#view-loan-details-peg-dollar').hide();
			$('#lending-details').show();
			$('#borrowing-details').hide();
			
			$http({
					url: '/L-project/public/logged/ajax/get_lending_stats',
					method: "POST",
					data: {"id":my_id}
				}).success(function(data, status, headers, config) {
					//console.log(data);
					$scope.lending_stats = data;
					var i;
					var count;
					var data_info = data;
					for(i in data_info){
						if(data_info.hasOwnProperty(i)){
							var div = 'next-payment-'+data_info[i].id;
							addCountDownTimer(data_info[i].next_payment_secs, div, data_info[i].id);
							count++;
						}
					}
				}).error(function(data, status, headers, config) {
					//console.log(data);
					//alert('Something went wrong.');
				});
		}
		
		//Build countdown timer
		function addCountDownTimer(time, div, id){
			var total_seconds = time,
			display = $('#'+div),
			years, weeks, days, hours, mins, seconds, lateText;
			var holder = 0;
			countdown_interval['countdown_interval' + id] = setInterval(function() {
				years = parseInt(Math.abs(total_seconds) / 31449600);
				years = (years < 10) ? "0" + years : years;
				weeks = parseInt((Math.abs(total_seconds) % 31449600) / 604800);
				weeks = (weeks < 10) ? "0" + weeks : weeks;
				days = parseInt((Math.abs(total_seconds) % 604800) / 86400);
				days = (days < 10) ? "0" + days : days;
				hours = parseInt((Math.abs(total_seconds) % 86400) / 3600);
				hours = (hours < 10) ? "0" + hours : hours;
				mins = parseInt((Math.abs(total_seconds) % 3600) / 60)
				mins = (mins < 10) ? "0" + mins : mins;
				seconds = parseInt(Math.abs(total_seconds) % 60);
				seconds = (seconds < 10) ? "0" + seconds : seconds;
						
				if (total_seconds <= 0 || holder == 1) {
					total_seconds = Math.abs(total_seconds);
					total_seconds++;
					holder = 1;
					lateText = 'LATE';
				}else if(holder == 0){
					total_seconds--;
					lateText = '';
				}
						
				$('#'+div).text(years + ":" + weeks + ":" + days + ":" + hours + ":" + mins + ":" + seconds+" "+lateText);

						
			}, 1000);
		}
		
		//Navigation
		$scope.btc_console_switcher_borrowing = function()
		{
			$('#request-a-loan').hide();
			$('#open-loans').hide();
			$('#view-loan-details').hide();
			$('#view-loan-details-peg-dollar').hide();
			$('#lending-details').hide();
			$('#borrowing-details').show();
			
			update_borrowing_list();
		}
		
		//Navigation
		$scope.btc_console_switcher_request = function()
		{
			$('#request-a-loan').show();
			$('#open-loans').hide();
			$('#view-loan-details').hide();
			$('#view-loan-details-peg-dollar').hide();
			$('#lending-details').hide();
			$('#borrowing-details').hide();
		}
		
		//Navigation
		$scope.btc_console_switcher_trans = function()
		{
			$('#account-stats').hide();
			$('#account-loans').hide();
			$('#account-transactions').show();
		}
		
		//Navigation
		$scope.btc_console_switcher_stats = function()
		{
			$('#account-stats').show();
			$('#account-loans').hide();
			$('#account-transactions').hide();
		}
		
		//Navigation
		$scope.btc_console_switcher_loans = function()
		{
			$('#account-stats').hide();
			$('#account-loans').show();
			$('#account-transactions').hide();
		}
		
		//Calculate interest and pass to scope
		$scope.interest_calced = function()
		{
			var loan_amount = $('#loan-amount').val();
			var interest = $('#loan-interest').val();
			var multiplier = $('#loan-period-count').val();
			var peg_dollar = $('input:radio[name=peg-to-dollar]:checked').val();
			
			var total_interest = interest * multiplier;
			var cut_decimal = Math.floor(total_interest * 1000) / 1000;

			var total_amount = Math.floor(((total_interest / 100 + 1) * loan_amount) * 100000000) / 100000000; 
			
			$('#interest-totalled').text(cut_decimal);
			$('#interest-totalled').append('%');
			$('#the-total').text(total_amount);
			
			if(peg_dollar == 1){
				$('#display-coinbase-price').text('Coinbase BTC Price: $'+$('#coinbase-price').val());
			}else{
				$('#display-coinbase-price').text('');
			}
		}
		
		//Send bitcoin function to scope.
		$scope.finalBitcoinSend = function(){
			var proxy_id = $('#viewing-profile-proxy-id').val();
			var send_amount = $('#btc-send-input').val();
			if(send_amount == '' || send_amount < .002){
				$('#btc-send-input').focus(function(){ $('#btc-send-input').val(0.0021); });
				swal('You must enter a real amount!','The amount of bitcoins you would like to send is invalid.  Please use an amount greater than 0.002 bitcoins to send.', 'error');
				return;
			}
			var user_bitcoin_balance = $('#user-bitcoin-balance').val();
			if(send_amount <= user_bitcoin_balance){
				swal({   title: "Are you sure?",   text: ("Are you sure you would like to send "+send_amount+" btc to this user?  This will be irriversible if this user accepts your transaction."),   type: "warning",   showCancelButton: true,   confirmButtonColor: "#DD6B55",   confirmButtonText: "Yes, send btc!",   closeOnConfirm: false }, 
				function(){   
					$http({
						url: '/L-project/public/logged/ajax/send_bitcoins_users',
						method: "POST",
						data: {"id":my_id, "send_to":proxy_id, "amount":send_amount}
					}).success(function(data, status, headers, config) {
						swal("Sent!", "Your bitcoins have been sent successfully.", "success"); $('#btc-send-input').val(''); 
					}).error(function(data, status, headers, config) {
						//console.log(data);
					});
				});
			}else{
				swal("Insufficient bitcoins!", "You do not have enough bitcoins to complete this transaction.  Add more bitcoins to your account and try again.", "error");
			}
		}
		*/
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
		
		
		//Get favorite user info
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
		
		//Pass make snail mail dialog to scope
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
		
		//Send the snail mail function to scope
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
		
		//Navigation
		$scope.joinChatRoom = function(room_id){
			var room = $("#join-room").val(room_id);
			var user_id = $('#user-id').val();
			if(room != user_id){
				window.location = '/L-project/public/logged/home/chat/'+room_id;
			}
		}
		
		//Navigation
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
