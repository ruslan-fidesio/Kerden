<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Carbon;

class OwnerReservationController extends Controller
{
    public function __construct(){
    	$this->middleware(['auth']);
    }

    public function listReservationsInOwnedGardens(Request $req){
    	$gardens = $req->user()->ownedGardens;
    	$list = [];
        $numbers = [
        'waiting'=>0,
        'confirmed'=>0,
        'passed'=>0,
        'canceled'=>0
        ];

    	foreach ($gardens as $key => $garden) {
    		$reservations = $garden->reservations;
            $waiting = $reservations->filter(function($r){ return ($r->status=='waiting_confirm'||$r->status=='waiting_payin'); });
            $confirmed = $reservations->filter(function($r){ return ($r->status=='confirmed');});
            $passed = $reservations->filter(function($r){ return $r->status=='done'&&Carbon\Carbon::parse($r->date_end)->isPast();});
            $canceled = $reservations->filter(function($r){ return in_array($r->status, ['canceled_by_user','denied_by_owner','denied_by_staff','refund_by_user','refund_by_owner','time_canceled']); });
	        $list[$garden->title] =[
		        'waiting'=>$waiting,
                'confirmed'=>$confirmed,
                'passed'=>$passed,
                'canceled'=>$canceled
	        ] ;
            $numbers['waiting'] += count($waiting);
            $numbers['confirmed'] += count($confirmed);
            $numbers['passed'] += count($passed);
            $numbers['canceled'] += count($canceled);
    	}

    	return view('reservation.ownerList',['list'=>$list,'numbers'=>$numbers]);

    }


}
