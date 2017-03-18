<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Garden;
use App\GardenDispo;
use Carbon;
class GardenDispoController extends Controller
{
    //
    public function __construct(){
    	$this->middleware(['auth','owner']);
    }

    public function create($id,Request $req){
    	$garden = Garden::find($id);
    	if($garden->state == "new"){
    		return redirect('/home')->with('message',trans('garden.details_needed'));
    	}
        
    	return view('garden.dispo', ['garden'=>$garden]);
    }

    public function store($id,Request $req){
    	$fdate = Carbon\Carbon::parse($req->fromDate);
    	$tdate = Carbon\Carbon::parse($req->toDate);
    	for($date = $fdate; $date->lte($tdate); $date->addDay()) {
		    $date->hour = 0;$date->minute = 0;$date->second = 0;
		    $dispo = GardenDispo::firstOrNew(['garden_id'=>$id,'date'=>$date->timestamp]);
		    $dispo->dispo = $req->typeDispo;
            if($req->typeDispo == "erase"){
                $dispo->dispo = 'unavaible';
            }
		    $dispo->save();
		}
    	return redirect('/garden/dispo/'.$id);
    }

    public function update($id,Request $req){
        $garden = Garden::find($id);
        if($garden->state == "prices_ok"){
            $garden->state = "dispo_ok";
            $garden->save();
            return redirect('/garden/staff/'.$id);
        }
        return redirect('/home')->with('message',trans('garden.details_ok'));
    }
}
