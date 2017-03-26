<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Garden;
use App\GardenRequiredStaff;

class GardenStaffController extends Controller
{
    public function __construct(){
    	$this->middleware(['auth','owner','valid']);
    }

    public function create($id, Request $req){
    	$garden = Garden::find($id);
        if ($garden->state != 'dispo_ok' && $garden->state != 'validated') {
            return redirect('/garden/menu/'.$id)->with('message',trans('garden.details_needed'));
        }
    	return view('garden.staff',['garden'=>$garden]);
    }

    public function store($id, Request $req){
    	$staff = GardenRequiredStaff::firstOrNew(['id'=>$id]);
    	
    	$staff->requiredStaff = isset($req->requiredStaff) ? 1 : 0 ; 
    	$staff->requiredStaffNight = isset($req->requiredStaffNight) ? 1 : 0 ; 
        $staff->restrictedKitchenAccess = isset($req->restrictedKitchenAccess)? 1 : 0;

    	$staff->save();
    	return redirect('/home')->with('message',trans('garden.details_ok'));
    }
}
