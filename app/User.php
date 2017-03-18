<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use DB;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstName','lastName' ,'email', 'password','blocked'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getFullnameAttribute($value){
        return $this->firstName.' '.$this->lastName;
    }

    public function ownedGardens(){
        return $this->hasMany('App\Garden','userid');
    }

    public function role(){
        return $this->hasOne('App\UserRole','id');
    }

    public function reservations(){
        return $this->hasMany('App\Reservation','user_id');
    }

    public function mangoUser(){
        return $this->hasOne('App\MangoUser','id');
    }

    public function mangoBankAccount(){
        return $this->hasOne('App\MangoBankAccount','user_id');
    }

    public function details(){
        return $this->hasOne('App\UserDetail','id');
    }

    public function advancedDetails(){
        return $this->hasOne('App\UserAdvancedDetails','user_id');
    }

    public function kycDocuments(){
        return $this->hasMany('App\KYCDocument','user_id');
    }

    public function penalites(){
        return $this->hasMany('App\Penalite','user_id');
    }

    public function phone(){
        return $this->hasOne('App\UserPhone','user_id');
    }

    public function getActivePenalites(){
        return $this->penalites->filter(function($item){
            return $item->current_amount > 0;
        });
    }

    public function getTotalPenalitesAmount(){
        return $this->getActivePenalites()->sum('current_amount');
    }

    public function getTotalAmountPayedAttribute(){
        return DB::table('pay_ins')->where('user_id',$this->id)->where('status','SUCCEEDED')->sum('total_amount');
    }

    public function getUnreadMessagesAttribute(){        
        return $this->getUnreadMessagesAsAskerAttribute() + $this->getUnreadMessagesAsOwnerAttribute();
    }

    public function getUnreadMessagesAsAskerAttribute(){
        return DB::table('messages')->where('asker_id',$this->id)->where('author_id','!=',$this->id)->where('red',false)->count();
    }

    public function getUnreadMessagesAsOwnerAttribute(){
        $res = 0;
        foreach ($this->ownedGardens as $key => $garden) {
            $res+=$this->getUnreadMessagedForGarden($garden->id);
        }
        return $res;
    }

    public function getUnreadMessagedForGarden($gardenId){
        return DB::table('messages')->where('garden_id',$gardenId)->where('author_id','!=',$this->id)->where('red',false)->count();
    }

}
