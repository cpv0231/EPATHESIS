<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use App\Category;
use Validator; 
use Redirect;
use Hash;
use Mail;
use App\User;
use Auth;
class UsersController extends Controller
{
    public function getSignin() {
		return view('users.signin')
		->with('category' , Category::all());
	}
	public function getNewaccount(){
		return view('users.newaccount')
		->with('category' ,Category::all());
	}

	public function postCreate() {
		$validator = Validator::make(Input::all(), User::$rules);

		if ($validator->passes()) {
			$user = new User;
			$user->firstname = Input::get('firstname');
			$user->lastname = Input::get('lastname');
			$user->email = Input::get('email');
			$user->password = Hash::make(Input::get('password'));
			$user->address1 = Input::get('address1');
			$user->address2 = Input::get('address2');
			$user->save();

			/*
			Mail::send('emails/mailers', array('user' => $user) ,function($message){
				$message->to(Input::get('email') , Input::get('name'))->subject('welcome to EPA solution');
			});
			*/

			return Redirect::to('users/signin')
				->with('message', 'Thank you for creating a new account. Please sign in.');
		}

		return Redirect::to('users/newaccount')
			->with('message', 'Something went wrong')
			->withErrors($validator)
			->withInput();
	}

	public function postSignin() {
		if (Auth::attempt(array('email'=>Input::get('email'), 'password'=>Input::get('password')))) {
			return Redirect::to('/')->with('message', 'Thanks for signing in');
		}

		return Redirect::to('users/signin')->with('error', 'Your email/password combo was incorrect');
	}
	public function getSignout() {
		Auth::logout();
		return Redirect::to('users/signin')->with('message', 'You have been signed out');
	}
	
}

