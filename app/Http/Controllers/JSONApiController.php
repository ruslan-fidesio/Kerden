<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Garden;
use Carbon;
use DB;


class JSONApiController extends Controller
{
    public function gardenHours(Request $req){
    	if($req->has('date') && $req->has('gardenId')){
    		$garden = Garden::findOrFail($req->gardenId);
    		$carbDate = Carbon\Carbon::parse($req->date);
    		if($carbDate->isPast()){
    			return response()->json(['state'=>'no','message'=>'Date passée']);
    		}else{
    			//check dispo
    			if($garden->dispos->where('date',$carbDate->timestamp)->whereIn('dispo',['auto','manual'])->count() ==0){
    				return response()->json(['state'=>'no','message'=>'Indisponible']);
    			}
    			//check reservations
                foreach($garden->reservations as $resa){
                    $resaDate = Carbon\Carbon::parse($resa->date_begin);
                    if($resaDate->isSameDay($carbDate)){
                        if( $resa->status == 'confirmed' ||
                            $resa->status == 'waiting_confirm' ||
                            $resa->status == 'waiting_payin' ||
                            $resa->status == 'new' ){
                            
                            return response()->json(['state'=>'no','message'=>'Indisponible']);
                        }
                    }
                }

    			//check hours
    			$hours = $garden->getHours($carbDate->dayOfWeek);
    			if($hours->begin_slot == $hours->end_slot){
    				return response()->json(['state'=>'no','message'=>'Indisponible']);
    			}

    			//return hours
    			return response()->json(['state'=>'yes','begin_slot'=>$hours->begin_slot, 'end_slot'=>$hours->end_slot]);
    		}
    	}
    	else abort(404);
    }

//http://kerden.dev/jsonAPI/calcPrice?gardenId=2&date=&begin_slot=9&end_slot=12&staffDay=true&staffNight=true&nb_guests=30
    public function calcPrice(Request $req){
        if( empty($req->gardenId) || empty($req->date) || empty($req->begin_slot) ||
            empty($req->end_slot) || !isset($req->staffDay) || !isset($req->staffNight) || empty($req->nb_guests) ){
            abort(400);
        }

        $garden = Garden::findOrFail($req->gardenId);
        $carbDate = Carbon\Carbon::parse($req->date);
        $basePrice = ($carbDate->dayOfWeek == 5 || $carbDate->isWeekEnd() )? $garden->prices->weekEnd : $garden->prices->weekDay ;
        $nightPrice = $basePrice + ceil($basePrice/5);

        if( $req->end_slot > 18 ){
            $nbHoursDay = max(0, 18 - $req->begin_slot );
            $nbHoursNight = $req->begin_slot>18? $req->end_slot-$req->begin_slot : max(0, $req->end_slot - 18);
        }
        else{
            $nbHoursDay = $req->end_slot - $req->begin_slot;
            $nbHoursNight = 0;
        }

        $totalHoursPrice = ($nbHoursDay * $basePrice) + ( $nbHoursNight * $nightPrice );

        $nbStaff = ceil($req->nb_guests / 30);
        $totalStaffHours = 0;
        $totalStaffPrice = 0;

        if($req->staffDay == 1){
            $totalStaffHours += $nbHoursDay;
        }
        if($req->staffNight == 1){
            $totalStaffHours += $nbHoursNight;
        }
        if($totalStaffHours > 0) $totalStaffHours = max($totalStaffHours,2);

        $totalStaffPrice = $totalStaffHours * $nbStaff * env('OSCAR_HOUR_PRICE');

        return response()->json([
            'totalHoursPrice' => $totalHoursPrice,
            'totalStaffPrice' => $totalStaffPrice,
            'totalPrice' => $totalHoursPrice + $totalStaffPrice
            ]);
        

    }
}
