<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

//////////////////////////////////////WEBSITE MAIN///////////////////////////////////////////////
Route::get('/', array('as'=>'root', 'uses'=>'HomeController@get_home'));

Route::get('register', array('as'=>'register', 'uses'=>'RegisterCtrl@get_register'));

Route::get('login', array('as'=>'login', 'uses'=>'LoginCtrl@get_login'));

////////////////////////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////FILTERS///////////////////////////////////////////////////////////
Route::filter('escape', function()
{
	$session = Session::get('MYSESSION');
    if (!isset($session))
    {
        return Redirect::to('/');
    }
});
////////////////////////////////////////////////////////////////////////////////////////////////////

//////////////////////////WEBSITE LOGGED////////////////////////////////////////////////////////

Route::get('logged/home', array('before'=>'escape', 'as'=>'logged-home', 'uses'=>'LoggedHomeCtrl@get_home_logged'));

//*******************************SUBPAGES**************************//
Route::get('logged/home/views', array('before'=>'escape', 'as'=>'logged-home-views', 'uses'=>'LoggedHomeCtrl@get_home_views'));
Route::get('logged/home/favs', array('before'=>'escape', 'as'=>'logged-home-favs', 'uses'=>'LoggedHomeCtrl@get_home_favs'));
Route::get('logged/home/chat', array('before'=>'escape', 'as'=>'logged-home-chat', 'uses'=>'LoggedHomeCtrl@get_home_chat'));
Route::get('logged/home/video', array('before'=>'escape', 'as'=>'logged-home-video', 'uses'=>'LoggedHomeCtrl@get_home_video'));
Route::get('logged/home/chat/{room}', array('before'=>'escape', 'as'=>'logged-home-chat-proxy', 'uses'=>'LoggedHomeCtrl@get_home_chat_proxy'));
Route::get('logged/home/video/{room}', array('before'=>'escape', 'as'=>'logged-home-video-proxy', 'uses'=>'LoggedHomeCtrl@get_home_video_proxy'));
//*****************************************************************//

Route::get('logged/profile', array('before'=>'escape', 'as'=>'logged-profile', 'uses'=>'LoggedHomeCtrl@get_home_profile'));

/*****/Route::get('logged/profile/{id}', array('before'=>'escape', 'as'=>'logged-proxy-{id}', 'uses'=>'LoggedHomeCtrl@get_home_profile_proxy'));

/*****/Route::get('logged/crop/{id}', array('before'=>'escape', 'as'=>'logged-crop-{id}', 'uses'=>'LoggedHomeCtrl@get_crop'));

Route::get('logged/search', array('before'=>'escape', 'as'=>'logged-search', 'uses'=>'LoggedHomeCtrl@get_home_search'));

////////////////////////////////////////////////////////////////////////////////////////////////////

//////////////////////////////////////////////////AJAX////////////////////////////////////////////////////
Route::post('logged/ajax/make_favorite', array('before'=>'escape', 'as'=>'ajax-make-favorite', 'uses'=>'AjaxCtrl@make_favorite'));
Route::post('logged/ajax/make_favmail', array('before'=>'escape', 'as'=>'ajax-make-mail', 'uses'=>'AjaxCtrl@make_favmail'));
Route::post('logged/ajax/make_favchat', array('before'=>'escape', 'as'=>'ajax-make-chat', 'uses'=>'AjaxCtrl@make_favchat'));
Route::post('logged/ajax/make_favvideo', array('before'=>'escape', 'as'=>'ajax-make-video', 'uses'=>'AjaxCtrl@make_favvideo'));
Route::post('logged/ajax/crop_image', array('before'=>'escape', 'as'=>'ajax-crop', 'uses'=>'AjaxCtrl@crop_image'));
Route::post('logged/ajax/delete_image', array('before'=>'escape', 'as'=>'ajax-delete-image', 'uses'=>'AjaxCtrl@delete_image'));
Route::post('logged/ajax/send_message', array('before'=>'escape', 'as'=>'ajax-message', 'uses'=>'AjaxCtrl@send_message'));
Route::get('logged/ajax/chat/{id}', array('before'=>'escape', 'as'=>'ajax-chat-{id}', 'uses'=>'AjaxCtrl@get_chat'));
Route::get('logged/ajax/room_info/{id}', array('before'=>'escape', 'as'=>'ajax-room-info-{id}', 'uses'=>'AjaxCtrl@get_room_info'));
Route::get('logged/ajax/rooms/{id}', array('before'=>'escape', 'as'=>'ajax-get-rooms-{id}', 'uses'=>'AjaxCtrl@get_rooms'));
Route::get('logged/ajax/room_logged/{id}', array('before'=>'escape', 'as'=>'ajax-get-logged-{id}', 'uses'=>'AjaxCtrl@get_room_logged'));
Route::get('logged/ajax/check_favs/{id}', array('before'=>'escape', 'as'=>'ajax-check-favs-{id}', 'uses'=>'AjaxCtrl@check_favs'));
Route::post('logged/ajax/loan_details', array('before'=>'escape', 'as'=>'ajax-loan-details', 'uses'=>'AjaxCtrl@get_loan_details'));
Route::post('logged/ajax/send_chat', array('before'=>'escape', 'as'=>'ajax-send-chat', 'uses'=>'AjaxCtrl@send_chat'));
Route::post('logged/ajax/save_settings', array('before'=>'escape', 'as'=>'ajax-save-settings', 'uses'=>'AjaxCtrl@save_settings'));
Route::post('logged/ajax/save_profile_tags', array('before'=>'escape', 'as'=>'ajax-save-profile-tags', 'uses'=>'AjaxCtrl@save_profile_tags'));
Route::post('logged/ajax/loan_request', array('before'=>'escape', 'as'=>'ajax-loan-request', 'uses'=>'AjaxCtrl@loan_request'));
Route::post('logged/ajax/send_bitcoins_users', array('before'=>'escape', 'as'=>'ajax-send-bitcoins-users', 'uses'=>'AjaxCtrl@send_bitcoins_users'));
Route::post('logged/ajax/get_push_transactions', array('before'=>'escape', 'as'=>'ajax-get-push-transactions', 'uses'=>'AjaxCtrl@get_push_transactions'));
Route::post('logged/ajax/get_pull_transactions', array('before'=>'escape', 'as'=>'ajax-get-pull-transactions', 'uses'=>'AjaxCtrl@get_pull_transactions'));
Route::post('logged/ajax/accept_transaction', array('before'=>'escape', 'as'=>'ajax-accept-transaction', 'uses'=>'AjaxCtrl@accept_transaction'));
Route::post('logged/ajax/make_payment', array('before'=>'escape', 'as'=>'ajax-make-payment', 'uses'=>'AjaxCtrl@make_payment'));
Route::post('logged/ajax/loan_final_confirm', array('before'=>'escape', 'as'=>'ajax-loan-final-confirm', 'uses'=>'AjaxCtrl@loan_final_confirm'));
Route::post('logged/ajax/list_open_loans', array('before'=>'escape', 'as'=>'ajax-list-open-loans', 'uses'=>'AjaxCtrl@list_open_loans'));
Route::post('logged/ajax/get_lending_stats', array('before'=>'escape', 'as'=>'ajax-get-lending-stats', 'uses'=>'AjaxCtrl@get_lending_stats'));
Route::post('logged/ajax/get_borrowing_stats', array('before'=>'escape', 'as'=>'ajax-get-borrowing-stats', 'uses'=>'AjaxCtrl@get_borrowing_stats'));
Route::post('logged/ajax/mail_details', array('before'=>'escape', 'as'=>'ajax-mail-details', 'uses'=>'AjaxCtrl@retrieve_mail_details'));
Route::post('logged/ajax/logged_room', array('before'=>'escape', 'as'=>'ajax-mark-logged-room', 'uses'=>'AjaxCtrl@logged_room'));
Route::post('logged/ajax/create_room', array('before'=>'escape', 'as'=>'ajax-create-room', 'uses'=>'AjaxCtrl@create_room'));
Route::post('logged/ajax/check_logged', array('before'=>'escape', 'as'=>'ajax-check-logged', 'uses'=>'AjaxCtrl@check_logged'));
Route::post('logged/ajax/search', array('before'=>'escape', 'as'=>'ajax-make-search', 'uses'=>'AjaxCtrl@make_search'));
/////////////////////////////////////////////////////////////////////////////////////////////////////////

//////////////////////////////////////////////CRONJOB//////////////////////////////////////////////
Route::get('cron/run/98gsdfgsudgf8sdgf98sdujfg98sdf', function () {
	
   Cron::add('check_for_timeout', '* * * * *', function() {
             $users = DB::table('users_schema')
                     //->where('updated_at', '>=', 'CURRENT_TIMESTAMP + INTERVAL 2 MINUTE')
                     ->where('chat_room', '>', 0)
                     ->orWhere('video_room', '>', 0)
                     ->update(array('chat_room'=>0, 'video_room'=>0));
                     
                     return null;
                    });
    $report = Cron::run();
    print_r ($report);
});
///////////////////////////////////////////////////////////////////////////////////////////////

//////////////////////////////////////////POSTS///////////////////////////////////////////////////////
Route::post('register/create', array('uses'=>'RegisterCtrl@post_create'));
Route::post('login/gateway', array('uses'=>'LoginCtrl@post_login'));
Route::post('images/upload', array('uses'=>'ImageCtrl@post_upload_image'));
///////////////////////////////////////////////////////////////////////////////////////////////////////
