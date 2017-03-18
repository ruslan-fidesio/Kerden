<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MangoBankAccount extends Model
{
    //
    protected $fillable = ['user_id','account_id'];
   	public $timestamps = false;
}
