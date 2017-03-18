<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Commentaire extends Model
{
    protected $guarded = [];

    public function getRealNoteAttribute(){
    	return $this->note/2;
    }

    public function reservation(){
    	return $this->belongsTo('App\Reservation');
    }

    public function answer(){
    	return $this->hasOne('App\Answer');
    }

    public function author(){
        return $this->belongsTo('App\User','user_id');
    }

    public function getNoteAsFAStars(){
        $res = '';
        for($i=0; $i<5; $i++){
            if($i < $this->note/2){
                if($this->note/2-$i == 0.5){
                    $res .= '<i class="fa fa-star-half-o"></i>';
                }else{
                    $res .= '<i class="fa fa-star"></i>';
                }
            }else{
                $res .= '<i class="fa fa-star-o"></i>';
            }
        }
        return $res;
    }
}
