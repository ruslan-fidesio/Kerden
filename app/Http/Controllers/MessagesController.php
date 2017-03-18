<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Garden;
use App\Message;
use App\Reservation;
use stdClass;
use Carbon\Carbon;
use Validator;
use Lang;
use App\KerdenMailer;

class MessagesController extends Controller
{
    
    public function __construct()
    {
        $this->middleware(['auth','role:light']);
    }

    public function menu(Request $req){
    	$groups = Message::where(['asker_id'=>$req->user()->id])->latest()->get()->unique('garden_id');
    	return view('messages.menu',['groups'=>$groups]);
    }

    public function ownerMenu(Request $req){
        $groups = [];
        $titles = [];
        foreach ($req->user()->ownedGardens as $key => $garden) {
            $mess = Message::where(['garden_id'=>$garden->id])->latest()->get()->unique('asker_id');
            $groups[$garden->id] = $mess;
            $titles[$garden->id] = $garden->title;
        }
        return view('messages.ownerMenu',['groups'=>$groups,'titles'=>$titles]);
    }

    public function newMessage($gardenId, Request $req){
    	$garden = Garden::findOrFail($gardenId);
    	if($garden->owner->id == $req->user()->id ){
    		return redirect('/home')->with('error','Ceci est votre propre jardin...avez vous vraiment besoin d\'une réservation?');
    	}
    	return view('messages.new',['garden'=>$garden]);
    }

    public function storeMessage($gardenId, Request $req){
    	$garden = Garden::findOrFail($gardenId);
        $validator = $this->contentValidator($req->all());
        if($validator->fails()){
            $req->replace(['content'=> $this->hideBannedWords($req->content) ]);
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }

    	$mess= new Message();
    	$mess->garden_id = $garden->id;
    	$mess->asker_id = $req->user()->id;
    	$mess->author_id = $req->user()->id;
    	$mess->content = $req->content;

    	$mess->save();

        $params = ['sender'=>$mess->author->fullName,
                    'content'=>nl2br($mess->content),
                    'link'=>'/owner/messages/'.$gardenId.'/'.$mess->asker_id];
        KerdenMailer::mailNoReply($garden->owner->email, 'newMessage', $params);

    	return redirect('/messages/'.$garden->id);
    }

    public function storeAnswer($gardenId, $askerId, Request $req){
        $validator = $this->contentValidator($req->all());
        if($validator->fails()){
            $req->replace(['content'=> $this->hideBannedWords($req->content) ]);
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        $mess = new Message();
        $mess->garden_id = $gardenId;
        $mess->asker_id = $askerId;
        $mess->author_id = $req->user()->id;
        $mess->content = $req->content;

        $mess->save();
        $params = ['sender'=>$mess->author->fullName,
                    'content'=>nl2br($mess->content),
                    'link'=>'/messages/'.$gardenId];
        KerdenMailer::mailNoReply($mess->asker->email, 'newMessage', $params);
        return redirect('/owner/messages/'.$gardenId.'/'.$askerId);
    }

    public function listMessage($gardenId, Request $req){
    	$garden = Garden::findOrFail($gardenId);
    	$messages = Message::where(['garden_id'=>$garden->id,'asker_id'=>$req->user()->id])->get();

        $newAvaible = $this->isNewMessageAvaible($messages);

        $this->setRedMessages($messages,$req->user()->id);

        $reservations = Reservation::where(['user_id'=>$req->user()->id, 'garden_id'=>$gardenId])->get();
        $events = [];
        foreach ($reservations as $key => $resa) {
            $events = array_merge($events, $this->makeEventsFromReservation($resa,$req->user()->id));
        }
        $events = array_merge($events,$messages->all());
        uasort($events, function($a,$b){
            return $b->created_at->diffInSeconds($a->created_at,false);
        });
        
        return view('messages.list',['garden'=>$garden,'events'=>$events,'newAvaible'=>$newAvaible]);
    }

    public function ownerListMessage($gardenId,$askerId,Request $req){
        $garden = Garden::findOrFail($gardenId);
        $messages = Message::where(['garden_id'=>$gardenId,'asker_id'=>$askerId])->oldest()->get();
        $this->setRedMessages($messages,$req->user()->id);
        $reservations = Reservation::where(['user_id'=>$askerId, 'garden_id'=>$gardenId])->get();
        $events = [];
        foreach ($reservations as $key => $resa) {
            $events = array_merge($events, $this->makeEventsFromReservation($resa,$req->user()->id));
        }
        $events = array_merge($events,$messages->all());
        uasort($events, function($a,$b){
            return $b->created_at->diffInSeconds($a->created_at,false);
        });
        return view('messages.ownerList',['garden'=>$garden,'events'=>$events,'askerId'=>$askerId]);
    }

    private function makeEventsFromReservation(Reservation $resa,$userId){
        $userName = ($resa->user_id == $userId)? 'Vous avez ': $resa->user->firstName.' a ';
        $ownerName = ($resa->user_id == $userId)? $resa->garden->owner->firstName.' a ':'Vous avez ';

        $events = [];
        $events[] = $this->createEvent($resa->created_at, $userName.' effectué une demande de réservation.', $resa->id);

        //owner Decision
        if($resa->owner_decision_date != NULL){
            if($resa->status == "denied_by_owner"){
                $events[] = $this->createEvent($resa->owner_decision_date, $ownerName.' refusé la réservation.', $resa->id, true);
            }else{
                $events[] = $this->createEvent($resa->owner_decision_date, $ownerName.' accepté la réservation.', $resa->id);
            }
        }

        //OSCAR deny
        if($resa->status == "denied_by_staff"){
            $events[] = $this->createEvent($resa->owner_decision_date, 'Oscar.fr a refusé la réservation.', $resa->id, true);
        }

        //asker paiement
        if($resa->payIn && $resa->payIn->status =="SUCCEEDED"){
            $events[] = $this->createEvent($resa->payIn->created_at, $userName.' payé et confirmé la réservation.', $resa->id);
        }

        //annulations
        if($resa->status == "canceled_by_user"){
            $events[] = $this->createEvent($resa->updated_at, $userName.' annulé la réservation.', $resa->id,true);
        }
        if($resa->status == "canceled_by_owner"){
            $events[] = $this->createEvent($resa->updated_at, $ownerName.' annulé la réservation.', $resa->id,true);
        }

        //time cancel
        if($resa->status == "time_canceled"){
            $events[] = $this->createEvent($resa->updated_at, 'Annulation automatique : la validation ou le paiement de la réservation n\'a pas été effectué à temps.', $resa->id,true);
        }

        //done
        if($resa->status == "done"){
            $events[] = $this->createEvent($resa->date_begin,'La réservation a été effectuée !' , $resa->id);
        }
        
        return $events;
    }

    private function createEvent($date, $content, $id, $danger=false){
        $test = new stdClass;
        $test->created_at = new Carbon($date);
        $test->content = $content;
        $test->reservation_id = $id;            
        if($danger){
            $test->danger = $danger;
        }
        return $test;
    }

    private function setRedMessages($messages, $userId){
        foreach ($messages as $key => $m) {
            if($m->author_id != $userId){
                $m->red = true;
                $m->save();
            }
        }
    }

    private function isNewMessageAvaible($messages){
        if($messages->count()<2) return true;
        return !( ($messages->get( $messages->count()-2 )->author_id == $messages->last()->author_id) && ( $messages->last()->asker_id== $messages->last()->author_id) );
    }

    private function contentValidator(array $data){
        return Validator::make($data,[
            'content'=>'required|max:255|not_contains'
            ],[
            'required'=>'Impossible d\'envoyer un message vide.',
            'not_contains'=>'Votre message contient des mots interdits...'
            ]);
    }

    private function hideBannedWords($message){
        $words = Lang::get('bannedWords');
        foreach($words as $word){
            $regex = '/^'.$word.'[^a-z]|^'.$word.'s[^a-z]|[^a-z]+'.$word.'[^a-z]|[^a-z]+'.$word.'s[^a-z]|[^a-z]'.$word.'$|[^a-z]'.$word.'s$/i';
            $message = preg_replace($regex, " **** ", $message);
        }
        return $message;
    }
    
}
