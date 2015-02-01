<?php

class LoginCtrl extends BaseController {

	public function get_login()
	{
		$view = View::make('index.login');
		return $view;
	}
	
	public function post_login()
	{
		$user = Input::get('user');
		$pass = Input::get('password');
		$row = Users::where('user', '=', $user)->first();
		
		if(Hash::check($pass, $row->password)){
			//$row->touch();
			$new_hash = Str::random(255);
			Users::where('user', '=', $user)->update(array('session_hash' => $new_hash, 'last_ip' => $_SERVER['REMOTE_ADDR']));
			Session::put('MYSESSION', $row->id);
			Session::put('MYHASH', $new_hash);
			return Redirect::route('logged-home');
		}else{
			return Redirect::route('login')
			->with('message', 'Incorrect user name or password!<p></p>'.Input::get('password'));
		}
			
	}

}
