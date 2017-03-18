<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Reservation;
use App\Annulation;
use App\Penalite;
use Carbon\Carbon;
use Auth;
use App\KerdenMailer;

class AnnulationController extends Controller
{
    public function __construct(){
    	$this->middleware(['auth','role:light']);
    }

    public function byUser($id){
    	$resa = Reservation::findOrFail($id);
    	if($resa->status != 'waiting_confirm' && $resa->status != 'confirmed' && $resa->status != "waiting_payin"){
    		return redirect()->back();
    	}
        if(Carbon::parse($resa->date_begin,'Europe/Paris')->isPast() ){
            return redirect()->back()->withErrors('Impossible d\'annuler la réservation : Évenement déjà commencé...');
        }


    	$interval = $this->getDiffInHoursWithNow($resa);
        $oscarRefund = $interval > 24 ? $resa->staff_amount : 0;
        $percent = $this->getLocationRefundPercent($interval);
        $locationRefund = $resa->location_amount*$percent / 100;
    	return view('annulation.byUser',['reservation'=>$resa ,
            'interval'=>$interval,
            'oscarRefund'=>$oscarRefund,
            'locationRefund'=>$locationRefund,
            'percent'=>$percent]);
    }

    public function confirmByUser($id){
    	$resa = Reservation::findOrFail($id);
    	if(Auth::user()->id != $resa->user->id){
    		return redirect('/home')->with('error','Cette réservation ne vous concerne pas');
    	}

    	if($resa->status != 'confirmed'){
    		$resa->status = 'canceled_by_user';
    		$resa->save();
            KerdenMailer::mailNoReply( $resa->garden->owner->email, 'canceledByUser',['reservation'=>$resa]);
            if($resa->nb_staff > 0){
                KerdenMailer::mailNoReply( env('OSCAR_MAIL'),'canceledByUser',['reservation'=>$resa] );
            }
    		return redirect('/home')->with('message','Réservation annulée');
    	}else{
    		//create Annulation
            $intervalInHours = $this->getDiffInHoursWithNow($resa);
            $annulation = Annulation::fromUserReservation($resa,$intervalInHours);

            //execute It
            $annulation->execute();
            $annulation->save();
            $resa->status = "refund_by_user";
            $resa->save();

            return redirect('/home')->with('message','Réservation annulée');
    	}
    }

    public function byOwner($id){
        $resa = Reservation::findOrFail($id);
        $checkDate  = Carbon::parse($resa->date_begin,'Europe/Paris');
        if($resa->status != 'confirmed'){
            return redirect()->back();
        }
        if($checkDate->isPast() ||
            $checkDate->diffInHours(Carbon::now('Europe/Paris')) < 24 ){
            return redirect()->back()->withErrors('Impossible d\'annuler la réservation moins de 24h avant l\'évenement.');
        }

        return view('annulation.byOwner',['id'=>$id]);
    }

    public function confirmByOwner($id){
        $resa = Reservation::findOrFail($id);
        if(Auth::user()->id != $resa->garden->owner->id){
            return redirect('/home')->with('error','Cette réservation ne vous concerne pas');
        }
        if($resa->status != 'confirmed'){
            return redirect()->back();
        }

        //create annulation
        $annulation = Annulation::fromOwnerReservation($resa);

        //execute it
        $annulation->execute();

        //create penalite
        $penalite = Penalite::firstOrCreate(['user_id'=>$resa->garden->owner->id]);
        $penalite->total_amount += 50;
        $penalite->current_amount += 50;
        $penalite->save();

        //change reservation status
        $resa->status = 'refund_by_owner';
        $resa->save();

        return redirect('/reservation/ownerView/'.$resa->id);

    }

    public function getDiffInHoursWithNow($reservation){
        return Carbon::parse($reservation->date_begin,'Europe/Paris')->diffInHours(Carbon::now('Europe/Paris'));
    }

    public function getLocationRefundPercent($interval){
        if($interval < 72){
            return 60;
        }else{
            return 83;
        }
    }
}
