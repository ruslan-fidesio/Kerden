<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Penalite extends Model
{
    //
    protected $guarded = [];


    public function annulation(){
    	return $this->belongsTo('App\Annulation','annulation_id');
    }
}
