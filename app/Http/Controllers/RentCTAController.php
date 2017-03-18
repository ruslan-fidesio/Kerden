<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class RentCTAController extends Controller
{
    

    public function create(Request $req){
        $gardenType = isset($req->cat)?$req->cat:'Jardin';
    	return view('garden.rent',['gardenType'=>$gardenType]);
    }

    public function store(Request $req){
    	if($req->user()){
    		return redirect('/garden/create')->withInput();
    	}else{
            $req->session()->put("waitingURL",'/garden/create');
            $req->session()->put("waitingInput",$req->all());
    		return redirect('/register')->with('error',"Vous devez être inscrit et connecté pour pouvoir continuer.");
    	}
    }
}
