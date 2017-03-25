<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;
use App\Country;
use Validator;
use App\Http\Requests;
use App\User;
use App\UserDetail;
use App\UserRole;
use App\Organization;
use App\Traits\MangoPayTrait;
use App\ProviderUser;
use App\UserPhone;

class UserDetailController extends Controller
{
    use MangoPayTrait;
    //
    public function __construct(){
    	$this->middleware(['auth','role:confirmed']);
    }

    protected function validator(array $data)
    {
    	$params = [
            'firstName' => 'required',
            'lastName'  => 'required',
            'birthday' => 'required|max:255',
            'nationality' => 'required|max:255',
            'addressLine1' => 'required|max:255',
            'addressPostalCode' => 'required',
            'addressCity' => 'required|max:255'
        ];
        if(isset($data['iamlegal'])){
        	$params = array_merge($params,[
        		'organizationname' => 'required|max:255',
        		'headQuartersAddressLine1' => 'required|max:255',
        		'headQuartersAddressPostalCode' => 'required',
        		'headQuartersAddressCity' => 'required|max:255'
        		]);
        }
        return Validator::make($data, $params);
    }

    public function create(Request $req){
        $name = App::getLocale() == 'fr' ? 'nom_fr_fr' : 'nom_en_gb';
    	$paysC = Country::all(['alpha2',$name]);
        $paysCodes = array();
        foreach($paysC as $pc){
            $paysCodes[$pc->alpha2] = $pc->$name;
        }
    	$details = UserDetail::findOrCreate($req->user()->id);
        $orga = Organization::findOrCreate( $details->organization );
    	return view('auth.details',['paysCodes'=>$paysCodes,'user'=>$req->user() ,'details'=>$details, 'orga'=>$orga])
            ->with('error',$req->session()->get('error'))
            ->with('message', $req->session()->get('message'));
    }

    private function updateRole($userId){
        $role = UserRole::find($userId);
        if($role->role == 'confirmed'){
            $role->role = 'light';
            $role->save();
        }
    }

    public function store(Request $req){
    	$validator = $this->validator($req->all());
    	if($validator->fails()){
    		return redirect('/userdetails')->withErrors($validator)->withInput();
    	}else{
    		//create or update user details
            $input = $req->all();

    		$details = UserDetail::findOrCreate($req->user()->id);
            $input['birthday'] = strtotime($input['birthday']);
            $input['countryOfResidence'] = 'FR';
            $input['addressCountry'] = 'FR';

            //organization update (if legal user)
            $orga = null;
            if( $details->type == 'legal' ){
                $input['name'] = $input['organizationname'];
                $input['headQuartersAdressCountry'] = 'FR';
                if( $details->organization ){ //organization exists
                    $orga = Organization::find($details->organization );
                }else{
                    $orga = new Organization();
                    $orga->save();
                }
                $orga->update($input);
                $orga->type = $input['orgaType'];
                $orga->email = $req->user()->email;
                $orga->save();
                $details->organization = $orga->id;
            }else{
                $input['type'] = 'natural';
            }
            $details->update($input);

            //modify user himself
            $user = $req->user();
            $user->firstName = $req->firstName;
            $user->lastName = $req->lastName;
            if($user->email != $req->email){ //mail change => check provider users
                $check = ProviderUser::where('user_id',$user->id)->count();
                if($check>0) return redirect()->back()->withErrors(['fromProvider'=>true]);
                $user->email = $req->email;
            }


            $details->save();
            $user->save();
            

            //Create or update mangoPay user data
            $this->createOrUpdateUser($user,$details,$orga);
            $this->updateRole($user->id);

            //phone
            $phone = $user->phone;
            if(!$phone){
                $phone = new UserPhone(['user_id'=>$user->id]);
            }

            if($req->has('noPhone')){
                $phone->phone = 'noPhone';
                $phone->save();
            }else{
                $phone->phone = $req->phone;
                $phone->save();
            }
            

    		return redirect('/home')->with('message',trans('userdetails.updateOK'));
    	}
    }
}
