<?php

class ImageCtrl extends BaseController {

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

	public function post_upload_image()
	{
		$file = Input::file('upload_image');
		$id = Input::get('upload_id');
		
		$extension = Input::file('upload_image')->getClientOriginalExtension();
		$filename = str_random(200).".".$extension;
		$destinationPath = 'images/user_images/'.$id;
		
		$upload_success = $file->move($destinationPath, $filename);
		list($width, $height, $type, $attr) = getimagesize($destinationPath."/".$filename);
		
		Images::create(array(
			'owner'=>$id,
			'filename'=>$filename,
			'init_height'=>$height,
			'init_width'=>$width
		));

		if( $upload_success ) {
		   return Response::json('success', 200);
		} else {
		   return Response::json('error', 400);
		}
		return Redirect::route('logged-profile')
			->with('message', 'Image has been added to the reel!<p></p>');
	}

}
