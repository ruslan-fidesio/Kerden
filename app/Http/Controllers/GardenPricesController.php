<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Garden;
use App\GardenPrices;
use App\GardenHour;
use Validator;

class GardenPricesController extends Controller
{
    //
    public function __construct(){
    	$this->middleware(['auth','owner','valid']);
    }

    private function validator($data){
        $params = [
            'prices.*' => 'required'
        ];
        return Validator::make($data, $params);
    }

    public function create($id,Request $req){
    	$garden = Garden::find($id);
        if($garden->state == "new" || $garden->state == "infos_ok" ){
            return redirect('/garden/menu/'.$id)->with('message',trans('garden.details_needed'));
        }
    	return view('garden.prices',['garden'=>$garden,
            'message'=>$req->session()->get('message'),
            'error'=>$req->session()->get('error')]);
    }

    public function store($id, Request $req){
        $validator = $this->validator($req->all());
        if($validator->fails()){
            return redirect('/garden/prices/'.$id)->withErrors($validator)->withInput();
        }
        
        GardenPrices::firstOrNew(['id'=>$id])->fill($req->prices)->save();
        for($k = 1; $k<8; $k++){
            $hour = GardenHour::firstOrNew(['garden_id'=>$id,'day'=>$k])->fill($req->{'hours'.$k});
            $hour->save();
        }

    	//check garden state
    	$garden = Garden::find($id);
    	if($garden->state == "details_ok"){
    		$garden->state = "prices_ok";
    		$garden->save();
            return redirect('/garden/dispo/'.$id);
    	}
    	return redirect('/home')->with('message',trans('garden.details_ok'));
    }
}
