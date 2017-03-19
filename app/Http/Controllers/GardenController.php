<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\Http\Requests;
use Validator;
use App\Garden;
use App\GardenLocation;

class GardenController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth','valid']);
    }

    protected function getValidator(array $data)
    {
    	$params = [
            'title' => 'required|max:255',
            'address' => 'required|max:255',
            'surface' => 'required',
            'max_pers' => 'required',
            'description' => 'required|min:80|max:65000',
            'blur_address'=> 'not_in:FR'
        ];
        return Validator::make($data, $params);
    }

    public function create(Request $req){
        $garden = new Garden();
        
    	return view('garden.create',['name'=>Auth::user()->firstName,'categories'=>Garden::$CATEGORIES,'garden'=>$garden,'menuUnavaible'=>true]);
    }

    public function store(Request $req){
    	$validator = $this->getValidator($req->all());
    	if($validator->fails()){
    		return redirect('/garden/create')->withErrors($validator)->withInput();
    	}
        $req->merge(['title'=>str_replace ( "\s\s", "\s", $req->cat.' '.$req->title)]);

    	$garden = new Garden();
    	$garden->userid = $req->user()->id;
    	$garden->fill($req->all());
    	$garden->state = 'new';
    	$garden->save();

        $gardenLoca = new GardenLocation();
        $gardenLoca->id = $garden->id;
        $gardenLoca->lat = $req->lat;
        $gardenLoca->lng = $req->lng;
        $gardenLoca->save();

    	return redirect('/garden/details/'.$garden->id);
    }

    public function edit($id,Request $req){
        return $this->menu($id, $req);
    }

    public function update($id, Request $req){
        $validator = $this->getValidator($req->all());
        if($validator->fails()){
            return redirect('/garden/update/'.$id)->withErrors($validator)->withInput();
        }
        //$req->title = str_replace ( "\s\s", "\s", $req->cat.' '.$req->title);
        $req->merge(['title'=>str_replace ( "\s\s", "\s", $req->cat.' '.$req->title)]);

        $garden = Garden::find($id);
        $garden->fill($req->all());
        $garden->save();

        $loca = GardenLocation::find($id);
        $loca->lat = $req->lat;
        $loca->lng = $req->lng;
        $loca->save();
        return redirect('/home')->with('message',trans('garden.updateOK'));
    }

    public function menu($id, Request $req){
        $garden = Garden::find($id);
        switch($garden->state){
            case 'new':
                return redirect('/garden/details/'.$id);
                break;
            case 'details_ok':
                return redirect('/garden/prices/'.$id);
                break;
            case 'dispo_ok':
                if (!$garden->staff){
                    return redirect('/garden/staff/'.$id);
                }
                break;
            case 'prices_ok':
                return redirect('/garden/dispo/'.$id);
                break;
            default: 
                break;
        }
        $cat = 'Le jardin';
        foreach (Garden::$CATEGORIES as $key => $value) {
            if($value == 'Le Jardin') continue;
            if(preg_match('/'.$value.'/i', $garden->title)){
                $cat = $value;
                break;
            }
        }
        $name = $garden->title;
        $name = preg_replace('/'.$cat.'/i', '', $name);
        return view('garden.edit',['garden'=>$garden,'categories'=>Garden::$CATEGORIES,'cat'=>$cat,'name'=>$name]);
    }
}
