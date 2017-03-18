<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Mail;
use App\KerdenMailer;
use Validator;

class ContactController extends Controller
{
    public function __construct()
    {
        
    }

    public function rent(Request $req){
    	return view('contact.rent');
    }

    public function sendRent(Request $req){
    	$user = $req->user();
    	$res = Mail::send('mails.rentMe',[
    		'user'=>$user,
    		'content'=>$req->content
    	],function($m) use($user){
    		$m->from('noreply@kerden.fr','Kerden');
    		$m->subject('Nouveau Propriétaire Potentiel');
    		$m->to( env('KERDEN_ADMIN_MAIL') );
    	});

    	if($res){
    	   return redirect('/home')->with('message','Envoi message OK. Nous vous contacterons au plus vite.');
        }

        return redirect('/home')->with('error','ERREUR ENVOI MESSAGE');
    }

    public function sendQuestion(Request $req){
        $validator = Validator::make($req->all(),[
            'email'=>'required|email',
            'content'=>'required|max:255']);
        if($validator->fails()){
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }else{
            KerdenMailer::mailNoReply('contact@kerden.fr', 'offlineMessage', ['content'=>$req->content,'email'=>$req->email]);
            $req->session()->push('questionSent','true');
            return redirect()->back();
        }
    }
}
