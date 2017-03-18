<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    
    public function garden(){
    	return $this->belongsTo('App\Garden');
    }

    public function asker(){
    	return $this->belongsTo('App\User','asker_id');
    }

    public function author(){
    	return $this->belongsTo('App\User','author_id');
    }

}
