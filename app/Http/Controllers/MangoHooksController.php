<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\KYCDocument;
use App\KerdenMailer;
use App\UserRole;

class MangoHooksController extends Controller
{
    public function start(Request $req){
    	if( !$req->has('EventType') || !$req->has('RessourceId')){
    		abort(400);
    	}
    	if($req->EventType == "KYC_SUCCEEDED"){
    		$this->kyc_succeeded($req);
    	}
    	elseif($req->EventType == "KYC_FAILED"){
    		$this->kyc_failed($req);
    	}else{
    		abort(400);
    	}
    }

    private function kyc_succeeded(Request $req){
    	$kycDoc = KYCDocument::where('ressource_id',$req->RessourceId)->first();
    	if(count($kycDoc)==0) abort(400);

    	$kycDoc->state = 'valid';
    	$kycDoc->save();

    	$role = UserRole::find($kycDoc->user_id);
    	$role->role = 'regular';
    	$role->save();

        $this->mailUser($kycDoc->user,true);
        $this->mailAdmin($kycDoc->user,true);

    	return response();
    }

    private function kyc_failed(Request $req){
    	$kycDoc = KYCDocument::where('ressource_id',$req->RessourceId)->first();
    	if(count($kycDoc)==0) abort(400);

    	$kycDoc->state = 'refused';
    	$kycDoc->save();

        $this->mailUser($kycDoc->user,false);
        $this->mailAdmin($kycDoc->user,false);

    	return response();

    }

    private function mailAdmin($user, $success){
        KerdenMailer::mailNoReply(env('KERDEN_ADMIN_MAIL'),'kycHook',['user'=>$user,'success'=>$success]);
    }

    private function mailUser($user, $success){
        KerdenMailer::mailNoReply($user->email,'kycHookUser',['user'=>$user,'success'=>$success]);
    }
}
