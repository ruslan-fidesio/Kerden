<?php

namespace App;

use Mail;
use View;

class KerdenMailer{


	public static function mailContact($to,$view,$params){
		$subject = trans('mails.titles.'.$view);
		return KerdenMailer::sendMail('contact@kerden.fr','Contact Kerden',$to, $subject, $view, $params);
	}

	public static function mailNoReply($to, $view, $params){
		$subject = trans('mails.titles.'.$view);
		return KerdenMailer::sendMail('noreply@kerden.fr','Kerden - ne pas répondre',$to, $subject, $view, $params);
	}

	private static function generateLink($view, $params){
		$str = '/seeMail/'.$view.'?';
		foreach ($params as $key => $value) {
			$str .= $key.'='.$value.'&';
		}
		return url($str);
	}

	private static function sendMail($from, $fromName, $to, $subject, $view, $params){
		if(!isset($params['title'])){
			$params['title'] = trans('mails.titles.'.$view);
		}
		if(!isset($params['link'])){
			$params['link'] = KerdenMailer::generateLink($view,$params);
		}
		$view = 'mails.'.$view;
		try{
			$res = Mail::send($view,$params,function($m) use($from, $fromName, $to, $subject){
			    		$m->from($from,$fromName);
			    		$m->subject( $subject);
			    		$m->to(trim($to));
		    		});
			return $res;
		}
		catch(\Exception $e){
			dd('Erreur fatale envoi mail : '.$e->getMessage());
		}
	}
}


?>