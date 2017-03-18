<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Reservation;
use Carbon\Carbon;
use PDF;

class InvitationCardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','resa.owner']);
    }

    public function create($id, Request $req){
    	$reservation = Reservation::find($id);
        if($reservation->status != "confirmed"){
            return redirect('/home')->with('error','Le statut de la réservation ne permet pas cette opération.');
        }
    	return view('invitCard.menu',['reservation'=>$reservation]);
    }

    public function sendPreview($id, Request $req){
    	$reservation = Reservation::find($id);
    	setlocale(LC_TIME,'fr_FR.UTF-8');
    	$begin = Carbon::parse($reservation->date_begin);
    	$formatedDate = $begin->formatLocalized("%A %d %B %Y");
    	$formatedHour = 'De '.$begin->hour.'h00 à '.Carbon::parse($reservation->date_end)->hour.'h00';

    	$guestsCanSee = $reservation->garden->locInfos->where('type','GUESTSCANSEE');
    	$guestsCanSee = $guestsCanSee->count()>0? $guestsCanSee->first() : null;

        $title = $req->get('title','Anniversaire');
    	$fontColor = $req->get('fontColor','000000');
    	$background = $req->get('background','anniv1');
    	$format = $req->get('format','A4');
    	$numberOfCards = strstr($format,'-');
    	$numberOfCards = $numberOfCards ? ltrim($numberOfCards,'-') : 1;
        $insertMail = $req->get('insertMail',0);
        $insertPhone = $req->get('insertPhone',0);
    	return view('invitCard.card',[
    		'reservation'=>$reservation,
            'title'=>$title,
    		'fontColor'=>$fontColor,
    		'background'=>$background,
    		'format'=>$format,
    		'numberOfCards'=>$numberOfCards,
    		'formatedDate'=>$formatedDate,
    		'formatedHour'=>$formatedHour,
    		'guestsCanSee'=>$guestsCanSee,
            'captionColor'=>$this->computeCaptionColor($fontColor),
            'insertPhone'=>$insertPhone,
            'insertMail'=>$insertMail,
    		]);
    }

    public function sendDocument($id,Request $req){
    	$reservation = Reservation::find($id);
    	setlocale(LC_TIME,'fr_FR.UTF-8');
    	$begin = Carbon::parse($reservation->date_begin);
    	$formatedDate = $begin->formatLocalized("%A %d %B %Y");
    	$formatedHour = 'De '.$begin->hour.'h00 à '.Carbon::parse($reservation->date_end)->hour.'h00';

    	$guestsCanSee = $reservation->garden->locInfos->where('type','GUESTSCANSEE');
    	$guestsCanSee = $guestsCanSee->count()>0? $guestsCanSee->first() : null;

        $title = $req->get('title','Anniversaire');
    	$fontColor = $req->get('fontColor','000000');
    	$background = $req->get('background','anniv1');
    	$format = $req->get('format','A4');
    	$pdfRealFormat = strstr($format,'-',true);
    	$pdfRealFormat = $pdfRealFormat ? $pdfRealFormat : $format;
    	$numberOfCards = strstr($format,'-');
    	$numberOfCards = $numberOfCards ? ltrim($numberOfCards,'-') : 1;
        $orientation = $numberOfCards==8? 'landscape' : 'portrait';

        $insertMail = $req->get('insertMail',false);
        $insertPhone = $req->get('insertPhone',false);

    	return PDF::loadView('invitCard.card',
    		['reservation'=>$reservation,
            'title'=>$title,
    		'fontColor'=>$fontColor,
    		'background'=>$background,
    		'format'=>$format,
    		'formatedDate'=>$formatedDate,
    		'formatedHour'=>$formatedHour,
    		'numberOfCards'=>$numberOfCards,
    		'guestsCanSee'=>$guestsCanSee,
            'insertPhone'=>$insertPhone,
            'insertMail'=>$insertMail,
            'captionColor'=>$this->computeCaptionColor($fontColor)])
    	->setOption('encoding','utf-8')
    	->setOption('margin-top', 0)
    	->setOption('margin-right', 0)
    	->setOption('margin-bottom', 0)
    	->setOption('margin-left', 0)
    	->setOption('page-size',$pdfRealFormat)
        ->setOrientation($orientation)
    	->download('Kerden_carte_'.$reservation->user->firstName.'.pdf');
    }

    private function computeCaptionColor($fontColor){
        return 'BBBBBB';
        // $RGB = str_split($fontColor,2);
        // //TO DECIMAL
        // $r = base_convert( $RGB[0], 16, 10);
        // $g = base_convert( $RGB[1], 16, 10);
        // $b = base_convert( $RGB[2], 16, 10);
        // //DIVIDE, BACK TO HEXA
        // $r = base_convert( min(floor($r*2.5),200), 10,16);
        // $g = base_convert( min(floor($g*2.5),200), 10,16);
        // $b = base_convert( min(floor($b*2.5),200), 10,16);
        // //add missing leading 0
        // if(strlen($r)==1) $r = '0'.$r ;
        // if(strlen($g)==1) $g = '0'.$g ;
        // if(strlen($b)==1) $b = '0'.$b ;
        // //deny 00
        // if($r=='00') $r="88";
        // if($g=='00') $g="88";
        // if($b=='00') $b="88";
        // return $r.$g.$b;
    }


}
