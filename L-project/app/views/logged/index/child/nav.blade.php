@section('nav')
<div ng-controller='NavCtrl' class='row-fluid'>
	<nav style='border:2px solid #cacaca;' class='navbar navbar-default' role='navigation'>
		
		<a style="color:blue;" href="{{ URL::route('logged-home') }}"><button class='btn btn-default' style='margin-top:10px;border:2px solid #cacaca;margin-left:20px;width:100px;' id='home-link'>Home</button></a>
		<a style="color:blue;" href="{{ URL::route('logged-profile') }}"><button class='btn btn-default' style='margin-top:10px;border:2px solid #cacaca;width:100px;' id='profile-link'>Profile</button></a>
		<a style="color:blue;" href="{{ URL::route('logged-search') }}"><button class='btn btn-default' style='margin-top:10px;border:2px solid #cacaca;width:100px;' id='search-link'>Search</button></a>
		<div style='margin-left:275px;margin-top:-43px;'><p style="color:#cacaca;" class="navbar-text"><span style='float:left;color:#cacaca;margin-left:75px;'>Logged in as {{ $user_name }}</span><span style='margin-left:50px;'><i class='fa fa-bitcoin'></i> {{ $btc_balance }}</span><span style='margin-left:75px;'>Wallet Transactions: {{ $btc_txs }}</span><span style='margin-left:30px;'>Total Received: {{ $btc_total_received }}</span><span style='margin-left:30px;'>Total Spent: {{ $btc_total_sent }}</span><span style='margin-left:75px;'><font size='0'>Account Address: {{ $btc_address }}</font></span></p></div>
		<ul class='nav nav-pills' style='float:right;margin-top:3px;'>
			<li role='presentation'>
			<button id='nav-mail' ng-click='nav_mail();' type='button' class='btn btn-default btn-lg' style='float:right;border:2px solid #cacaca;'>
			  <span class='glyphicon glyphicon-envelope' aria-hidden='true'><span style='margin-left:5px;'>({{ $new_mail_count }})</span></span>
			</button>
			</li>
			<li role='presentation'>
			<button id='nav-bitcoin' ng-click='nav_bitcoin();' type='button' class='btn btn-default btn-lg' style='float:right;border:2px solid #cacaca;'>
			  <i class='fa fa-bitcoin'></i>
			</button>
			</li>
			<li role='presentation'>
			<button id='nav-settings' ng-click='nav_settings();' type='button' class='btn btn-default btn-lg' style='float:right;border:2px solid #cacaca;'>
			  <span class='glyphicon glyphicon-cog' aria-hidden='true'></span></span>
			</button>
			</li>
			<li role='presentation'>
			<button id='nav-logout' ng-click='nav_logout();' type='button' class='btn btn-default btn-lg' style='float:right;border:2px solid #cacaca;margin-right:20px'>
			  <span class='glyphicon glyphicon-log-out' aria-hidden='true'></span></span>
			</button>
			</li>
		</ul>
	</nav>
</div>
@stop
<div ng-controller='BitcoinCtrl' id='bitcoin-console' style='display:none;'>
	<div class='col-md-12'>
		<div class='col-md-4'>
			<button ng-click='btc_console_switcher_stats();' class='btn btn-default' style='border:2px solid #cacaca;border-radius:25px;width:250px;' id='my-stats'>Account Stats</button>
		</div>
		<div class='col-md-4'>
			<button ng-click='btc_console_switcher_trans();' class='btn btn-default' style='border:2px solid #cacaca;border-radius:25px;width:250px;' id='my-transactions'>Transactions</button>
		</div>
		<div class='col-md-4'>
		<button ng-click='btc_console_switcher_loans();' class='btn btn-default' style='border:2px solid #cacaca;border-radius:25px;width:250px;' id='requested-loans'>Loans</button>
		</div>
		<!--<button class='btn btn-default' style='border:2px solid #cacaca;border-radius:25px;width:250px;' id='completed-loans'>Completed Loans</button>-->
	</div>
	<div id='account-stats' class='col-md-12'style='border:1px solid #cacaca;margin-top:25px;border-radius:15px;'>
		User name = {{ $user_name }}
		</br>
		<i class='fa fa-bitcoin'></i> {{ $btc_balance }}
		</br>
		Wallet Transactions: {{ $btc_txs }}
		</br>
		Total Received: {{ $btc_total_received }}
		</br>
		Total Spent: {{ $btc_total_sent }}
		</br>
		Account Address: {{ $btc_address }}
	</div>
	<div ng-controller='TransactionsCtrl' id='account-transactions' class='col-md-12'style='border:1px solid #cacaca;margin-top:25px;border-radius:15px;'>
		<div style='border:1px solid #cacaca;border-radius:10px;width:50%;float:left;'>
			<center>Push</center>
			<table class='table table-striped'>
				<tr><th>To User</th><th>Amount</th><th>Status</th></tr>
				<tr ng-repeat='push in pushData'><td>{[{push.to_id}]}</td><td>{[{push.amount / 100000000}]} btc</td>
					<td id='push-buttons'>
						<button id="push-from-comment-button" class="btn btn-{[{push.from_comment}]} btn-small" style="float:right;border:2px solid #cacaca;">
							<i class="fa fa-comments"></i>
						</button>
						<button id="push-to-comment-button" class="btn btn-{[{push.to_comment}]} btn-small" style="float:right;border:2px solid #cacaca;">
							<i class="fa fa-comments"></i>
						</button>
						
						<button id="push-from-rating-button" class="btn btn-{[{push.from_rating}]} btn-small" style="float:right;border:2px solid #cacaca;">
							<i class="fa fa-level-down"></i>
						</button>
						<button id="push-exchange-button" class="btn btn-default btn-small" style="float:right;border:2px solid #cacaca;">
							<i class="fa fa-exchange"></i>
						</button>
						<button id="push-to-rating-button" class="btn btn-{[{push.to_rating}]} btn-small" style="float:right;border:2px solid #cacaca;">
							<i class="fa fa-level-up"></i>
						</button>
						
						<button ng-click='acceptToggle(push.id, "push");' id="push-from-accepted-button-{[{push.id}]}" class="btn btn-{[{push.from_accepted}]} btn-small {[{push.push_accept_disabled}]}" style="float:right;border:2px solid #cacaca;">
							<i class="fa fa-level-down"></i>
						</button>
						<button id="push-to-accepted-button-{[{push.id}]}" class="btn btn-{[{push.to_accepted}]} btn-small disabled" style="float:right;border:2px solid #cacaca;">
							<i class="fa fa-level-up"></i>
						</button>
					</td>
				</tr>
			</table>
		</div>
		<div style='border:1px solid #cacaca;border-radius:10px;width:50%;float:right;'>
			<center>Pull</center>
			<table class='table table-striped'>
				<tr><th>From User</th><th>Amount</th><th>Status</th></tr>
				<tr ng-repeat='pull in pullData'><td>{[{pull.from_id}]}</td><td>{[{pull.amount / 100000000}]} btc</td>
					<td id='pull-buttons'>
						<button id="pull-from-comment-button" class="btn btn-{[{pull.from_comment}]} btn-small" style="float:right;border:2px solid #cacaca;">
							<i class="fa fa-comments"></i>
						</button>
						<button id="pull-to-comment-button" class="btn btn-{[{pull.to_comment}]} btn-small" style="float:right;border:2px solid #cacaca;">
							<i class="fa fa-comments"></i>
						</button>
						
						<button id="pull-from-rating-button" class="btn btn-{[{pull.from_rating}]} btn-small" style="float:right;border:2px solid #cacaca;">
							<i class="fa fa-level-down"></i>
						</button>
						<button id="pull-exchange-button" class="btn btn-default btn-small" style="float:right;border:2px solid #cacaca;">
							<i class="fa fa-exchange"></i>
						</button>
						<button id="pull-to-rating-button" class="btn btn-{[{pull.to_rating}]} btn-small" style="float:right;border:2px solid #cacaca;">
							<i class="fa fa-level-up"></i>
						</button>
						
						<button id="pull-from-accepted-button-{[{pull.id}]}" class="btn btn-{[{pull.from_accepted}]} btn-small disabled" style="float:right;border:2px solid #cacaca;">
							<i class="fa fa-level-down"></i>
						</button>
						<button ng-click='acceptToggle(pull.id, "pull");' id="pull-to-accepted-button-{[{pull.id}]}" class="btn btn-{[{pull.to_accepted}]} btn-small {[{pull.pull_accept_disabled}]}" style="float:right;border:2px solid #cacaca;">
							<i class="fa fa-level-up"></i>
						</button>
					</td>
				</tr>
			</table>
		</div>
	</div>
	<div ng-controller='BitcoinCtrl' id='account-loans' class='col-md-12'style='border:1px solid #cacaca;margin-top:25px;border-radius:15px;'>
		<div class='col-md-10'>
			<div id='request-a-loan'>
				Loan Amount: 
				<input class='form-control' id='loan-amount' type='number' min='0.01' max='10' step='0.01'/>
				</br>
				Interest Acrued Periodically: 
				<input class='form-control' id='loan-interest' type='number' min='0.1' max='50' step='0.1' />
				</br>
				Penalty Interest Per Period: 
				<input class='form-control' id='loan-penalty' type='number' min='0.1' max='50' step='0.1' />
				</br>
				Period Length:
				<select class='form-control' id='loan-period-length'>
				  <option value="day">Daily</option>
				  <option value="week">Weekly</option>
				  <option value="month">Monthly</option>
				  <option value="year">Yearly</option>
				</select>
				Starting:
				<input class='form-control' id='loan-start-date' type="date" min="{{ $todays_date }}">
				</br>
				Number of Periods:
				<input class='form-control' id='loan-period-count' type='number' min='1' max='50' />
				</br>
				Peg to dollar? 
				</br>
				<input name='peg-to-dollar' type='radio' value='1' />Yes<input name='peg-to-dollar' style='margin-left:15px;' type='radio' value='0' />No
				</br>
				<button ng-click='interest_calced();'>Calculate</button>
				</br>
				Total Interest Paid:<span id='interest-totalled'></span>
				</br>
				Total:<span id='the-total'></span>
				</br>
				<span id='display-coinbase-price'></span>
				</br>
				<center><button ng-click='makeLoanRequest();' class='btn btn-default' id='save-settings'>Sumbit Loan Request</button></center>
			</div>
			<div id='open-loans'>
				<table class='table table-striped'>
					<tr>
						<th>User</th><th>Contract</th><th></th>
					</tr>
					<tr ng-repeat='loans in open_loans'>
						<td>{[{loans.user}]}</td><td>{[{loans.amount}]} {[{loans.currency}]} at {[{loans.interest}]}% interest per {[{loans.period}]} for {[{loans.period_count}]} {[{loans.period}]}'s starting {[{loans.starting}]}({[{loans.penalty}]}% penalty for late payments)</td><td><button ng-click='viewLoanDetails(loans.id);' class='btn btn-default'></button></td>
					</tr>
				</table>
			</div>
			<div id='view-loan-details'>
				<div style='float:right;'>
					<table id='append-location' class='table table-striped'>
					</table>
				</div>
				User: {[{loan_details.user}]}
				</br>
				Total: {[{loan_details.amount}]} {[{loan_details.currency}]}
				</br>
				Remaining: {[{loan_details.max_allowed_amount}]} {[{loan_details.currency}]}
				</br>
				Period: {[{loan_details.period}]}
				</br>
				Number of Periods: {[{loan_details.period_count}]}
				</br>
				Interest: {[{loan_details.interest}]}%
				</br>
				Penalty: {[{loan_details.penalty}]}%
				</br>
				Repayment Starting: {[{loan_details.starting}]}
				</br>
				How much of {[{loan_details.amount}]} {[{loan_details.currency}]} would you like to contribute to this loan?
				</br>
				<input id='input-loan-contribution' type='number' step='0.001' max='{[{loan_details.amount}]}' placeholder='max = {[{loan_details.max_allowed_amount}]} {[{loan_details.currency}]}'/><span></span>
				<button ng-click='takeLoan(loan_details.id, loan_details.peg_dollar);'>Fund Loan</button>
			</div>
			<div id='view-loan-details-peg-dollar'>
				<div style='float:right;'>
				</div>
				User: {[{loan_details.user}]}
				</br>
				Total: {[{loan_details.amount}]} {[{loan_details.currency}]}
				</br>
				Coinbase Price of BTC: <span class='display-coinbase-price'>Error</span>
				</br>
				Remaining: {[{loan_details.max_allowed_amount}]} {[{loan_details.currency}]}
				</br>
				Period: {[{loan_details.period}]}
				</br>
				Number of Periods: {[{loan_details.period_count}]}
				</br>
				Interest: {[{loan_details.interest}]}%
				</br>
				Penalty: {[{loan_details.penalty}]}%
				</br>
				Repayment Starting: {[{loan_details.starting}]}
				</br>
				This loan is pegged to the dollar and therefore can only support one lender.  To accept this loan you will need to fund the full amount of {[{loan_details.amount}]} {[{loan_details.currency}]}.
				</br>
				<input id='input-loan-contribution-peg-dollar' type='hidden' value='{[{loan_details.amount}]}'/>
				<button ng-click='takeLoan(loan_details.id, loan_details.peg_dollar);'>Fund Loan</button>
			</div>
			<div id='lending-details'>
				<table class='table table-striped'>
					<tr><th>User</th><th>Amount</th><th>Interest</th><th>Penalty</th><th>Period Length</th><th>Period(s)</th><th>Repayment Starting</th><th>Next Payment</th></tr>
					<tr ng-repeat='lending in lending_stats'>
						<td>{[{lending.user}]}</td><td>{[{lending.amount}]} {[{lending.currency}]}</td><td>{[{lending.loan_interest}]}%</td><td>{[{lending.loan_penalty}]}%</td><td>{[{lending.loan_period}]}</td><td>{[{lending.loan_period_count}]}</td><td>{[{lending.loan_starting}]}</td>
						<td>
							<div id='next-payment-{[{lending.id}]}'></div>
						</td>
					</tr>
				</table>
			</div>
			<div id='borrowing-details'>
				<div class='row-fluid' style='width:100%;'>
					<span style='float:left;width:6%;'>Id</span>
					<span style='float:left;width:17%;'>Amount</span>
					<span style='float:left;width:11%;'>Interest</span>
					<span style='float:left;width:11%;'>Penalty</span>
					<span style='float:left;width:11%;'>Period Length</span>
					<span style='float:left;width:11%;'>Period(s)</span>
					<span style='float:left;width:11%;'>Starting</span>
					<span style='float:left;width:15%;'>Next Payment</span>
				</div><hr>
				<div ng-repeat='borrowing in borrowing_stats'>
					<div ng-click='expandSubLoans(borrowing.id);' style='width:100%;' class='row-fluid'>
						<span style='float:left;width:6%;'>{[{borrowing.id}]}</span>
						<span style='float:left;width:17%;'>{[{borrowing.calced_amount}]} {[{borrowing.currency}]}</span>
						<span style='float:left;width:11%;'>{[{borrowing.interest}]}%</span>
						<span style='float:left;width:11%;'>{[{borrowing.penalty}]}%</span>
						<span style='float:left;width:11%;'>{[{borrowing.period}]}</span>
						<span style='float:left;width:11%;'>{[{borrowing.period_count}]}</span>
						<span style='float:left;width:11%;'>{[{borrowing.starting}]}</span>
						<span id='next-due-{[{borrowing.id}]}' style='float:left;width:11%;'></span>
						<button ng-click='buttonLoanPayment(borrowing.id);' id="request-coin-user" type="button" class="btn btn-default btn-small" style="float:right;border:2px solid #cacaca;"><i class="fa fa-bitcoin"></i><i class="fa fa-level-down"></i></button>
						<hr>		
						<span style='float:left;width:100%;display:none;' class='sub-loans-{[{borrowing.id}]}' ng-repeat='subs in borrowing.sub_loans'>{[{subs.owner_name}]} {[{subs.calced_sub}]} {[{borrowing.currency}]}</span>
						<hr>	
					</div>
				</div>
			</div>
			<div id='take-loan-confirm'>
				User: {[{loan_details.user}]}
				</br>
				Amount: {[{loan_details.amount}]} {[{loan_details.currency}]}
				</br>
				Period: {[{loan_details.period}]}
				</br>
				Number of Periods: {[{loan_details.period_count}]}
				</br>
				Interest: {[{loan_details.interest}]}%
				</br>
				Penalty: {[{loan_details.penalty}]}%
				</br>
				Repayment Starting: {[{loan_details.starting}]}
				</br>
				Your contribution: <span id='loan-confirm-contribution'></span>{[{loan_details.currency}]} <span id='display-calced-btc-amount'></span>
				</br>
				<button ng-click='loanFinalConfirm();' id='loan-final-confirm' class='btn btn-default'>Accept</button>
			</div>
		</div>
		<div class='col-md-2'>
			<button ng-click='btc_console_switcher_request();' class='btn btn-default' style='border:2px solid #cacaca;border-radius:25px;width:150px;float:right' id='make-loan'>Request a loan</button>
			<button ng-click='btc_console_switcher_open();' class='btn btn-default' style='border:2px solid #cacaca;border-radius:25px;width:150px;float:right' id='open-loans'>Open loans</button>
			<button ng-click='btc_console_switcher_lending();' class='btn btn-default' style='border:2px solid #cacaca;border-radius:25px;width:150px;float:right' id='lending'>Lending</button>
			<button ng-click='btc_console_switcher_borrowing();' class='btn btn-default' style='border:2px solid #cacaca;border-radius:25px;width:150px;float:right' id='borrowing'>Borrowing</button>
		</div>
	</div>
</div>
<div ng-controller="NavCtrl" id='settings-window' style='display:none;'>
	<center>Automatically accept mail requests</center>
	<p>
	<center><input type='radio' name='auto-mail' value='1' {{ $radio_mail_yes }} />Yes<input style='margin-left:15px;' type='radio' name='auto-mail' value='0' {{ $radio_mail_no }} />No<center>
	<p>
	<center>Automatically accept chat requests</center>
	<p>
	<center><input type='radio' name='auto-chat' value='1' {{ $radio_chat_yes }} />Yes<input style='margin-left:15px;' type='radio' name='auto-chat' value='0' {{ $radio_chat_no }} />No</center>
	<p>
	<center>Automatically accept video requests</center>
	<p>
	<center><input type='radio' name='auto-video' value='1' {{ $radio_video_yes }} />Yes<input style='margin-left:15px;' type='radio' name='auto-video' value='0' {{ $radio_video_no }} />No</center>
	</br>
	<center><button ng-click='saveSettings();' class='btn btn-default' id='save-settings'>Save</button></center>
</div>
<div ng-controller="NavCtrl" id="display-mail-details" style='display:none;'>
	<table class='table table-striped'>
		<tr>
			<th>From</th><th>Subject</th><th>Sent At</th>
		</tr>
		<tr>
		<td id='mail-read-from'></td><td id='mail-read-subject'></td><td id='mail-read-createdat'></td>
		</tr>
		</tr>
	</table>
	<div id='mail-read-text' style='margin-top:5px;border:1px solid #cacaca;width:100%;hieght:100%;border-radius:5px;'></div>
	<button ng-click='replySnailMail();' style='float:right;'>Reply</button>
</div>
<div ng-controller="NavCtrl" id='receive-mail-window' style='display:none;'>
	<table class='table table-striped'>
		@foreach ($mail_rows as $rows)
		<tr>
			<th>From</th><th>Subject</th><th>Sent At</th>
		</tr>
		<tr>
		<td ng-click="mailDetails({{$rows['id']}});">{{ $rows['from_name'] }}</td><td ng-click="mailDetails({{$rows['id']}});">{{ $rows['subject'] }}</td><td ng-click="mailDetails({{$rows['id']}});">{{ $rows['created_at'] }}</td>
		</tr>
		@endforeach
	</table>
</div>
<input type='hidden' id='send-snail-mail-id' />
<div ng-controller="FavCtrl" id='make-mail-window' style='display:none;'>
	<table class='table table-striped'>
		<tr>
		<td>From: </td><td><span id='from-name-holder'></span></td>
		</tr>
		<tr>
		<td>To: </td><td><span id='to-name-holder'></span></td>
		</tr>
		<tr>
		<td>Subject: </td><td><input type='text' class="form-control" id='subject-holder' /></td>
		</tr>
	</table>
	<textarea class="form-control" cols='70' rows='13' id='message-holder' style='border-radius:10px;'></textarea>
	<button ng-click='sendSnailMail();' style='margin-top:10px;float:right;' id='send-snail-mail' class='btn btn default'>Send</button>
</div>
<div ng-controller='BitcoinCtrl' id='send-btc-modal' style='display:none;'>
	<center>How much would you like to send?</center></br>
	<center><input class='form-control' id='btc-send-input' type='number' placeholder='Amount'/></center>
	<center><button class='btn btn-default' ng-click='finalBitcoinSend();' style='border-radius:10px;margin-top:15px;'>Send</button></center>
</div>
<input type='hidden' id='to-id' />
<input type='hidden' id='to-name' />
<input type='hidden' id='from-name' />
<input type='hidden' id='user-bitcoin-balance' value='{{$btc_balance}}' />
