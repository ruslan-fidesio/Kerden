<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Validator;
use App\Reservation;
use App\Garden;
use App\Commentaire;
use App\KerdenMailer;
use App\Answer;

class CommentController extends Controller
{

    protected function getCommentValidator(array $data)
    {
    	$params = [
    		'reservationId' => 'required',
            'content' => 'required',
            'note'	=> 'required'
        ];
        return Validator::make($data, $params);
    }

    protected function getAnswerValidator(array $data)
    {
        $params = [
            'commentId' => 'required',
            'content' => 'required',
        ];
        return Validator::make($data, $params);
    }

    public function postComment(Request $req){
    	$validator = $this->getCommentValidator($req->all());
    	if($validator->fails()){
    		return redirect()->back()->withErrors($validator)->withInput();
    	}
    	
    	$resa = Reservation::findOrFail($req->reservationId);
    	if($resa->user->id != $req->user()->id){
    		return redirect('/home')->with('error','Cette réservation n\'est pas la votre');
    	}
    	if($resa->commentaire != null ){
    		return redirect('/home')->with('error','Vous avez déjà commenté cette réservation');
    	}

    	$com = new Commentaire(['user_id'=>$req->user()->id,
    		'reservation_id'=>$resa->id,
    		'garden_id'=>$resa->garden->id,
    		'content'=>$req->content,
    		'note'=>$req->note*2]);
    	$com->save();

    	KerdenMailer::mailNoReply($resa->garden->owner->email,'postComment',['reservation'=>$resa]);

    	return redirect('/reservation/view/'.$resa->id);
    	
    }

    public function postAnswer(Request $req){
        $validator = $this->getAnswerValidator($req->all());
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $com = Commentaire::findOrFail($req->commentId);
        if($com->reservation->garden->owner->id != $req->user()->id){
            return redirect('/home')->with('error','Cette réservation n\'est pas dans votre jardin');
        }
        if($com->answer != null){
            return redirect('/home')->with('error','Vous avez déjà répondu à ce commentaire');
        }

        $answer = new Answer(['commentaire_id'=>$req->commentId,
            'user_id'=>$req->user()->id,
            'content'=>$req->content]);
        $answer->save();

        return redirect()->back();

    }

    public function report(Request $req){
        if($req->has('reporttype') && $req->has('reportid')){
            $toReport = null;
            if($req->reporttype == 'comment'){
                $toReport = Commentaire::find($req->reportid);
            }else{
                $toReport = Answer::find($req->reportid);
            }

            if($toReport != null){
                $toReport->reported = 1;
                $toReport->save();
                KerdenMailer::mailNoReply(env('KERDEN_ADMIN_MAIL'),'reportComment',['toReport'=>$toReport]);
            }

        }

        return redirect()->back();
    }
}
