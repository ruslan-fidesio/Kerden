<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Reservation;
use Carbon\Carbon;

class OscarController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','oscar']);
    }

    public function menu(){
    	$waitingForConfirm = Reservation::where('nb_staff','>',0)->whereIn('status',['waiting_confirm','waiting_payin'])->get();
        $confirmed = Reservation::where('nb_staff','>',0)->where('status','confirmed')->get();
        $passed = Reservation::where('nb_staff','>',0)->where('status','done')->get();

        $canceled = Reservation::where('nb_staff','>',0)->whereNotIn('status',['confirmed','new','waiting_payin','waiting_confirm','done'])->get();
    	
    	return view('oscar.menu',['waitingForConfirm'=>$waitingForConfirm,
    							'confirmed'=>$confirmed,
    							'passed'=>$passed,
                                'canceled'=>$canceled]);
    }

    public function view($id){
    	$reservation = Reservation::find($id);
    	return view('oscar.view',['reservation'=>$reservation]);
    }

    public function decision($id){
    	$reservation = Reservation::find($id);
    	return view('oscar.decision',['reservation'=>$reservation]);
    }
}
