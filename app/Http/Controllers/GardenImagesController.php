<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Garden;

class GardenImagesController extends Controller
{
    //
    public function __construct(){
    	$this->middleware(['auth','owner']);
    }

    public function create($id,Request $req){
    	$garden = Garden::find($id);
    	return view('garden.uploadImages',['garden'=>$garden]);
    }
}
