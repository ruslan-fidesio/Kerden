<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\UserAdvancedDetails;
use Validator;
use App\Traits\MangoPayTrait;

class UserAdvancedDetailsController extends Controller
{
	use MangoPayTrait;

	private $incomeTab = [1=>'< 18.000€',
						2=>'18.000€ - 30.000€',
						3=>'30.000€ - 50.000€',
						4=>'50.000€ - 80.000€',
						5=>'80.000€ - 120.000€',
						6=>'> 120.000€'];

	protected function validator(array $data)
    {
    	$params = [
            'occupation' => 'required',
            'income_range'=>'required| min:1|max:6'
        ];
        return Validator::make($data, $params);
    }


    public function __construct(){
    	$this->middleware(['auth','role:light']);
    }

    public function create(Request $req){
        if($req->user()->mangoUser){
        	$details = UserAdvancedDetails::firstOrNew(['user_id'=>$req->user()->id]);
        	return view('auth.advancedDetails',['details'=>$details, 'incomeTab'=>$this->incomeTab]);
        }else{
            return redirect('/home')->with('error','Opération impossible : <a href="/userdetails">Renseignez d\'abord vos coordonnées</a>');
        }
    }

    public function store(Request $req){


    	$validator = $this->validator($req->all());
    	if($validator->fails()){
    		return redirect('/user/advancedDetails')->withErrors($validator)->withInput();
    	}
    	$details = UserAdvancedDetails::firstOrNew(['user_id'=>$req->user()->id]);
    	$details->fill($req->all());
    	$details->save();

    	$this->storeAdvancedDetails($req->user(), $details);

    	if($req->session()->has('backToProof')){
    		$req->session()->pull('backToProof');
    		return redirect('/proofOfId');	
    	}
    	return redirect('/home')->with('message','Données enregistrées');
    
    }
}
