<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Hash;
use Validator;

class ChangePasswordController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    protected function validator(array $data)
    {
    	$params = [
            'old_pass' => 'required',
            'new_pass' => 'required|confirmed'
        ];
        return Validator::make($data, $params);
    }

    public function create(Request $req){
    	return view('auth.passwords.change');
    }

    public function store(Request $req){
    	$validator = $this->validator($req->all());
    	if($validator->fails()){
    		return redirect('/changePassword')->withErrors($validator)->withInput();
    	}

    	$goodOldPass = $req->user()->password;
    	if(Hash::check($req->old_pass, $goodOldPass) ){
    		$req->user()->password = Hash::make($req->new_pass);
    		$req->user()->save();
    		return redirect('/home')->with('message','Mot de passe changé correctement');
    	}
    	else{
    		$error = ['old_pass'=>'Mot de passe incorrect'];
    		return redirect('/changePassword')->withErrors($error)->withInput();
    	}
    }
}
