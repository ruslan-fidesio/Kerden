<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
	protected $fillable = ['id','name','type','headQuartersAddressLine1','headQuartersAddressLine2','headQuartersAddressCity',
							'headQuartersAddressPostalCode','headQuartersAdressCountry'];

    public static function findOrCreate($id)
	{
	    $obj = static::find($id);
	    return $obj ?: new static;
	}
}
