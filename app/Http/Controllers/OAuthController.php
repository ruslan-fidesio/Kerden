<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use App\UserRole;
use App\ProviderUser;
use Socialite;
use Auth;


class OAuthController extends Controller
{
	public function login($provider, Request $req){
		if($req->has('code')) return $this->execute($provider,$req);
		
		else{
			if(isset($req->redirectTo)){
				$req->session()->put('redirectTo',$req->redirectTo);
			}
			return Socialite::with($provider)->stateless()->scopes(['email'])->redirect();
		}
	}

	public function execute($provider,Request $req){
		$user = Socialite::with($provider)->stateless()->user();
		$userToLog = User::where('email',$user->getEmail())->first();
		if(!empty($userToLog)){
			Auth::loginUsingId($userToLog->id);
		}
		else{
			$this->createProviderUser($provider,$user);
		}

		if($req->session()->has('redirectTo')){
			return redirect( url($req->session()->pull('redirectTo')) );
		}
		elseif( !empty($req->header('referer')) ){
			return redirect($req->header('referer'));
		}
		return redirect()->intended('/home');
	}


	public function createProviderUser($provider,$user){
		$names = explode(" ",$user->getName());
		$newUser = new User();
		$newUser->firstName = $names[0];
		$newUser->lastName = $names[1];
		$newUser->email = $user->getEmail();
		$newUser->save();

		$role = new UserRole();
		$role->id = $newUser->id;
		$role->role = 'confirmed';
		$role->save();

		$providerUser = new ProviderUser();
		$providerUser->user_id = $newUser->id;
		$providerUser->email = $newUser->email;
		$providerUser->provider = $provider;
		$providerUser->save();

		Auth::loginUsingId($newUser->id);
	}
}
