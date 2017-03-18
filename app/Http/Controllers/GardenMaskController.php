<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Garden;

class GardenMaskController extends Controller
{
    public function __construct(){
    	$this->middleware(['auth','owner']);
    }

    public function mask($id){
    	$garden = Garden::find($id);
    	$garden->owner_masked = true;
    	$garden->save();
    	return redirect()->back();
    }

    public function unmask($id){
    	$garden = Garden::find($id);
    	$garden->owner_masked = false;
    	$garden->save();
    	return redirect()->back();	
    }
}
