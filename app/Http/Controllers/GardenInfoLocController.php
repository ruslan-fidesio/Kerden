<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Garden;
use App\GardenLocInfo;

class GardenInfoLocController extends Controller
{
    
    public function __construct(){
    	$this->middleware(['auth','owner']);
    }


    public function show($id, Request $req){
    	
    	$garden = Garden::find($id);
    	$infos = GardenLocInfo::where(['garden_id'=>$id])->get();

    	$usephone = $infos->where('type','USEPHONE')->first();
        $guestscansee = $infos->where('type','GUESTSCANSEE')->first();

    	return view('garden.infosLoc',['garden'=>$garden,
         'infos'=>$infos,
         'usephone'=>$usephone,
         'guestscansee'=>$guestscansee,
         'message'=>$req->session()->get('message')]);
    }

    public function store($id, Request $req){
    	$garden = Garden::find($id);

    	if(! $req->has('usephone')){
    		//MISSING USEPHONE INFO => defaut value is false
    		$info = GardenLocInfo::firstOrCreate(['garden_id'=>$garden->id , 'type'=>'USEPHONE']);
    		$info->value = '0';
    		$info->save();
    	}

    	foreach ($req->all() as $key => $value) {
    		if($key == '_token') continue;
    		$info = GardenLocInfo::firstOrCreate(['garden_id'=>$garden->id , 'type'=>$key]);
    		$info->value = $value;
    		$info->save();
    	}
    	return back()->with('message','Les infos ont bien été sauvegardées');
    }
}
