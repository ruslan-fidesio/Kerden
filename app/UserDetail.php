<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class UserDetail extends Model
{
    //
    protected $fillable = ['id','birthday','nationality','addressLine1','addressLine2','addressCity','countryOfResidence',
            'addressPostalCode','addressCountry','type','occupation','incomeRange','organization','proofOfIdentity'];
    protected $guarded = [];

    public static function findOrCreate($id)
	{
	    $obj = static::find($id);
	    return $obj ?: new static(['id'=>$id]);
	}

    public function getBirthdayAttribute($value){
        if($value == 0) return '';
        return date('d-m-Y',$value);
    }

    public function getFullAddressAttribute($value){
        $str = $this->addressLine1;
        if(!empty($this->addressLine2)){
            $str .= ", ".$this->addressLine2;
        }
        if(empty($str)) return "Non renseignée";
        return $str.', '.$this->addressPostalCode.', '.$this->addressCity;
    }
}
