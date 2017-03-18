<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Mail;
use Auth;
use App\User;
use App\UserRole;
use App\Http\Requests;
use App\MailConfirmation;
use Carbon\Carbon;
use App\KerdenMailer;

class MailConfirmationController extends Controller
{
    //


    public function send(Request $request){
    	$user = Auth::User();

    	//check if a token already exists
    	if( $toerase = MailConfirmation::find($user->id) ){
    		if( $toerase->created_at->diffInMinutes(Carbon::now()) < 60 ){
                return redirect('/home')->with('error',trans('auth.waitresendemailconfirm'));
            }
            $toerase->delete();
    	}

    	$token = str_random(40);
    	MailConfirmation::create([
    		'id'=>$user->id,
    		'token'=>$token
    	]);

        $res = KerdenMailer::mailNoReply($user->email,'mailconfirmation',
            ['id'=>$user->id,
            'token'=>$token]);

        if($res){
    	   return redirect('/home')->with('message',trans('auth.confimationemailsent'));
        }

        return redirect('/home')->with('error',trans('auth.confirmationproblem'));


    }

    public function confirm($id,$token){
    	$exists = MailConfirmation::where('id',$id)->where('token',$token);
        $confirm = MailConfirmation::find($id);
    	if($confirm && ($confirm->token == $token)){
    		$theRole = UserRole::find($id);

    		//check time validity (60 minutes)
    		if( $confirm->created_at->diffInDays(Carbon::now()) > 60 ){
    			return redirect('/home')->with('error',trans('auth.expiredemailconfirm'));
    		}

    		if($theRole->role == 'new'){
    			$theRole->role = 'confirmed';
    			$theRole->save();
    		}
    		$confirm->delete();
    		return redirect('/home')->with('message',trans('auth.successemailconfirm'));
    	}
    	else{
    		return redirect('/home')->with('error',trans('auth.failemailconfirm'));
    	}
    }
}
