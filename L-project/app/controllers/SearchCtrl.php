<?php

class SearchCtrl extends BaseController {

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
	
	//public $layout = 'layouts.home';

	public function get_search_logged()
	{
		return View::make('logged.index.search')
		->with('title', 'Search Users')
		->with('search', Search::all());
	}
	
	public function get_search_logged_order()
	{
		return View::make('logged.index.search')
		->with('title', 'Search Users')
		->with('search', Search::order_by('user')->get());
	}

}
