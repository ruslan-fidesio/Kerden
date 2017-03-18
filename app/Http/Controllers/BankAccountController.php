<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Traits\MangoPayTrait;
use App\MangoBankAccount;
use Validator;

class BankAccountController extends Controller
{
    use MangoPayTrait;
    //
    public function __construct(){
    	$this->middleware(['auth','role:light']);
    }

    private function validator($data){
        $params = [
            'iban'=>'required',
            'bic'=>'required'
        ];
        return Validator::make($data, $params);
    }

    public function create(Request $req){
        if(!$req->user()->mangoUser){
            return redirect('/home')->with('error','Opération impossible : <a href="/userdetails">Renseignez d\'abord vos coordonnées</a>');
        }
        $mangoId = $req->user()->mangoUser->mangoUserId;

        $accounts  = $this->getBankAccounts($mangoId);

        $active = !empty($req->user()->mangoBankAccount)?$req->user()->mangoBankAccount->account_id:0;
        return view('auth.bankAccounts',['user'=>$req->user(),'accounts'=>$accounts,'active'=>$active]);
    }

    public function addNewForm(Request $req){
        return view('admin.addBankAccount',['user'=>$req->user()]);
    }

    public function addNewAccount(Request $req){
    	$validator = $this->validator($req->all());
        if($validator->fails()){
            return redirect('/addBankAccount')->withErrors($validator)->withInput();
        }

        $mangoId = $req->user()->mangoUser->mangoUserId;
        $res = $this->createBankAccount($mangoId,$req->user()->details, $req->user()->fullName, $req->iban, $req->bic);
        return redirect('/rib');
    }

    public function setActive(Request $req){
    	if(!$req->has('account_id')) return redirect()->back();
        $account = MangoBankAccount::firstOrCreate(['user_id'=>$req->user()->id]);
        $account->account_id = $req->account_id;
        $account->save();
        return redirect()->back();
    }


}
