<?php

class sotosholyClass{
	
	private $user_id;
	private $user_hash;
	private $user_email;
	
	public $game_id;

				   
	public function __construct($id){
		
		$this->user_id = $id;
		
		echo "<!DOCTYPE html>
			<html lang='en'><head>
			<meta charset='utf-8'>
			<title>One-Meet</title>
			<meta name='viewport' content='width=device-width, initial-scale=1.0'>
			<meta name='description' content=''>
			<meta name='author' content=''>";
			
		echo "<head>";
		
		echo "<script src='/L-project/public/js/jquery/jquery.min.js'></script>
		<script src='/L-project/public/js/jquery/jquery-ui-1.9.2.custom.js'></script>
		<script type='text/javascript' src='/L-project/public/js/angular.js'></script>
		<link href='/L-project/public/bootstrap/css/bootstrap.css' rel='stylesheet'>
		<link href='/L-project/public/css/jquery-ui-1.9.2.custom.css' rel='stylesheet'>
		<link href='/L-project/public/css/master.css' rel='stylesheet'>
		<link href='/L-project/public/css/jquery.spin.css' rel='stylesheet'>
		<link href='/L-project/public/css/font-awesome-4.3.0/css/font-awesome.min.css' rel='stylesheet'>
		<link href='/L-project/public/packages/sweetalert-master/lib/sweet-alert.css' rel='stylesheet'>";
		
		echo "<style>
		.target-cell:hover{
			background-color:blue;
		}
		</style>";
		
		echo "</head>
			  <body ng-app='sotosholyApp'>";
		
		if(!isset($this->user_id)){
			echo "<center>
					<div ng-controller='LoginCtrl' style='width:500px;margin-top:100px;border:1px solid #cacaca;'>
						<input type='text' id='username-login' placeholder='User' />
						<input type='password' id='username-password' placeholder='Password' />
						<button ng-click='loginUser();' class='btn btn-default'>Login</button>
						<button class='btn btn-info'>Register</button>
					</div>
				</center>";
		}
		
		if(isset($this->user_id)){
			echo "<center>
				<div ng-controller='SotosholyCtrl' style='margin-top:100px;width:700px;height:300px;'>
					<button ng-click='promptCreateGame();' style='float:right;' class='btn btn-success'>Create</button>
					<div style='width:500px;height:300px;border:1px solid #cacaca;''>
						<table class='table table-striped'>
							<tr>Game List</tr>
							<tr><th>Users</th><th>Bounty</th></tr>
							<tr>
								<td>3/4</td>
								<td>.5btc per player</td>
							</tr>
						</table>
					</div>
				</div></center>";
		}
		
		echo "<div ng-controller='SotosholyCtrl' id='new-sotosholy-window' style='display:none;'>
			<input style='width:200px;' type='number' min='0.01' max='5' step='0.01' id='sotosholy-bounty-input' placeholder='Game Bounty' />
			<input style='width:100px;' type='number' min='2' max='4' step='1' id='sotosholy-max-player-input' placeholder='Max Players' />
			<button ng-click='createJoinGame();' class='btn btn-success'>Create Game</button>
		</div>";
		
		if(isset($this->game_id)){
			echo "<div class='grid' style='margin-left:30%;margin-top:100px;height:655px;width:655px;'>
					<div id='a-1' class='target-cell' style='border:1px solid #cacaca;height:100px;width:100px;float:left;'>
						<i style='margin-left:33px;margin-top:25px;' class='fa fa-pause fa-3x'></i><center>HODL!</center>
					</div>
					<div id='a-2' class='target-cell' style='border:1px solid #cacaca;height:100px;width:50px;float:left;'>
					<div style='width:100%;height:20px;background-color:red;margin-top:80px;'></div>
					</div>
					<div id='a-3' class='target-cell' style='border:1px solid #cacaca;height:100px;width:50px;float:left;'>
						<div style='transform: rotate(180deg);'><center><div style='margin-top:20px;'><i class='fa fa-ticket fa-2x'></i></br>Sotoshi</br>Dice</div></center></div>
					</div>
					<div id='a-4' class='target-cell' style='border:1px solid #cacaca;height:100px;width:50px;float:left;'>
						<div style='width:100%;height:20px;background-color:red;margin-top:80px;'></div>
					</div>
					<div id='a-5' class='target-cell' style='border:1px solid #cacaca;height:100px;width:50px;float:left;'>
						<div style='width:100%;height:20px;background-color:red;margin-top:80px;'></div>
					</div>
					<div id='a-6' class='target-cell' style='border:1px solid #cacaca;height:100px;width:50px;float:left;'>
						<div style='transform: rotate(180deg);'><center><div style='margin-top:25px;'><i class='fa fa-signal fa-2x'></i></br>AT&T</div></center></div>
					</div>
					<div id='a-7' class='target-cell' style='border:1px solid #cacaca;height:100px;width:50px;float:left;'>
						<div style='width:100%;height:20px;background-color:yellow;margin-top:80px;'></div>
					</div>
					<div id='a-8' class='target-cell' style='border:1px solid #cacaca;height:100px;width:50px;float:left;'>
						<div style='width:100%;height:20px;background-color:yellow;margin-top:80px;'></div>
					</div>
					<div id='a-9' class='target-cell' style='border:1px solid #cacaca;height:100px;width:50px;float:left;'>
					</div>
					<div id='a-10' class='target-cell' style='border:1px solid #cacaca;height:100px;width:50px;float:left;'>
						<div style='transform: rotate(180deg);'><center><div style='margin-top:35px;'>$35</div></center></div>
						<div style='width:100%;height:20px;background-color:yellow;margin-top:23px;'></div>
					</div>
					<div id='a-11' class='target-cell' style='border:1px solid #cacaca;height:100px;width:100px;float:left;'>
						<center><i style='margin-top:20px;' class='fa fa-legal fa-3x'></i></br>Silk Road Bust</center>
					</div>
					</br>
					<div style='height:450px;width:100px;float:left;'>
						<div id='b-1' class='target-cell' style='height:50px;width:100px;border:1px solid #cacaca;float:left;'>
							<div style='width:20px;height:100%;float:right;background-color:orange;'></div>
							<div style='transform: rotate(90deg);'><center><div style='margin-top:25px;'>$375</div></center></div>
						</div>
						<div id='c-1' class='target-cell' style='height:50px;width:100px;border:1px solid #cacaca;float:left;'>
							<div style='width:20px;height:100%;float:right;background-color:orange;'></div>
							<div style='transform: rotate(90deg);'><center><div style='margin-top:25px;'>$400</div></center></div>
						</div>
						<div id='d-1' class='target-cell' style='height:50px;width:100px;border:1px solid #cacaca;float:left;'>
							<div style='transform: rotate(90deg);'><center><div style='margin-top:-10px;'><i class='fa fa-cubes fa-2x'></i></br>Solved</br>Block</div></center></div>
						</div>
						<div id='e-1' class='target-cell' style='height:50px;width:100px;border:1px solid #cacaca;float:left;'>
							<div style='width:20px;height:100%;float:right;background-color:orange;'></div>
							<div style='transform: rotate(90deg);'><center><div style='margin-top:25px;'>$450</div></center></div>
						</div>
						<div id='f-1' class='target-cell' style='height:50px;width:100px;border:1px solid #cacaca;float:left;'>
							<div style='transform: rotate(90deg);'><center><div style='margin-top:-3px;'><i class='fa fa-signal fa-2x'></i></br>Comcast</div></center></div>
						</div>
						<div id='g-1' class='target-cell' style='height:50px;width:100px;border:1px solid #cacaca;float:left;'>
							<div style='width:20px;height:100%;float:right;background-color:#FA58F4;'></div>
							<div style='transform: rotate(90deg);'><center><div style='margin-top:25px;'>$500</div></center></div>
						</div>
						<div id='h-1' class='target-cell' style='height:50px;width:100px;border:1px solid #cacaca;float:left;'>
							<div style='width:20px;height:100%;float:right;background-color:#FA58F4;'></div>
							<div style='transform: rotate(90deg);'><center><div style='margin-top:25px;'>$600</div></center></div>
						</div>
						<div id='i-1' class='target-cell' style='height:50px;width:100px;border:1px solid #cacaca;float:left;'>
							<div style='transform: rotate(90deg);'><center><div style='margin-top:-10px;'><i class='fa fa-bolt fa-2x'></i></br>GPU</br>Power</div></center></div>
						</div>
						<div id='j-1' class='target-cell' style='height:50px;width:100px;border:1px solid #cacaca;float:left;'>
							<div style='width:20px;height:100%;float:right;background-color:#FA58F4;'></div>
							<div style='transform: rotate(90deg);'><center><div style='margin-top:25px;'>$675</div></center></div>
						</div>
					</div>
					<div style='height:450px;width:450px;border:1px solid #cacaca;float:left;'>
						<i class='fa fa-bank fa-5x'></i>
					</div>
					<div style='height:450px;width:100px;float:left;'>
						<div id='b-2' class='target-cell' style='height:50px;width:100px;border:1px solid #cacaca;float:left;'>
							<div style='width:20px;height:100%;float:left;background-color:green;'></div>
							<div style='transform: rotate(270deg);'><center><div style='margin-top:25px;'>$25.00</div></center></div>
						</div>
						<div id='c-2' class='target-cell' style='height:50px;width:100px;border:1px solid #cacaca;float:left;'>
							<div style='width:20px;height:100%;float:left;background-color:green;'></div>
							<div style='transform: rotate(270deg);'><center><div style='margin-top:25px;'>$17.50</div></center></div>
						</div>
						<div id='d-2' class='target-cell' style='height:50px;width:100px;border:1px solid #cacaca;float:left;'>
							<div style='transform: rotate(270deg);'><center><div style='margin-top:-10px;'><i class='fa fa-cubes fa-2x'></i></br>Solved</br>Block</div></center></div>
						</div>
						<div id='e-2' class='target-cell' style='height:50px;width:100px;border:1px solid #cacaca;float:left;'>
							<div style='width:20px;height:100%;float:left;background-color:green;'></div>
							<div style='transform: rotate(270deg);'><center><div style='margin-top:25px;'>$12.50</div></center></div>
						</div>
						<div id='f-2' class='target-cell' style='height:50px;width:100px;border:1px solid #cacaca;float:left;'>
							<div style='transform: rotate(270deg);'><center><div style='margin-top:-10px;'><i class='fa fa-signal fa-2x'></i></br>Time</br>Warner</div></center></div>
						</div>
						<div id='g-2' class='target-cell' style='height:50px;width:100px;border:1px solid #cacaca;float:left;'>
							<div style='transform: rotate(270deg);'><center><div style='margin-top:-10px;'><i class='fa fa-ticket fa-2x'></i></br>Sotoshi</br>Dice</div></center></div>
						</div>
						<div id='h-2' class='target-cell' style='height:50px;width:100px;border:1px solid #cacaca;float:left;'>
							<div style='width:20px;height:100%;float:left;background-color:blue;'></div>
							<div style='transform: rotate(270deg);'><center><div style='margin-top:25px;'>$5.00</div></center></div>
						</div>
						<div id='i-2' class='target-cell' style='height:50px;width:100px;border:1px solid #cacaca;float:left;'>
							<div>IRS Audit</div>
						</div>
						<div id='j-2' class='target-cell' style='height:50px;width:100px;border:1px solid #cacaca;float:left;'>
							<div style='width:20px;height:100%;float:left;background-color:blue;'></div>
							<div style='transform: rotate(270deg);'><center><div style='margin-top:25px;'>$3.50</div></center></div>
						</div>
					</div>
					<div id='k-1' class='target-cell' style='height:100px;width:100px;border:1px solid #cacaca;float:left;'>
						<img style='float:right;' src='images/Mt-Gox-Logo.png' width='75px'/>
					</div>
					<div id='k-2' class='target-cell' style='height:100px;width:50px;border:1px solid #cacaca;float:left;'>
						<div style='width:100%;height:20px;background-color:#81F7F3;'></div>
						<center><div style='margin-top:25px;'>$750</div></center>
					</div>
					<div id='k-3' class='target-cell' style='height:100px;width:50px;border:1px solid #cacaca;float:left;'>
						<div style='width:100%;height:20px;background-color:#81F7F3;'></div>
						<center><div style='margin-top:25px;'>$850</div></center>
					</div>
					<div id='k-4' class='target-cell' style='height:100px;width:50px;border:1px solid #cacaca;float:left;'>
						<center><div style='margin-top:10px;'><i class='fa fa-ticket fa-2x'></i>Sotoshi Dice</div></center>
					</div>
					<div id='k-5' class='target-cell' style='height:100px;width:50px;border:1px solid #cacaca;float:left;'>
						<div style='width:100%;height:20px;background-color:#81F7F3;'></div>
						<center><div style='margin-top:25px;'>$900</div></center>
					</div>
					<div id='k-6' class='target-cell' style='height:100px;width:50px;border:1px solid #cacaca;float:left;'>
						<center><div style='margin-top:10px;'><i class='fa fa-signal fa-2x'></i>Verizon</div></center>
					</div>
					<div id='k-7' class='target-cell' style='height:100px;width:50px;border:1px solid #cacaca;float:left;'>
						<center><div style='margin-top:10px;'><i class='fa fa-pie-chart fa-2x'></i>Trading Fees</div></center>
					</div>
					<div id='k-8' class='target-cell' style='height:100px;width:50px;border:1px solid #cacaca;float:left;'>
						<div style='width:100%;height:20px;background-color:brown;'></div>
						<center><div style='margin-top:25px;'>$1100</div></center>
					</div>
					<div id='k-9' class='target-cell' style='height:100px;width:50px;border:1px solid #cacaca;float:left;'>
						<center><div style='margin-top:10px;'><i class='fa fa-cubes fa-2x'></i>Solved Block</div></center>
					</div>
					<div id='k-10' class='target-cell' style='height:100px;width:50px;border:1px solid #cacaca;float:left;'>
						<div style='width:100%;height:20px;background-color:brown;'></div>
						<center><div style='margin-top:25px;'>$1200</div></center>
					</div>
					<div id='k-11' class='target-cell' style='height:100px;width:100px;border:1px solid #cacaca;float:left;'>
					GO</br><i class='fa fa-long-arrow-left fa-5x'></i>
					</div>
				</div>";
			}
			
			echo "</body>";
		
		echo "<script type='text/javascript' src='/L-project/public/bootstrap/js/bootstrap.js'></script>
	<script type='text/javascript' src='/L-project/public/js/sotosholyApp.js'></script>
	<script type='text/javascript' src='/L-project/public/js/jquery.spin.js'></script>
	<script type='text/javascript' src='/L-project/public/packages/sweetalert-master/lib/sweet-alert.min.js'></script>";
	}
	

}

?>
