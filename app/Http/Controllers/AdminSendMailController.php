<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\KerdenMailer;
use Mail;
use Lang;

class AdminSendMailController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','admin']);
    }


    public function create(){
    	return view('admin.sendMails');
    }

    public function send(Request $req){
    	if(empty($req->adresses)){
    		return redirect('/admin')->with('error','Il faut au moins une adresse');
    	}

    	$adresses = explode("\n",$req->adresses);
    	$message = '';
    	$error = '';
    	foreach($adresses as $k=>$ad){
    		try{
    			$res = KerdenMailer::mailContact($ad,$req->mail_type,['link'=>url('/seeMail/contact')]);
	    		$message .= $ad." : envoi OK <br/>";
    		}
    		catch(\Exception $e){
    			$error .= "Erreur sur ".$ad." :: ".$e->getMessage();
    		}
    	}
    	return redirect('/admin')->with('error',$error)->with('message',$message);
    }

}
