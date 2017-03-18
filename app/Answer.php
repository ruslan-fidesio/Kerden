<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    //
    protected $guarded = [];

    public function commentaire(){
    	return $this->belongsTo('App\Commentaire');
    }

    public function author(){
    	return $this->belongsTo('App\User','user_id');
    }
}
