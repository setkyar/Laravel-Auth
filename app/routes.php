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

Route::get('/', array(
	'as' => 'home',
	'uses' => 'HomeController@home'
));

Route::get('/{username}', array(
  'as' => 'profile-user',
  'uses' => 'ProfileController@user'
));

/*
	Unathenticated group
*/
Route::group(array('before' => 'guest'), function(){
	/*
		CSRF protection group
	*/
	Route::group(array('before' => 'csrf'), function() {
		/*
			Create account (POST)
		*/
		Route::post('/account/create', array(
			'as' => 'account-create-post',
			'uses' => 'AccountController@postCreate'
		));

		/*
			Sigin In (POST)
		*/

		Route::post('/account/sign-in', array(
			'as' => 'account-sign-in-post',
			'uses' => 'AccountController@postSignIn'
		));
		
		/*
  	|	Forget password (POST)
  	*/
  	Route::post('/account/forgot-password', array(
  		'as' => 'account-forgot-password-post',
  		'uses' => 'AccountController@postForgotPassword'
  	));
	});
	
	/*
	|	Forget password (GET)
	*/
	Route::get('/account/forgot-password', array(
		'as' => 'account-forgot-password',
		'uses' => 'AccountController@getForgotPassword'
	));
	
	/*
	| Forget password activation link
	*/
	Route::get('/account/recover/{code}', array(
	  'as' => 'account-recover',
	  'uses' => 'AccountController@getRecover'
  ));

	/*
		Sigin In (GET)
	*/

	Route::get('/account/sign-in', array(
		'as' => 'account-sign-in',
		'uses' => 'AccountController@getSignIn'
	));

	/*
		Create account (GET)
	*/
	Route::get('/account/create', array(
		'as' => 'account-create',
		'uses' => 'AccountController@getCreate'
	));

	Route::get('/account/activate/{code}', array(
			'as' =>'account-activate',
			'uses' => 'AccountController@getActivate'
		));
});

/*
| Authernicated group
*/
Route::group(array('before' => 'auth'), function(){
	/*
	| SingOut (GET)
	*/
	Route::get('/account/sign-out', array(
		'as' => 'account-sign-out',
		'uses' => 'AccountController@getSignOut'
	));
	
	/*
	| Change Password (GET)
	*/
	Route::get('/account/change-password', array(
	  'as' => 'account-change-password',
	  'uses' => 'AccountController@getChangePassword'
  ));
	
	/*
	| CSRF protection group
	*/
	Route::group(array('before' => 'csrf'), function(){
	  /*
	  |Change Password (POST)
	  */
  	Route::post('/account/change-password-post', array(
  	  'as' => 'account-change-password-post',
  	  'uses' => 'AccountController@postChangePassword'
    ));
	});
  
});


