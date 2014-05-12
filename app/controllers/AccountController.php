<?php 
class AccountController extends BaseController {
	//Viewing the form
	public function getCreate() {
		return View::make('account.create');
	}

	//Submiting the form
	public function postCreate() {
		
	}
}