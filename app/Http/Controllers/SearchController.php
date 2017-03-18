<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Garden;
use App\GardenDispo;
use App\Reservation;
use Validator;
use Carbon;
use DB;

class SearchController extends Controller
{
    //

    public function validator($data){
    	$params = [
    		
    	];
    	return Validator::make($data,$params);
    }

    public function search(Request $req){
    	$validator = $this->validator($req->all());
    	if($validator->fails()){
    		return redirect('/')->withErrors($validator)->withInput();
    	}

    	$gardens = $this->findGardens($req->all());
        $params = $req->all();
        if( empty($params['date'])){
            $params['date'] = '';
        }else{
            $carbDate = Carbon\Carbon::parse($params['date']);
            if($carbDate->lt(Carbon\Carbon::now())){
                return redirect('/')->withErrors(['date'=>'pastDate'])->withInput();
            }
        }
        if( empty($params['nb_pers'])) $params['nb_pers'] = '';
        $this->pushSession($params);
        $ware = $this->getWareAsArray();
    	return response()->view('search.results', ['gardens'=>$gardens,'imperfect'=>[],'params'=>$params,'ware'=>$ware,'place'=>$req->place,'categories'=>Garden::$CATEGORIES]);
    }


    private function findGardens($params){
    	//1 : lister les jardins disponibles à la date choisie
        if(!empty($params['date'])){
        	$carbDate = Carbon\Carbon::parse($params['date']);
            $gardens = $this->getValidGardensDispoAt($carbDate);
            if(count($gardens)==0) return 'no_date';
        }else{
            $gardens = [];
            $tmp = Garden::all();
            foreach ($tmp as $key => $value) {
                if($value->state=='validated' && $value->owner_masked==0) array_push($gardens, $value);
            }
        }

        //2: tris
        //blocked owner
        $gardens = array_filter($gardens,array($this,'filterByOwnerStatus'));
        //-nb_pers
        if(!empty($params['nb_pers'])){
            $this->nb_pers = $params['nb_pers'];
            $gardens = array_filter($gardens,array($this,'filterByNbPers'));
        }
        if(count($gardens)==0) return 'no_pers';

        //-activity
        if(!empty($params['activity'])){
            $this->activity = $params['activity'];
            $gardens = array_filter($gardens,array($this,'filterByActivity'));
        }
        if(count($gardens)==0) return 'no_activity';

        //-hours
        if(!empty($params['date']) && !empty($params['slot_begin'])){
            $this->dayOfWeek = Carbon\Carbon::parse($params['date'])->dayOfWeek;
            $this->begin_slot = $params['slot_begin'];
            $this->end_slot = $params['slot_end'];
            $gardens = array_filter($gardens, array($this,'filterByHours'));
        }

        if(count($gardens)==0) return 'no_hours';

        //-ware
        if(!empty($params['ware'])){
            if(is_array($params['ware'])){
                foreach ($params['ware'] as $key => $value) {
                    $this->filterWare = $value;
                    $gardens = array_filter($gardens, array($this,'filterByWare'));
                }
            }
            else{
                $this->filterWare = $params['ware'];
                $gardens = array_filter($gardens, array($this,'filterByWare'));
            }
        }
        if(count($gardens)==0) return 'no_ware';

        //-category
        if(!empty($params['category'])){
            $this->category = strtolower($params['category']);
            $gardens = array_filter($gardens,array($this,'filterByCategory'));
        }
        if(count($gardens)==0) return 'no_category';
        

        return $gardens;
    }

    private function getValidGardensDispoAt($carbDate){
        $validGardens = Garden::where('state','validated')->where('owner_masked',0)->get();
        $list = [];
        $dayOfWeek = $carbDate->dayOfWeek;
        foreach($validGardens as $garden){
            //1 - vérifier qu'une dispo existe
            $test = GardenDispo::where('date',$carbDate->timestamp)->where('garden_id',$garden->id)->whereIn('dispo',['auto','manual'])->count();
            if($test>0){
                // 2 - vérifier le 'no-slot'
                if($garden->getHours($dayOfWeek)->begin_slot != $garden->getHours($dayOfWeek)->end_slot){
                    // 3 - vérifier qu'aucune réservation n'est à la même date
                    $reservations = Reservation::where('garden_id',$garden->id)->get();
                    $add = true;
                    foreach($reservations as $resa){
                        $dateResa = Carbon\Carbon::parse($resa->date_begin);
                        if($dateResa->isSameDay($carbDate)){
                            $add = ! (($resa->status == 'new')||($resa->status == 'confirmed') || ($resa->status == 'waiting_confirm'));
                        }
                    }
                    if($add) array_push($list, $garden);
                }
            }
        }
        return $list;
    }

    private function filterByOwnerStatus($garden){
        return ! $garden->owner->blocked;
    }

    private function filterByNbPers($garden){
        return ($garden->max_pers >= $this->nb_pers);
    }

    private function filterByActivity($garden){
        return $garden->activities->{$this->activity};
    }

    private function filterByHours($garden){
        return ($garden->getHours($this->dayOfWeek)->begin_slot <= $this->begin_slot &&
        $garden->getHours($this->dayOfWeek)->end_slot >= $this->end_slot);
    }

    private function filterByWare($garden){
        return ($garden->gardenWare->where('type',$this->filterWare)->count() > 0);
    }

    private function filterByCategory($garden){
        return (strstr(strtolower($garden->title),$this->category)!=false);
    }
    
    private function pushSession($params){
        foreach ($params as $key => $value) {
            session()->put($key,$value);
        }
    }

    private function getWareAsArray(){
        $ware = DB::table('garden_wares')->select('type')->distinct()->get();
        $res = [];
        foreach($ware as $k=>$v){
            $res[$v->type] = str_replace('_', ' ', $v->type);
        }
        return $res;
    }
}
