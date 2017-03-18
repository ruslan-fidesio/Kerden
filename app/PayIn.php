<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Reservation;

class PayIn extends Model
{

    public static function fromReservation(Reservation $Reservation){
    	$result = new PayIn();
    	$result->user_id = $Reservation->user->id;
    	$result->mango_wallet_id = $Reservation->user->mangoUser->mangoWalletId;
    	$result->total_amount = $Reservation->total_amount;
    	$result->status = 'new';
    	$result->tag = "payIn for reservation Id : ".$Reservation->id;
    	return $result;
    }

    public function user(){
    	return $this->belongsTo('App\User','user_id');
    }
}
