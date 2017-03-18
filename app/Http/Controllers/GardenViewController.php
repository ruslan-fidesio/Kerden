<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Garden;
use App\GardenDispo;
use App\Reservation;
use Carbon;

class GardenViewController extends Controller
{
	public function __construct(){
    	$this->middleware(['visible']);
    }
    //
    public function show($id,Request $req){
        $garden = Garden::find($id);
        $staticImgUrl = "https://maps.googleapis.com/maps/api/staticmap?center=".$garden->location->lat.','.$garden->location->lng."&zoom=15&size=600x300&maptype=roadmap&key=AIzaSyDMppXmks4XyF8XMe3_roFbVumAlThb_CY&path=color:0x000000ff|fillcolor:0x33FF2288|weight:1";

        $pi = pi();
        
        $Lat = ($garden->location->lat * $pi) / 180;
        $Lng = ($garden->location->lng * $pi) / 180;
        
        $d=0.1/6371;

        for ($i = 0; $i < 360; $i=$i+2){
    		$brng = $i * $pi / 180;

			$pLat = asin(sin($Lat)*cos($d) + cos($Lat)*sin($d)*cos($brng));
			$pLng = (($Lng + atan2(sin($brng)*sin($d)*cos($Lat), cos($d)-sin($Lat)*sin($pLat))) * 180) / $pi;
			$pLat = ($pLat * 180) /$pi;

			$staticImgUrl.="|".$pLat.','.$pLng;
        }

    	return view('search.view',['garden'=>$garden,'message'=>$req->message,'preview'=>$req->preview,'staticImgUrl'=>$staticImgUrl]);
    }

}
