<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Receipt extends Model
{
    protected $guarded = [];


    public static function findOrCreateByReservationID($id){
    	$res = Receipt::firstOrCreate(['reservation_id'=>$id]);
    	if($res->wasRecentlyCreated){
    		$res->generateReferenceString();
    		$res->save();
    	}
    	return $res;
    }

    public function generateReferenceString(){
    	$baseRef = Carbon::parse($this->reservation->date_begin)->format("Y-m-");
    	$x = 1;
    	$reference = $baseRef.$x;

    	while( Receipt::where('reference',$reference)->count() > 0){
    		$x++;
    		$reference = $baseRef.$x;
    	}

    	$this->reference = $reference;
    }


    public function reservation(){
    	return $this->belongsTo('App\Reservation');
    }
}
