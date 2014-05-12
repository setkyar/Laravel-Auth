<?php

class HomeController extends BaseController {

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

	public function home() {

		Mail::send('emails.auth.test', array('name' => 'Laravel Auth'), function($message){
			$message->to('setkyar16@gmail.com', 'Laravel Auth')->subject('Test Email');
		});

		return View::make('home');
	}

}
