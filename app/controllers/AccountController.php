<?php
class AccountController extends BaseController {

	//View Sigin Form
	public function getSignIn() {
		return View::make('account.signin');
	}

	//Sigin Form Submit
	public function postSignIn() {
		//Create a validation for email and password
		$validator = Validator::make(Input::all(),
			array(
				'email'	=> 'required|email',
				'password' => 'required'
			)
		);

		//Check validator
		if ($validator->fails()) {
			//Redirect to the sign in page
			return Redirect::route('account-sign-in')
				->withErrors($validator)
				->withInput();
		} else {
		  //Remember Me
		  $remember = (Input::has('remember')) ? true : false;
		  
			//Attempt user sign in
			$auth = Auth::attempt(array(
				'email' => Input::get('email'),
				'password' => Input::get('password'),
				'active' => 1
			), $remember);

			if ($auth) {
				//Redirect to the intened page
				return Redirect::intended('/');
			} else {
				return Redirect::route('account-sign-in')
					->with('global', 'Email/Password wrong, or account not activated');
			}
		}

		return Redirect::route('account-sign-in')
			->with('global', 'There was a probles signing you in.');
	}

	//Logout
	public function getSignOut() {
		Auth::logout();
		return Redirect::route('home');
	}

	//Viewing the Register form
	public function getCreate() {
		return View::make('account.create');
	}

	//Submiting the form
	public function postCreate() {
		$validator = Validator::make(Input::all(),
			//All the inputs are required :D
			array(
				//Maximun character is 50, must be email, must be unique from users table
				'email' => 'required|max:50|email|unique:users',
				//Maximun character is 20, minimum character is 3, must be unique from users table
				'username' => 'required|max:20|min:3|unique:users',
				//Minimum 8 character
				'password' => 'required|min:8',
				//Must be same with password field
				'password_again' => 'required|same:password'
			)
		);

		if ($validator->fails()) {
				//Send Inputs errors to view
				return Redirect::route('account-create')
						->withErrors($validator)
						->withInput();
			} else {
				//
				$email = Input::get('email');
				$username = Input::get('username');
				$password = Input::get('password');

				// Acitvation code
				$code = str_random(60);

				$user = User::create(array(
					'email' => $email,
					'username' => $username,
					'password' => Hash::make($password),
					'code' => $code,
					'active' => 0
					));

				if ($user) {
					
				//Send email
				//use ($user) is means it's allow to use $user variable
				Mail::send('emails.auth.activate', array('link' => URL::route('account-activate', $code), 'username' => $username), function($message) use ($user) {
					$message->to($user->email, $user->username)->subject('Activate your accout'); //Get Email
				});

				return Redirect::route('home')
					->with('global', 'Your accout has been created! We have sent you and email to activate your account');
			}
		}
	}

	public function getActivate($code) {
		$user = User::where('code', '=', $code)->where('active', '=', 0);

		if ($user->count()) {
			$user = $user->first();

			//Update user to active state
			$user->active = 1;
			$user->code = '';

			//Check it's was really activated or not
			if ($user->save()) {
				//It's was successfull activaed so return success message
				return Redirect::route('home')
					->with('global', 'Activated! You can now sign in!');
			}
		}

		//It's was not really activated so show error message
		return Redirect::route('home')
			->with('global', 'We could not active your account. Try again later.');
	}
	
	//Change Password
	public function getChangePassword(){
	  //Change Password
	  return View::make('account.password');
	}
	
	//Post Change Password
	public function postChangePassword(){
	  //Validate
	  $validator = Validator::make(Input::all(),
  	  array(
  	    'old_password'    => 'required',
  	    'password'        =>  'required|min:8',
  	    'password_again'  =>  'required|same:password'
      )
    );
    
    if($validator->fails()) {
      return Redirect::route('account-change-password')
              ->withErrors($validator);
    } else {
      $user = User::find(Auth::user()->id); //Get Current User From DB
      
      $old_password = Input::get('old_password');
      $password = Input::get('password');
      
      //Check with current user password
      if(Hash::check($old_password, $user->getAuthPassword())) {
        $user->password = Hash::make($password);
        
        if($user->save()){
          return Redirect::route('home')
            ->with('global', 'Your password has been changed');
        }
      } else {
        return Redirect::route('home')
          ->with('global', 'Your old password was incorrect');
      }
    }
    
    return Redirect::route('account-change-password')
      ->with('global', 'Your password could not be change');
	}
	
	public function getForgotPassword() {
	  return View::make('account.forgot');
	}
	
	public function postForgotPassword() {
	  $validator = Validator::make(Input::all(),
  	  array(
  	    'email' => 'required|email'
  	  )
    );
    
    if($validator->fails()) {
      return Redirect::route('account-forgot-password')
        ->withErrors($validator)
        ->withInput();
    } else {
      
      $user = User::where('email', '=', Input::get('email'));
      
      if($user->count()) {
        $user = $user->first();
        
        //Generate a new code and password
        $code = str_random(60);
        $password =str_random(10);
        
        $user->code = $code;
        $user->password_temp = Hash::make($password);
        
        //Save temp_password and code
        if($user->save()){
          
        Mail::send('emails.auth.forgot', array('link' => URL::route('account-recover', $code), 'username' => $user->username, 'password' => $password), function($message) use ($user) {
                $message->to($user->email, $user->username)->subject('Your new password');
              });
          
          return Redirect::route('home')
            ->with('gloabl', 'We have sen you a new password by email');
        }
      }
      
    }
    
    return Redirect::route('account-forgot-password')
      ->with('global', 'Cold not request new password.');
	}
	
	public function getRecover($code) {
	  $user = User::where('code', $code)
	    ->where('password_temp', '!=', '');
	    
	    if($user->count()){
	      $user = $user->first();
	      
	      $user->password       = $user->password_temp;
	      $user->password_temp  = '';
	      $user->code           = '';
	      
	      if($user->save()){
	        return Redirect::route('home')
	          ->with('global', 'Your account has been recoved and you can sign in with your new password.');
	      }
	    }
	    
	    return Redirect::route('home')
	      ->with('global', 'Could not recover your account.');
	}
}