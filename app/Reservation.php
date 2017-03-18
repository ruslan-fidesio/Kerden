<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Reservation extends Model
{
    //

    public function garden(){
    	return $this->belongsTo('App\Garden','garden_id');
    }

    public function user(){
        return $this->belongsTo('App\User','user_id');
    }

    public function payIn(){
        return $this->belongsTo('App\PayIn','payIn_Id');
    }

    public function annulation(){
        return $this->hasOne('App\Annulation');
    }

    public function facture(){
        return $this->hasOne('App\Facture');
    }

    public function receipt(){
        return $this->hasOne('App\Receipt');
    }

    public function commentaire(){
        return $this->hasOne('App\Commentaire');
    }

    public function getStateAttribute(){
    	switch ($this->status) {
    		case 'new':
    			return 'en attente de validation';
    			break;
    		case 'waiting_confirm':
                $res = 'en attente de confirmation ';
                if($this->owner_confirmed == 0) $res.='du propriétaire';
                elseif($this->staff_confirmed == 0) $res.='de Oscar.fr';
                return $res;
                break;
            case 'waiting_payin':
                return 'en attente de paiement par le locataire';
                break;
            case 'canceled_by_user':
                return 'annulée par le locataire';
                break;
            case 'denied_by_owner':
                return 'refusée par le propriétaire';
                break;
            case 'denied_by_staff':
                return 'refusée par Oscar.fr';
                break;
            case 'confirmed':
                return 'confirmée';
                break;
            case 'done':
                return 'effectuée';
                break;
            case 'refund_by_user':
                return 'annulée par le locataire - remboursée';
                break;
            case 'refund_by_owner':
                return 'annulée par le propriétaire - remboursée';
                break;
            case 'time_canceled':
                return 'expirée avant validation';
                break;
    		default:
    			return $this->status;
    			break;
    	}
    }

    public function populateFromRequest($request){
        $this->garden_id = $request->garden_id;
        $this->user_id = $request->user()->id;

        $this->date_begin = Carbon::parse($request->date)->addHours($request->begin_slot);
        $this->date_end = Carbon::parse($request->date)->addHours($request->end_slot);
        $this->nb_guests = $request->nb_pers;

        if($request->dayStaff){
            $this->staff_begin = $this->date_begin;
            $this->nb_staff = ceil($this->nb_guests/30);
        }
        elseif($request->nightStaff && $request->end_slot>18){
            $this->nb_staff = ceil($this->nb_guests/30);

            if($this->begin_slot>=18) $this->staff_begin = $this->date_begin;
            else $this->staff_begin = Carbon::parse($request->date)->addHours(18);

            if($this->date_end->diffInHours($this->staff_begin) <2 ){
                $this->staff_begin = Carbon::parse($request->date)->addHours($request->end_slot-2);
            }
        }
        else{
            $this->nb_staff = 0;
        }

        $this->staff_confirmed = ($this->nb_staff==0);

        //getDispo ('manual'/'auto')
        $dispo = $this->garden->dispos->where('date', Carbon::parse($request->date)->timestamp )->first();

        $this->owner_confirmed = ($dispo->dispo=='auto');
        $this->status = 'new';
    }

    public function computePrices(){
        $location_amount = 0;
        $basePrice = ($this->date_begin->isWeekEnd()||$this->date_begin->dayOfWeek==5)? $this->garden->prices->weekEnd : $this->garden->prices->weekDay;
        $hour_begin = $this->date_begin->hour;
        $nbHours = $this->date_end->diffInHours($this->date_begin);
        for($i=0; $i<$nbHours; $i++){
            if($hour_begin + $i >= 18){
                $location_amount += $basePrice+ceil($basePrice/5);
            }else{
                $location_amount += $basePrice;
            }
        }

        $this->location_amount = $location_amount;
        $this->staff_amount = ($this->date_end->diffInHours($this->staff_begin))*env('OSCAR_HOUR_PRICE')*$this->nb_staff;

        $this->total_amount = $this->location_amount + $this->staff_amount;
    }

    public function computeAutoCancelDate(){
        $now = Carbon::now('Europe/Paris');
        $nbHours = 48;

        $interval = $this->getIntervalInHoursWithBeginMorning();
        if($interval < 24){
            $nbHours = 2;
        }
        else{
            if($interval < 48){
                $nbHours = 6;
            }
            else{
                if($interval < 72){
                    $nbHours = 12;
                }
                else{
                    if($interval < 120){
                        $nbHours = 24;
                    }
                }
            }
        }

        $this->autoCancelDate = $now->addHours($nbHours);
    }


    public function getIntervalInHoursWithBeginMorning(){
        $morningDate = Carbon::parse($this->date_begin,'Europe/Paris');
        $morningDate->hour = 9;
        
        $start = empty($this->created_at)? Carbon::now('Europe/Paris') : Carbon::parse($this->created_at);
        $start->tz = 'Europe/Paris';
        
        return $morningDate->diffInHours($start);
    }

}
