<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Garden;
use App\GardenActivity;
use App\GardenKitchen;
use App\GardenMusicLevel;
use App\GardenRequiredStaff;
use App\GardenToilets;
use App\GardenWare;
use App\GardenAnimal;
use App\GardenGuideline;

class GardenDetailsController extends Controller
{
	public function __construct(){
		$this->middleware(['auth','owner','valid']);
	}
    //
    public function create($id, Request $req){
        $garden = Garden::find($id);
        if ($garden->state == 'new') {
            return redirect('/garden/menu/'.$id)->with('message', "Vous devez d'abord remplir ces informations.");
        }
    	return view('garden.details',['garden'=>$garden,
            'activities'=>GardenActivity::firstOrCreate(['id'=>$id]),
            'music_level'=>GardenMusicLevel::firstOrCreate(['id'=>$id]),
            'toilets'=>GardenToilets::firstOrCreate(['id'=>$id]),
            'kitchen'=>GardenKitchen::firstOrCreate(['id'=>$id]),
            'ware'=>GardenWare::where('id',$id)->get(),
            'animal'=>GardenAnimal::firstOrCreate(['garden_id'=>$id]),
            'message'=>$req->session()->get('message'),
            'error'=>$req->session()->get('error')
            ]);
    }

    private function storeActivities($id,Request $req){
    	$activities = GardenActivity::firstOrCreate(['id'=>$id]);
    	foreach($activities->getAttributes() as $arg=>$val){
    		if($arg == 'id') continue;
            $activities->$arg = isset($req->activities[$arg]);
    	}
    	$activities->save();
    }

    private function storeToilets($id,Request $req){
        $toilets = GardenToilets::firstOrCreate(['id'=>$id]);
        $toilets->wc_in = $req->wc_in;
        $toilets->wc_out = $req->wc_out;
        $toilets->save();
    }

    private function storeKitchen($id,Request $req){
        $kitchen = GardenKitchen::firstOrCreate(['id'=>$id]);
        $kitchen->indoor = isset($req->kitchen_indoor);
        $kitchen->indoor_surface = $req->kitchen_indoor_surface;
        $kitchen->outdoor = isset($req->kitchen_outdoor);
        $kitchen->outdoor_surface = $req->kitchen_outdoor_surface;
        $kitchen->save();
    }

    private function storeWare($id, Request $req){
        if( ! isset($req->gardenware) )return;
        //dd($req->all());
        //reset collection
        GardenWare::where('id',$id)->delete();        
        foreach ($req->gardenware as $key => $value) {
            if($value=="")continue;
            if( substr($key,0,3) === 'opt' ){
                $key = $req->$key;
            }
            //set new collection
            $ware  = GardenWare::firstOrNew(['id'=>$id, 'type'=>$key]);
            $ware->nb = $value;
            $ware->save();
        }
    }

    public function store($id, Request $req){
        $garden = Garden::find($id);
        if(empty($req->activities)){
            return redirect('/garden/details/'.$garden->id)->withErrors(['activities'=>'atLeastOne'])->withInput();
        }
        if( isset($req->orchestar) && ( empty($req->music) || $req->music=='none' ) ){
            return redirect('/garden/details/'.$garden->id)->withErrors(['music'=>'illogic'])->withInput();
        }
    	//activities
    	$this->storeActivities($id,$req);
    	//music_level
    	$music_level = GardenMusicLevel::firstOrCreate(['id'=>$id]);
        if(isset($req->music)) {$music_level->level = $req->music;}
        $music_level->orchestar = isset($req->orchestar);
        $music_level->lower_level_asked = isset($req->music_lowerlevel_asked);
        $music_level->lower_level_hour = $req->music_lowerlevel_hour;
        $music_level->lower_level = $req->music_lower_level;
        $music_level->save();
    	//toilets
        $this->storeToilets($id,$req);
    	//kitchen
        $this->storeKitchen($id,$req);
    	//ware
        $this->storeWare($id,$req);
        //animal
        $garden->animal->animals = isset($req->animals);
        $garden->animal->save();
        
        //guidelines
        if(isset($req->newGuidelines)){
            foreach ($req->newGuidelines as $key => $value) {
                $line = new GardenGuideline();
                $line->garden_id = $id;
                $line->message = $value;
                $line->save();
            }
        }

        //remove guidelines
        if(isset($req->removeGuideline)){
            foreach ($req->removeGuideline as $key => $value) {
                $line = GardenGuideline::find($value);
                $line->delete();
            }
        }

        //set the garden state correctly
        if($garden->state == 'infos_ok'){
            $garden->state = 'details_ok';
            $garden->save();
            return redirect('/garden/prices/'.$garden->id);
        }
    	return redirect()->back()->with('message', trans('garden.details_ok'));
    }
}
