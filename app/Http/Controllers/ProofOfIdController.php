<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Traits\MangoPayTrait;
use App\KYCDocument;
use App\User;
use App\Organization;

class ProofOfIdController extends Controller
{
    use MangoPayTrait;
    //
    public function __construct(){
    	$this->middleware(['auth','role:light']);
    }

    public function entryPoint(Request $req){
        if($req->user()->mangoUser){
            if($req->user()->advancedDetails || $req->user()->details->type == 'legal'){
                return $this->create($req);
            }else{
                $req->session()->put('backToProof',true);
                return redirect('/user/advancedDetails');
            }
        }
        else{
            return redirect()->back()->with('error','Opération impossible : <a href="/userdetails">Renseignez d\'abord vos coordonnées</a>');
        }
    }

    private function getDocumentByStatusOrder ($docsArray) {
        //first get the valid
        foreach ($docsArray as $key => $value) {
            if ($value->Status == "VALIDATED") return $value;
        }
        //if no valid, get the asked
        foreach ($docsArray as $key => $value) {
            if ($value->Status == "VALIDATION_ASKED") return $value;
        }
        //if no asked, get the refused (ie the first one)
        return array_pop($docsArray);
    }

    public function create(Request $req){
        if (isset($req->userFromAdmin)){
            $user = $userFromAdmin = $req->userFromAdmin;
        } else {
            $user = $req->user();
            $userFromAdmin=null;
        }
        if ($user->details->type == 'legal') {
            $kycDocuments = $this->getKYCDocumentsByUser($user->mangoUser->mangoUserId);

            $statusFile = array_filter($kycDocuments, function ($item) {
                return $item->Type == "ARTICLES_OF_ASSOCIATION";
            });
            $kbisFile = array_filter($kycDocuments, function ($item) {
                return $item->Type == "REGISTRATION_PROOF";
            });
            $shareHoldFile = array_filter($kycDocuments, function ($item) {
                return $item->Type == "SHAREHOLDER_DECLARATION";
            });

            $statusFile = $this->getDocumentByStatusOrder($statusFile);
            $kbisFile = $this->getDocumentByStatusOrder($kbisFile);
            $shareHoldFile = $this->getDocumentByStatusOrder($shareHoldFile);

            $orga = Organization::findOrFail($user->details->organization);

            return view('auth.proofOfId', [
                'statusFile'=>$statusFile,
                'kbisFile'=>$kbisFile,
                'shareHoldFile'=>$shareHoldFile,
                'organization'=>$orga,
                'userFromAdmin'=>$userFromAdmin
            ]);
        }
        else {
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
    }

    public function send(Request $req){
    	if($req->hasFile('proofOfId')){
    		$file = $req->file('proofOfId');
            $fileType = "IDENTITY_PROOF";
        } elseif ($req->hasFile('status')) {
            $file = $req->file('status');
            $fileType = "ARTICLES_OF_ASSOCIATION";
        } elseif ($req->hasFile('kbis')) {
            $file = $req->file('kbis');
            $fileType = "REGISTRATION_PROOF";
        } elseif ($req->hasFile('sharehold')) {
            $file = $req->file('sharehold');
            $fileType = "SHAREHOLDER_DECLARATION";
        }
        else {
            return redirect()->back()->with('error','Erreur envoi fichier');
        }

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
		$res = $this->createKYCDocument($userId,$fileType);
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

    public function adminCreate($id, Request $req){
    	$user = User::find($id);
        $req->userFromAdmin = $user;
        return $this->create($req);
    	//$docs = KYCDocument::where('user_id',$id)->get();
    	//return view('auth.proofOfId',['userFromAdmin'=>$user,'docs'=>$docs]);
    }


}
