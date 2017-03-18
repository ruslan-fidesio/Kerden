<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Validator;
use App\Garden;
use Auth;
use App\GardenDispo;
use App\Reservation;
use Carbon;
use App\KerdenMailer;
use App\Traits\MangoPayTrait;
use App\PayIn;
use App\Message;

class ReservationController extends Controller
{
	use MangoPayTrait;
    public function __construct()
    {
        $this->middleware(['auth','role:light']);
    }

	private function validator($data){
		$params = [
			'date'=>'required',
			'garden_id' => 'required',
			'begin_slot' => 'required',
			'end_slot'  => 'required',
			'nb_pers' => 'required',
		];
		return Validator::make($data, $params);
    }

    public function create(Request $req){
    	$validator = $this->validator($req->all());
    	if($validator->fails()){
            return redirect()->back()->withInput()->withErrors($validator->errors());
    	}
        $garden = Garden::find($req->garden_id);
        //petit check pour pas reserver chez soi
        if(Auth::user()->id == $garden->owner->id){
            return redirect('/home')->with('error','Ceci est votre propre jardin...avez vous vraiment besoin d\'une réservation?');
        }

        $carbDate = Carbon\Carbon::parse($req->date);

        if( ! $this->checkTimeSlot($garden,$carbDate, $req->begin_slot, $req->end_slot) ){
            return redirect('/home')->with('error','Problème sur les créneaux horaires : votre réservation contient des paramètres incorrects');
        }

        if( ! $this->checkNbGuests($garden,$req->nb_pers)){
            return redirect()->back()->withInput()->withErrors(['nb_pers'=>'max']);
        }


        //create the reservation (state :'new')
        $resa = new Reservation();
        $resa->populateFromRequest($req);
        $resa->computePrices();
        $resa->computeAutoCancelDate();

        //check light users
        if( !$this->checkUserRoleAndAmount($resa) ){
            return redirect('/home')->with('error','Vous allez dépasser la limite autorisée pour les utilisateurs sans preuve d\'identité...<a href="/proofOfId">Cliquez ici pour prouver votre identité</a>');
        }

        //check delay
        if($resa->getIntervalInHoursWithBeginMorning() <= 13){
            return redirect('/home')->with('error','Impossible de créer cette réservation : la date est trop proche dans le futur.');
        }

        //put the reservation in session
        $req->session()->put('creatingReservation',$resa);

        $discussion = $this->discussionExists( $resa->garden->id, $resa->user->id);

        return response()->view('reservation.resume',['reservation'=>$resa,'discussion'=>$discussion])
         		->header("Cache-Control", " no-cache, max-age=0, must-revalidate, no-store");
    }

    public function createFromSession(Request $req){
        if($req->session()->has('creatingReservation')){
    	   $resa = $req->session()->get('creatingReservation');
           return response()->view('reservation.resume',['reservation'=>$resa])
                ->header("Cache-Control", " no-cache, max-age=0, must-revalidate, no-store");
        }
        else{
            $req->merge($req->session()->all());
            return $this->create($req);
        }
    }

    public function checkTimeSlot($garden,$carbDate, $beginSlot,$endSlot){
        //check dispo
        $dispo = GardenDispo::where('garden_id',$garden->id)->where('date',$carbDate->timestamp);
        if($dispo->count() == 0){ return false;}
        else{
            if($dispo->first()->dispo == 'unavaile') return false;
        }

        //check other reservations
        foreach($garden->reservations as $resa){
            $resaDate = Carbon\Carbon::parse($resa->date_begin);
            if($resaDate->isSameDay($carbDate)){
                if($resa->status == 'new' || $resa->status == 'waiting_confirm' || $resa->status == 'waiting_payin' || $resa->status == 'confirmed'){
                    return false;
                }
            }
        }

        //check hours
        $hours = $garden->getHours($carbDate->dayOfWeek);
        return ( $beginSlot >= $hours->begin_slot && $endSlot <= $hours->end_slot );
    }

    private function checkUserRoleAndAmount($reservation){
        $user = Auth::user();
        if($user->role->role == 'light' ){
            return ($user->totalAmountPayed + $reservation->total_amount)<=2500;
        }else return true;
    }

    private function checkNbGuests($garden, $nb_pers){
        return ($nb_pers <= $garden->max_pers);
    }

    public function show($id, Request $req){
        $resa = Reservation::find($id);
        if($resa==null)return redirect('/home')->with('error','Cette réservation n\'éxiste pas ou plus');
        if($resa->user_id != Auth::user()->id ){
            //if(Auth::user()->role->role != 'admin'){
                return redirect('/home')->with('error','Cette réservation ne vous concerne pas');
            //}
        }

        $discussion = $this->discussionExists( $resa->garden->id, $resa->user->id);

        return response()->view('reservation.resume',['reservation'=>$resa,'discussion'=>$discussion])
                        ->header("Cache-Control", " no-cache, max-age=0, must-revalidate, no-store");
    }

    public function ownerShow($id, Request $req){
        $resa = Reservation::findOrFail($id);
        if($resa->garden->owner->id != Auth::user()->id){
            return redirect('/home')->with('error','Vous n\'êtes pas le propriétaire du jardin concerné par cette réservation');
        }
        $discussion = $this->discussionExists( $resa->garden->id, $resa->user->id);
        return response()->view('reservation.ownerResume',['reservation'=>$resa,'discussion'=>$discussion])
                        ->header("Cache-Control", " no-cache, max-age=0, must-revalidate, no-store");
    }

    private function discussionExists($gardenId, $askerId){
        return Message::where('garden_id',$gardenId)->where('asker_id',$askerId)->count() > 0;
    }

    public function index(Request $req){
        $reservations = Auth::user()->reservations;
        $waiting = $reservations->filter(function($r){ return ($r->status=='new' || $r->status=='waiting_confirm' || $r->status=='waiting_payin'); });

        $confirmed =$reservations->filter(function($r){ return $r->status=='confirmed';});
        $passed = $reservations->filter(function($r){ return $r->status=='done'&&Carbon\Carbon::parse($r->date_end)->isPast();});
        $canceled = $reservations->filter(function($r){ return in_array($r->status, ['canceled_by_user','denied_by_owner','denied_by_staff','refund_by_user','refund_by_owner','time_canceled']); });
        return view('reservation.list',['waiting'=>$waiting,
                                        'confirmed'=>$confirmed,
                                        'passed'=>$passed,
                                        'canceled'=>$canceled]);
    }


    public function userConfirm(Request $req){
    	$resa = $req->session()->get('creatingReservation');
    	if($resa->user_id != Auth::user()->id){
            return redirect('/home')->with('error','Cette réservation ne vous concerne pas');
        }
        if($resa->status != 'new'){
            return redirect('/home')->with('error','Impossible d\'effectuer cette opération: réservation '.$resa->state);
        }
        if(empty($req->description)){
            return redirect('reservation/create')->with('error','La description ne doit pas être vide.');
        }
        $resa->description_by_user = $req->description;
        $resa->status = "waiting_confirm";
        $resa->save();
        $req->session()->forget('creatingReservation');

        if($resa->owner_confirmed && $resa->staff_confirmed){
            $resa->status = 'waiting_payin';
            $resa->save();
        	return redirect('/reservation/view/'.$resa->id);
        }
        else{
        	//SEND MAILS
        	if(!$resa->owner_confirmed){
                KerdenMailer::mailNoReply($resa->garden->owner->email,'askReservation',['reservation'=>$resa,'link'=>url('/seeMailResa/'.$resa->id)]);
            }
            if(!$resa->staff_confirmed){
                KerdenMailer::mailNoReply(env('OSCAR_MAIL'),'askOscar',['reservation'=>$resa,'link'=>url('/oscar/view/'.$resa->id)]);
            }

        	return view('reservation.validated',['reservation'=>$resa]);
        }
    }

    public function ownerCancel($id, Request $req){
        $reservation = Reservation::findOrFail($id);
        if($reservation->garden->owner->id != Auth::user()->id){
            return redirect('/home')->with('error','Cette réservation ne vous concerne pas');
        }
        if($reservation->status != 'waiting_confirm'){
            return redirect('/home')->with('error','Impossible d\'effectuer cette opération : réservation '.$reservation->state);
        }
        if($reservation->owner_confirmed){
            return redirect('/home')->with('error','Réservation déjà confirmée.');   
        }

        $reservation->owner_decision_date = Carbon\Carbon::now();
        $reservation->status = 'denied_by_owner';
        $reservation->save();

        //send mail locataire
        KerdenMailer::mailNoReply($reservation->user->email, 'canceledByOwner', ['reservation'=>$reservation]);
        if($reservation->nb_staff != 0){
            KerdenMailer::mailNoReply(env('OSCAR_MAIL'),'oscarCanceledByOwner',['reservation'=>$reservation]);
        }
        return redirect('/reservation/ownerView/'.$reservation->id);
    }

    public function ownerConfirm($id, Request $req){
        $reservation = Reservation::findOrFail($id);
        if($reservation->garden->owner->id != Auth::user()->id){
            return redirect('/home')->with('error','Cette réservation ne vous concerne pas');
        }
        if($reservation->status != 'waiting_confirm'){
            return redirect('/home')->with('error','Impossible d\'effectuer cette opération : réservation '.$reservation->state);
        }
        if($reservation->owner_confirmed){
            return redirect('/home')->with('error','Réservation déjà confirmée.');   
        }

        $reservation->owner_decision_date = Carbon\Carbon::now();
        $reservation->owner_confirmed = 1;
        $reservation->save();

        $this->checkConfirmedReservation($reservation);
        
        return redirect('/reservation/ownerView/'.$reservation->id);
    }

    public function oscarCancel($id,Request $req){
        $reservation = Reservation::find($id);
        if($reservation->status != 'waiting_confirm'){
            return redirect('/home')->with('error','Impossible de modifier cette réservation : réservation '.$reservation->state);
        }
        if($reservation->staff_confirmed){
            return redirect('/home')->with('error','Réservation déjà confirmée.');
        }

        //send mail locataire
        KerdenMailer::mailNoReply($reservation->user->email,'canceledByOscar',['reservation'=>$reservation]);
        //send mail owner
        KerdenMailer::mailNoReply($reservation->garden->owner->email,'ownerCanceledByOscar',['reservation'=>$reservation]);

        $reservation->owner_decision_date = Carbon\Carbon::now();
        $reservation->status = 'denied_by_staff';
        $reservation->save();
        return redirect('/oscar/view/'.$reservation->id);
    }

    public function oscarConfirm($id,Request $req){
        $reservation = Reservation::find($id);
        if($reservation->status != 'waiting_confirm'){
            return redirect('/home')->with('error','Impossible de modifier cette réservation : réservation '.$reservation->state);
        }
        if($reservation->staff_confirmed){
            return redirect('/home')->with('error','Réservation déjà confirmée.');
        }

        $reservation->staff_confirmed = 1;
        $reservation->save();
        
        $this->checkConfirmedReservation($reservation);

        return redirect('/oscar/view/'.$reservation->id);
    }

    private function checkConfirmedReservation($reservation){
    	if($reservation->status != 'waiting_confirm') return;

    	if($reservation->owner_confirmed && $reservation->staff_confirmed){
    		$reservation->status = "waiting_payin";
    		$reservation->computeAutoCancelDate();
    		$reservation->save();

    		KerdenMailer::mailNoReply( $reservation->user->email ,'waitingPayin',['reservation'=>$reservation]);
    	}
    }

    public function createPayIn($id, Request $req){
    	$reservation = Reservation::findOrFail($id);
    	if($reservation->user_id != Auth::user()->id){
            return redirect('/home')->with('error','Cette réservation ne vous concerne pas');
        }
        if($reservation->status != 'waiting_payin'){
            return redirect('/home')->with('error','Impossible d\'effectuer cette opération: réservation '.$reservation->state);
        }

        $payin = $this->createDirectPayin( $reservation->user->mangoUser->mangoUserId, $reservation->user->mangoUser->mangoWalletId, $reservation->total_amount, $reservation->id );

        if($payin->Status == "CREATED"){
            //dd($payin);
        	//return redirect()->away($payin->ExecutionDetails->RedirectURL);
            return view('payin.template',['formURL'=>$payin->ExecutionDetails->RedirectURL]);
        }
        else{
        	return redirect('/home')->with('error','Erreur creation paiement : '.$payin->ResultMessage);
        }
    }

    public function backFromWebPay($id, Request $req){
    	$reservation = Reservation::findOrFail($id);
    	if($reservation->user_id != Auth::user()->id){
            return redirect('/home')->with('error','Cette réservation ne vous concerne pas');
        }
        if($reservation->status != 'waiting_payin'){
            return redirect('/home')->with('error','Impossible d\'effectuer cette opération: réservation '.$reservation->state);
        }
        if(! $req->has('transactionId')){
        	return redirect('/home')->with('error','Impossible d\'effectuer le paiement: missing transactionId');     
        }

        $res = $this->checkPayInStatus($req->transactionId);
        if($res->Status != "SUCCEEDED"){
        	return redirect('/reservation/view/'.$id)->withErrors('Le paiement a échoué. Message : '.$res->ResultMessage);
        }
        else{
        	$kerdPayIn = PayIn::fromReservation($reservation);
        	$kerdPayIn->status = $res->Status;
            $kerdPayIn->mango_payIn_Id = $req->transactionId;
        	$kerdPayIn->save();

        	$reservation->payIn_Id = $kerdPayIn->id;
        	$reservation->status = "confirmed";
        	$reservation->save();
        	KerdenMailer::mailNoReply($reservation->garden->owner->email, 'confirmOwnerReservation',['reservation'=>$reservation]);
        	KerdenMailer::mailNoReply($reservation->user->email, 'confirmReservation',['reservation'=>$reservation]);
        	if($reservation->nb_staff>0){
        		KerdenMailer::mailNoReply(env('OSCAR_MAIL'), 'confirmOscarReservation',['reservation'=>$reservation]);
        	}
        	return redirect('/reservation/view/'.$id);
        }

    }

    public function trickFrame($id, Request $req){
        //dd($req);
        $transactionId = $req->has('transactionId') ? $req->transactionId : 0;
        $url = url('/backFromWebPay/'.$id).'?transactionId='.$transactionId;
        return view('payin.backFromWebPay',['url'=>$url]);
    }

}
