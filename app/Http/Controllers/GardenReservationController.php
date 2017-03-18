<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Garden;
use Carbon;

class GardenReservationController extends Controller
{
    public function __construct(){
    	$this->middleware(['auth','owner']);
    }

    public function index($id, Request $req){
    	$garden = Garden::findOrFail($id);
    	$reservations = $garden->reservations;
        $waiting = $reservations->filter(function($r){ return ($r->status=='waiting_confirm'||$r->status=='waiting_payin'); });

        $confirmed =$reservations->filter(function($r){ return ($r->status=='confirmed');});
        $passed = $reservations->filter(function($r){ return $r->status=='done'&&Carbon\Carbon::parse($r->date_end)->isPast();});
        $canceled = $reservations->filter(function($r){ return in_array($r->status, ['canceled_by_user','denied_by_owner','denied_by_staff','refund_by_user','refund_by_owner','time_canceled']); });
        return view('garden.reservations',['garden'=>$garden,
        								'waiting'=>$waiting,
                                        'confirmed'=>$confirmed,
                                        'passed'=>$passed,
                                        'canceled'=>$canceled]);
    }
}
