<?php

class RegisterCtrl extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/
	

	public function get_register()
	{
		$view = View::make('index.register');
		return $view;
	}
	
	public function post_create()
	{
		/*$rules = array(
		'user'=>'required|min:10'
		);
		
		$validation = Validator::make(Input::all(), $rules);
		
		if($validation->fails()){
			return Redirect::route('root')
			->with_errors($validation);
		}else{*/
			Users::create(array(
				'user'=>Input::get('user'),
				'email'=>Input::get('email'),
				'sex'=>Input::get('sex'),
				'password'=>Hash::make(Input::get('password'))
			));
			
			return Redirect::route('root')
			->with('message', 'Account has been created!<p></p>'.Input::get('sex')."<p></p>".Input::get('password'));
		//}
	}

}
