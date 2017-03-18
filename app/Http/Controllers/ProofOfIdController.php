<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Traits\MangoPayTrait;
use App\KYCDocument;
use App\User;

class ProofOfIdController extends Controller
{
    use MangoPayTrait;
    //
    public function __construct(){
    	$this->middleware(['auth','role:light']);
    }

    public function entryPoint(Request $req){
        if($req->user()->mangoUser){
            if($req->user()->advancedDetails){
                return $this->create($req);
            }else{
                $req->session()->put('backToProof',true);
                return redirect('/user/advancedDetails');
            }
        }
        else{
            return redirect('/home')->with('error','Opération impossible : <a href="/userdetails">Renseignez d\'abord vos coordonnées</a>');
        }
    }

    public function create(Request $req){
    	//check if a KYCDoc is already valid
    	$test = KYCDocument::where('user_id',$req->user()->id)->where('state','valid')->count();
    	if($test>0){
    		return redirect('/userdetails')->withError('Votre identité est déjà prouvée! profitez de Kerden.fr sans limitations!');
    	}
    	//check asked docs
    	$test = KYCDocument::where('user_id',$req->user()->id)->where('state','asked')->count();
    	if($test>0){
    		return redirect('/userdetails')->withError('Vous avez récemment envoyé un document. Merci d\'attendre la validation ou le refus de celui-ci avant d\'en envoyer un autre.');
    	}
    	return view('auth.proofOfId');
    }

    public function send(Request $req){
    	if($req->hasFile('proofOfId')){
    		$file = $req->file('proofOfId');
    		//test file size
    		if($file->getClientSize() > 7000000){
    			return redirect('/home')->with('error','Erreur envoi fichier : fichier trop lourd!');
    		}
    		if($req->has('userIdFromAdmin')){
    			$user = User::find($req->userIdFromAdmin);
    			$userId = $user->mangoUser->mangoUserId;
    		}else{
    			$userId = $req->user()->mangoUser->mangoUserId;
    		}

    		//create KYCDocument
    		$res = $this->createKYCDocument($userId,"IDENTITY_PROOF");
    		$KYCDocumentId = $res->Id;

    		//upload file as KYCPage
    		$res2 = $this->createKYCPage($userId,$KYCDocumentId, $file);

    		//edit KYCDocument to submit it
    		$this->updateKYCDocument($userId,$KYCDocumentId,"VALIDATION_ASKED");

    		//store this in BDD
    		$storedDoc = new KYCDocument();
    		$storedDoc->user_id = $req->user()->id;
    		$storedDoc->ressource_id = $KYCDocumentId;
    		$storedDoc->state = 'asked';
    		$storedDoc->save();
    		return redirect('/home')->with('message','Envoi fichier ok');
    	}
    	return redirect('/home')->with('error','Erreur envoi fichier');
    }

    public function adminCreate($id, Request $req){
    	$user = User::find($id);
    	$docs = KYCDocument::where('user_id',$id)->get();
    	return view('auth.proofOfId',['userFromAdmin'=>$user,'docs'=>$docs]);
    }


}
