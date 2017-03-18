<?php

namespace App\Http\Controllers;

use Auth;
use Hash;
use App\UserRole;
use App\Http\Requests;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        if($req->session()->has('waitingURL')){
            $url = $req->session()->pull('waitingURL');
            $input = $req->session()->pull('waitingInput');
            return redirect($url)->withInput($input);
        }
        $role = UserRole::find(Auth::user()->id);
        $gardens = Auth::user()->ownedGardens;
        $needNewPass = Hash::check( 'Kerden2016',Auth::user()->password );

        return view('home',[
            'message'=>session()->get('message'),
            'error'=>session()->get('error'),
            'role'=>$role->role,
            'gardens'=>$gardens,
            'needNewPass'=>$needNewPass
            ]);
    }
}
